/**
 * Frontend validáció minden formra
 * - kötelező mezők ellenőrzése
 * - number típus ellenőrzés
 * - minimum, maximum érték
 * - e-mail formátum
 * - dátum validáció (nem lehet jövőbeli)
 * 
 * Minden form submit előtt végigellenőrzi az összes input mezőt.
 */

document.addEventListener("DOMContentLoaded", function () {

    // Minden form figyelése az oldalon
    document.querySelectorAll("form").forEach(form => {

        // Valós idejű ellenőrzés mező fókuszvesztéskor
        form.querySelectorAll("input, select, textarea").forEach(field => {
            
            field.addEventListener("blur", function () {
                validateField(field);
            });

            field.addEventListener("input", function () {
                // Ha a user gépel, akkor automatikusan eltűnik a piros keret
                field.classList.remove("is-invalid");
            });
        });

        // Submit esemény kezelése
        form.addEventListener("submit", function (e) {
            let valid = true;

            form.querySelectorAll("input, select, textarea").forEach(field => {
                if (!validateField(field)) {
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
                alert("Hibás vagy hiányzó adat található az űrlapban. Kérlek javítsd!");
            }
        });
    });
});

/**
 * Egyetlen mező ellenőrzése
 * @param {HTMLElement} field
 * @returns {boolean}
 */
function validateField(field) {

    // Eltávolítjuk az előző hibát
    field.classList.remove("is-invalid");

    // Kötelező mező
    if (field.hasAttribute("required") && !field.value.trim()) {
        markInvalid(field);
        return false;
    }

    // Number mezők ellenőrzése
    if (field.type === "number") {
        let value = parseFloat(field.value);

        if (isNaN(value)) {
            markInvalid(field);
            return false;
        }

        // Minimum
        if (field.hasAttribute("min") && value < parseFloat(field.min)) {
            markInvalid(field);
            return false;
        }

        // Maximum
        if (field.hasAttribute("max") && value > parseFloat(field.max)) {
            markInvalid(field);
            return false;
        }
    }

    // E-mail ellenőrzés
    if (field.type === "email") {
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (field.value && !emailPattern.test(field.value)) {
            markInvalid(field);
            return false;
        }
    }

    // Dátum ellenőrzés – nem lehet jövőbeli
    if (field.type === "date") {
        let today = new Date().setHours(0, 0, 0, 0);
        let inputDate = new Date(field.value).setHours(0, 0, 0, 0);

        if (inputDate > today) {
            markInvalid(field);
            return false;
        }
    }

    // Pattern attribútum figyelembevétele
    if (field.hasAttribute("pattern") && field.value) {
        let regex = new RegExp(field.getAttribute("pattern"));
        if (!regex.test(field.value)) {
            markInvalid(field);
            return false;
        }
    }

    return true;
}

/**
 * Hibás mező megjelölése
 * @param {HTMLElement} field
 */
function markInvalid(field) {
    field.classList.add("is-invalid");
}
