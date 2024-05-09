// Inisialisasi database
const uniqueID = "dc47fb1e-be9e-41ad-a60d-83b2571cda87";
const token = "X-LARAVEL";
const db = new Dexie(uniqueID);

db.version(1).stores({
    items: "id, data, expiresAt",
});

const IndexedDBManager = {
    addOrUpdateData: async (dataEntry) => {
        const existingEntry = await db.items.get(dataEntry.id);
        const operation = existingEntry ? "put" : "add";
        await db.items[operation](dataEntry);
        return { status: existingEntry ? "updated" : "added", data: dataEntry };
    },

    deleteExpiredData: async () => {
        const now = new Date();
        const expiredKeys = [];

        const expiredEntries = await db.items
            .filter((entry) => new Date(entry.expiresAt) < now)
            .toArray();

        if (!expiredEntries.length) {
            return { status: "no_expired_data" };
        }

        for (const entry of expiredEntries) {
            expiredKeys.push(entry.id);
            await db.items.delete(entry.id);
        }

        return { status: "deleted", expiredKeys };
    },

    deleteDatabase: async () => {
        await db.delete();
    },
};
const CryptoUtils = {
    encryptData: (data, key) => {
        if (key.length === 0) {
            throw new Error("Key length must be greater than 0.");
        }
        let encryptedData = "";
        for (let i = 0; i < data.length; i++) {
            encryptedData += String.fromCharCode(
                data.charCodeAt(i) ^ key.charCodeAt(i % key.length)
            );
        }
        const encodedData = encodeURIComponent(encryptedData);
        return btoa(encodedData);
    },

    decryptData: (encryptedData, key) => {
        if (key.length === 0) {
            throw new Error("Key length must be greater than 0.");
        }
        const decodedData = atob(encryptedData);
        const decryptedData = decodeURIComponent(decodedData);
        let result = "";
        for (let i = 0; i < decryptedData.length; i++) {
            result += String.fromCharCode(
                decryptedData.charCodeAt(i) ^ key.charCodeAt(i % key.length)
            );
        }

        return result;
    },
};

const DataManager = {
    get csrfToken() {
        return document
            .querySelector('meta[name="X-CSRF-TOKEN"]')
            .getAttribute("content");
    },
    async fetchApi({ url, method = "GET", data = null }) {
        const isFormData = data instanceof FormData;
        const headers = new Headers({
            "X-CSRF-TOKEN": this.csrfToken,
            "X-Role": "BE",
            "X-Token": uniqueID,
        });

        const requestOptions = {
            method: method,
            headers: headers,
            cache: "no-store",
            mode: "cors",
        };
        if (method !== "GET") {
            if (isFormData) {
                requestOptions.body = data;
            } else {
                headers.set("Content-Type", "application/json; charset=UTF-8");
                requestOptions.body = JSON.stringify(data);
            }
        } else if (data) {
            const params = new URLSearchParams(data);
            const queryString = params.toString();
            url = queryString ? `${url}?${queryString}` : url;
        }

        try {
            const response = await fetch(url, requestOptions);
            if (!response.ok) {
                if (
                    !response.ok &&
                    [500, 404, 405, 401, 403].includes(response.status)
                ) {
                    throw new Error(
                        `HTTP Error: ${response.status} - ${response.statusText}`
                    );
                }
            }
            return await response.json();
        } catch (error) {
            console.error("Fetch request error:", error);
            throw error;
        }
    },
    withRetry: async (fn, maxRetries = 3, delayMs = 500, ...args) => {
        let attempts = 0;
        while (attempts < maxRetries) {
            try {
                return await fn(...args);
            } catch (err) {
                console.log(
                    `Attempt #${++attempts} failed. Retrying in ${delayMs}ms...`
                );
                if (attempts === maxRetries) {
                    console.error("Max retries reached. Rejecting...");
                    throw err;
                }
                await new Promise((resolve) => setTimeout(resolve, delayMs));
                delayMs *= 2;
            }
        }
    },
    fetchData(url, data = {}) {
        return this.withRetry(this.fetchApi, 3, 500, { url, data });
    },

    postData(url, data) {
        return this.fetchApi({
            url,
            method: "POST",
            data: { ...data, _token: this.csrfToken },
        });
    },

    putData(url, data) {
        return this.fetchApi({
            url,
            method: "PUT",
            data: { ...data, _token: this.csrfToken },
        });
    },

    deleteData(url) {
        return this.fetchApi({
            url,
            method: "DELETE",
            data: { _token: this.csrfToken },
        });
    },
    formData: (url, data, method) => {
        return DataManager.fetchApi({ url, method, data: data });
    },

    loadData: async (url) => {
        try {
            const data = await DataManager.fetchApi({ url, method: "GET" });
            return data;
        } catch (error) {
            console.error("Error loading data:", error);
            throw error;
        }
    },

    loadDataWithRetry: async (url) => {
        return await DataManager.withRetry(DataManager.loadData, 3, 500, url);
    },

    executeOperations: async (
        primary,
        url,
        expirationDurationInSeconds = 120
    ) => {
        const expirationDate = new Date(
            Date.now() + expirationDurationInSeconds * 1000
        );
        const dataEntry = {
            id: primary,
            data: null,
            expiresAt: expirationDate.toISOString(),
        };

        try {
            await IndexedDBManager.deleteExpiredData();
            const existingEntry = await db.items.get(primary);
            if (
                existingEntry &&
                new Date(existingEntry.expiresAt) > new Date()
            ) {
                return JSON.parse(
                    CryptoUtils.decryptData(
                        existingEntry.data,
                        primary + "-" + token
                    )
                );
            } else {
                const fetchedData = await DataManager.loadDataWithRetry(url);
                if (!fetchedData) {
                    console.warn("Fetched data is empty. Returning null.");
                    return [];
                }
                dataEntry.data = CryptoUtils.encryptData(
                    JSON.stringify(fetchedData),
                    primary + "-" + token
                );
                await IndexedDBManager.addOrUpdateData(dataEntry);
                return JSON.parse(
                    CryptoUtils.decryptData(
                        dataEntry.data,
                        primary + "-" + token
                    )
                );
            }
        } catch (error) {
            console.error("An error occurred during execution:", error);
            throw error;
        }
    },
};
