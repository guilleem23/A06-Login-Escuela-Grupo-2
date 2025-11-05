document.addEventListener("DOMContentLoaded", function() {

    console.log("login-validation.js cargado");

    // --- 1. Selectores de Elementos ---
    
    // Contenedores y botones de pestañas
    const toggleToLoginBtn = document.getElementById('toggleToLogin');
    const toggleToRegisterBtn = document.getElementById('toggleToRegister');
    const loginFormContainer = document.getElementById('loginFormContainer');
    const registerFormContainer = document.getElementById('registerFormContainer');
    
    // --- Formulario de Login ---
    const loginForm = document.getElementById('loginForm');
    const loginUsername = document.getElementById('username');
    const loginPassword = document.getElementById('password');
    // Contenedores de error
    const loginUsernameError = loginUsername ? loginUsername.nextElementSibling : null;
    const loginPasswordError = loginPassword ? loginPassword.nextElementSibling : null;
    const loginErrorContainer = document.getElementById('clientErrorLogin');

    // --- Formulario de Registro ---
    const registerForm = document.getElementById('registerForm');
    const regNom = document.getElementById('reg_nom');
    const regCognoms = document.getElementById('reg_cognoms');
    const regEdad = document.getElementById('reg_edad');
    const regUsername = document.getElementById('reg_username');
    const regEmail = document.getElementById('reg_email');
    const regPassword = document.getElementById('reg_password');
    const regPasswordConfirm = document.getElementById('reg_password_confirm');
    // Contenedores de error
    const regNomError = regNom ? regNom.nextElementSibling : null;
    const regCognomsError = regCognoms ? regCognoms.nextElementSibling : null;
    const regEdadError = regEdad ? regEdad.nextElementSibling : null;
    const regUsernameError = regUsername ? regUsername.nextElementSibling : null;
    const regEmailError = regEmail ? regEmail.nextElementSibling : null;
    const regPasswordError = regPassword ? regPassword.nextElementSibling : null;
    const regPasswordConfirmError = regPasswordConfirm ? regPasswordConfirm.nextElementSibling : null;
    const registerErrorContainer = document.getElementById('clientErrorRegister');

    // Regex
    const emailRegex = /^\S+@\S+\.\S+$/;

    // --- 2. Lógica de Pestañas (Toggle) ---

    function showLoginForm() {
        toggleToLoginBtn.classList.add('active');
        toggleToRegisterBtn.classList.remove('active');
        loginFormContainer.classList.remove('form-hidden');
        registerFormContainer.classList.add('form-hidden');
        if (registerErrorContainer) registerErrorContainer.innerHTML = '';
        const registerAlert = registerFormContainer.querySelector('.alert');
        if (registerAlert) registerAlert.style.display = 'none';
    }

    function showRegisterForm() {
        toggleToLoginBtn.classList.remove('active');
        toggleToRegisterBtn.classList.add('active');
        loginFormContainer.classList.add('form-hidden');
        registerFormContainer.classList.remove('form-hidden');
        if (loginErrorContainer) loginErrorContainer.innerHTML = '';
        const loginAlert = loginFormContainer.querySelector('.alert');
        if (loginAlert) loginAlert.style.display = 'none';
    }

    if (toggleToLoginBtn) toggleToLoginBtn.addEventListener('click', showLoginForm);
    if (toggleToRegisterBtn) toggleToRegisterBtn.addEventListener('click', showRegisterForm);
    
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('form') === 'register' || urlParams.has('register_success') || (urlParams.has('error') && urlParams.has('form'))) {
        showRegisterForm();
    } else {
        showLoginForm();
    }


    // --- 4. Funciones Auxiliares de Validación ---

    /** Muestra un error específico del campo */
    function showFieldError(inputElement, errorElement, message) {
        if (errorElement) errorElement.textContent = message;
        if (inputElement) inputElement.classList.add('invalid');
    }

    /** Limpia el error específico del campo */
    function clearFieldError(inputElement, errorElement) {
        if (errorElement) errorElement.textContent = '';
        if (inputElement) inputElement.classList.remove('invalid');
    }
    
    /** Muestra un error general del formulario (en el div .alert) */
    function showFormError(container, message) {
        if (container) {
            container.innerHTML = `<div class="alert alert-danger" role="alert" style="margin:0 0 1rem 0;">${message}</div>`;
        }
    }

    // --- 5. Funciones de Validación Específicas (Registro) ---
    // Estas funciones devuelven `true` si es válido, `false` si es inválido.
    // Validan formato y longitud, pero marcan "vacío" como válido (eso se revisa en el submit)
    // EXCEPTO para los campos obligatorios donde el formato no aplica (fecha).

    function validateNom() {
        const value = regNom.value.trim();
        if (value.length > 50) {
            showFieldError(regNom, regNomError, 'El nombre no puede tener más de 50 caracteres.');
            return false;
        }
        clearFieldError(regNom, regNomError);
        return true;
    }

    function validateCognoms() {
        const value = regCognoms.value.trim();
        if (value.length > 80) {
            showFieldError(regCognoms, regCognomsError, 'Los apellidos no pueden tener más de 80 caracteres.');
            return false;
        }
        clearFieldError(regCognoms, regCognomsError);
        return true;
    }
    
    function validateRegUsername() {
        const value = regUsername.value.trim();
        if (value.length > 50) {
            showFieldError(regUsername, regUsernameError, 'El usuario no puede tener más de 50 caracteres.');
            return false;
        }
        clearFieldError(regUsername, regUsernameError);
        return true;
    }
    
    function validateEmail() {
        const value = regEmail.value.trim();
        if (value && !emailRegex.test(value)) { // Solo valida si NO está vacío
            showFieldError(regEmail, regEmailError, 'El formato del email no es válido.');
            return false;
        }
        if (value.length > 60) {
            showFieldError(regEmail, regEmailError, 'El email no puede tener más de 60 caracteres.');
            return false;
        }
        clearFieldError(regEmail, regEmailError);
        return true;
    }
    
    function validatePassword() {
        const value = regPassword.value;
        if (value && value.length < 6) { // Solo valida si NO está vacío
            showFieldError(regPassword, regPasswordError, 'La contraseña debe tener al menos 6 caracteres.');
            return false;
        }
        clearFieldError(regPassword, regPasswordError);
        return true;
    }
    
    function validatePasswordConfirm() {
        const passVal = regPassword.value;
        const confirmVal = regPasswordConfirm.value;
        if (confirmVal && passVal !== confirmVal) { // Solo valida si NO está vacío
            showFieldError(regPasswordConfirm, regPasswordConfirmError, 'Las contraseñas no coinciden.');
            return false;
        }
        clearFieldError(regPasswordConfirm, regPasswordConfirmError);
        return true;
    }
    
    // --- 6. Añadir Listeners de "input" (validación en tiempo real) ---

    if (regNom) regNom.addEventListener('input', validateNom);
    if (regCognoms) regCognoms.addEventListener('input', validateCognoms);
    if (regUsername) regUsername.addEventListener('input', validateRegUsername);
    if (regEmail) regEmail.addEventListener('input', validateEmail);
    if (regPassword) regPassword.addEventListener('input', validatePassword);
    
    // La confirmación de contraseña debe validarse cuando CUALQUIERA de las dos cambia
    if (regPassword) regPassword.addEventListener('input', validatePasswordConfirm);
    if (regPasswordConfirm) regPasswordConfirm.addEventListener('input', validatePasswordConfirm);

    // Validación de Login (solo longitud)
    if (loginUsername) {
        loginUsername.addEventListener('input', () => {
            if (loginUsername.value.length > 50) {
                showFieldError(loginUsername, loginUsernameError, 'El usuario no puede tener más de 50 caracteres.');
            } else {
                clearFieldError(loginUsername, loginUsernameError);
            }
        });
    }

    // --- 7. Validación Final en "submit" ---

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            // Limpiar errores previos
            if (loginErrorContainer) loginErrorContainer.innerHTML = '';
            clearFieldError(loginUsername, loginUsernameError);
            clearFieldError(loginPassword, loginPasswordError);

            const usernameVal = loginUsername.value.trim();
            const passwordVal = loginPassword.value.trim();
            let isValid = true;

            if (usernameVal === '') {
                showFieldError(loginUsername, loginUsernameError, 'El usuario es obligatorio.');
                isValid = false;
            } else if (usernameVal.length > 50) {
                showFieldError(loginUsername, loginUsernameError, 'El usuario no puede tener más de 50 caracteres.');
                isValid = false;
            }
            
            if (passwordVal === '') {
                showFieldError(loginPassword, loginPasswordError, 'La contraseña es obligatoria.');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault(); // Evitar que el formulario se envíe
                showFormError(loginErrorContainer, 'Por favor, corrige los errores.');
            }
        });
    }


    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            // Limpiar error general
            if (registerErrorContainer) registerErrorContainer.innerHTML = '';
            
            // 1. Validar todos los campos (formato/longitud)
            const isValidNom = validateNom();
            const isValidCognoms = validateCognoms();
            const isValidRegUser = validateRegUsername();
            const isValidEmail = validateEmail();
            const isValidPass = validatePassword();
            const isValidPassConfirm = validatePasswordConfirm();

            // 2. Validar campos vacíos (que no se validan en 'input')
            let allFieldsValid = isValidNom && isValidCognoms && isValidRegUser && isValidEmail && isValidPass && isValidPassConfirm;

            if (regNom.value.trim() === '') {
                showFieldError(regNom, regNomError, 'El nombre es obligatorio.');
                allFieldsValid = false;
            }
            if (regCognoms.value.trim() === '') {
                showFieldError(regCognoms, regCognomsError, 'Los apellidos son obligatorios.');
                allFieldsValid = false;
            }
            if (regEdad.value.trim() === '') {
                showFieldError(regEdad, regEdadError, 'La fecha es obligatoria.');
                allFieldsValid = false;
            }
            if (regUsername.value.trim() === '') {
                showFieldError(regUsername, regUsernameError, 'El usuario es obligatorio.');
                allFieldsValid = false;
            }
            if (regEmail.value.trim() === '') {
                showFieldError(regEmail, regEmailError, 'El email es obligatorio.');
                allFieldsValid = false;
            }
            if (regPassword.value === '') {
                showFieldError(regPassword, regPasswordError, 'La contraseña es obligatoria.');
                allFieldsValid = false;
            }
            if (regPasswordConfirm.value === '') {
                showFieldError(regPasswordConfirm, regPasswordConfirmError, 'Debes confirmar la contraseña.');
                allFieldsValid = false;
            }
            
            // 3. Comprobar si algo falló
            if (!allFieldsValid) {
                e.preventDefault(); // Evitar envío
                showFormError(registerErrorContainer, 'Por favor, revisa los campos marcados en rojo.');
            }
        });
    }
});