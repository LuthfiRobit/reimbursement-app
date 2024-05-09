class FileValidator {
    constructor() {
        this.config = {
            image: {
                allowed_mime_types: {
                    "image/jpeg": "jpg",
                    "image/png": "png",
                    "image/gif": "gif",
                    "image/bmp": "bmp",
                    "image/webp": "webp",
                    "image/svg+xml": "svg",
                },
                max_file_size: 2097152, // 2MB dalam byte
                unsafe_patterns: [
                    /<\?php/,
                    /<script\b/,
                    /(eval|exec|system|base64_decode|assert|shell_exec|passthru|popen|proc_open)\(/,
                ],
                known_bad_hashes: ["hash1", "hash2", "hash3"],
            },
            file: {
                allowed_mime_types: {
                    "application/pdf": "pdf",
                },
                max_file_size: 10485760, // 10MB dalam byte
                unsafe_patterns: [
                    /<\?php/,
                    /<script\b/,
                    /(eval|exec|system|base64_decode|assert|shell_exec|passthru|popen|proc_open)\(/,
                ],
                known_bad_hashes: ["hash1", "hash2", "hash3"],
            },
        };
    }

    async validateFile(file) {
        const type = this.getFileType(file);
        const config = this.config[type];

        if (!config || !this.isValidFile(file) || file.size > config.max_file_size) {
            return this.denyAccess("File tidak valid atau ukuran file melebihi batas maksimum.");
        }

        if (!this.isAllowedMimeType(file, config)) {
            return this.denyAccess("Ekstensi atau tipe file tidak valid.");
        }

        try {
            const fileHash = await this.calculateFileHash(file);
            if (config.known_bad_hashes.includes(fileHash) || await this.containsUnsafeContent(file, type)) {
                return this.denyAccess("File mengandung konten tidak aman atau hash file diketahui buruk.");
            }
            return {success: true};
        } catch (error) {
            return this.denyAccess("Terjadi kesalahan dalam validasi file.");
        }
    }

    getFileType(file) {
        const extension = file.name.split(".").pop().toLowerCase();
        return this.config.hasOwnProperty(extension) ? extension : "unknown";
    }

    isValidFile(file) {
        return file instanceof File && file.size > 0;
    }

    isAllowedMimeType(file, config) {
        const mimeType = file.type;
        return config.allowed_mime_types.hasOwnProperty(mimeType);
    }

    async calculateFileHash(file) {
        const buffer = await this.readFileAsArrayBuffer(file);
        const hashBuffer = await crypto.subtle.digest("SHA-256", buffer);
        return Array.from(new Uint8Array(hashBuffer))
            .map((b) => b.toString(16).padStart(2, "0"))
            .join("");
    }

    containsUnsafeContent(file, type) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => {
                const content = reader.result;
                for (const pattern of this.config[type].unsafe_patterns) {
                    if (content.match(pattern)) {
                        resolve(true);
                        return;
                    }
                }
                resolve(false);
            };
            reader.onerror = (error) => reject(error);
            reader.readAsText(file);
        });
    }

    denyAccess(reason) {
        return {success: false, message: reason};
    }

    readFileAsArrayBuffer(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => {
                resolve(reader.result);
            };
            reader.onerror = reject;
            reader.readAsArrayBuffer(file);
        });
    }
}
