function openModal(button) {
    const modal = document.getElementById('monsterModal');
    
    document.getElementById('modalName').textContent = button.dataset.name;
    document.getElementById('modalImg').src = button.dataset.img;
    document.getElementById('modalImg').alt = button.dataset.name;
    document.getElementById('modalDesc').textContent = button.dataset.desc;

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('monsterModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

window.onclick = function(event) {
    const modal = document.getElementById('monsterModal');
    if (event.target == modal) {
        closeModal();
    }
}

const form = document.querySelector(".auth-form");

if (form) {
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmedPasswordInput = form.querySelector('input[name="confirmedPassword"]');

    function validatePasswordStrength(password) {
        return {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /\d/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };
    }

    function updateRule(id, valid) {
        const rule = document.getElementById(id);

        if (rule) {
            rule.classList.toggle("valid", valid);
        }
    }

    function markValidation(element, condition) {
        if (!element) return;

        element.classList.toggle("no-valid", !condition);
    }

    function validatePassword() {
        const rules = validatePasswordStrength(passwordInput.value);

        updateRule("length", rules.length);
        updateRule("uppercase", rules.uppercase);
        updateRule("lowercase", rules.lowercase);
        updateRule("number", rules.number);
        updateRule("special", rules.special);

        const passwordValid = Object.values(rules).every(Boolean);
        markValidation(passwordInput, passwordValid);

        if (confirmedPasswordInput.value.length > 0) {
            const passwordsMatch =
                passwordInput.value === confirmedPasswordInput.value;

            markValidation(confirmedPasswordInput, passwordsMatch);
        } else {
            confirmedPasswordInput.classList.remove("no-valid");
        }
    }

    passwordInput.addEventListener("input", validatePassword);
    confirmedPasswordInput.addEventListener("input", validatePassword);
}