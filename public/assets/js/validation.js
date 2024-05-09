class ValidationErrorFilter {
    constructor(prefix) {
        this.prefix = prefix || "";
    }

    filterValidationErrors(responseData) {
        const validationErrors = new Set();
        for (const key in responseData.errors) {
            if (responseData.errors.hasOwnProperty(key)) {
                const errorMessages = responseData.errors[key];
                const inputElement = document.getElementById(this.prefix + key);
                if (inputElement) {
                    const errorListElement = document.createElement("ul");
                    errorListElement.classList.add("error-list", "list-unstyled", "text-danger");
                    errorMessages.forEach(errorMessage => {
                        const listItem = document.createElement("li");
                        listItem.textContent = errorMessage;
                        errorListElement.appendChild(listItem);
                        validationErrors.add(errorMessage);
                    });
                    const previousErrorList = inputElement.nextElementSibling;
                    if (previousErrorList && previousErrorList.classList.contains("error-list")) {
                        previousErrorList.remove();
                    }
                    inputElement.parentNode.insertBefore(errorListElement, inputElement.nextSibling);
                } else {
                    console.error(`Input element not found for id ${this.prefix + key}.`);
                }
            }
        }
        return Array.from(validationErrors);
    }
}
