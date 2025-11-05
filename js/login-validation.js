(function () {
  // --- AÑADIDO: LÓGICA DE PESTAÑAS (TOGGLE) ---
  const toggleToLoginBtn = document.getElementById('toggleToLogin');
  const toggleToRegisterBtn = document.getElementById('toggleToRegister');
  const loginFormContainer = document.getElementById('loginFormContainer');
  const registerFormContainer = document.getElementById('registerFormContainer');

  if (toggleToLoginBtn) {
    toggleToLoginBtn.addEventListener('click', function () {
      if (registerFormContainer.classList.contains('form-hidden')) return; // Ya está activo
      
      loginFormContainer.classList.remove('form-hidden');
      registerFormContainer.classList.add('form-hidden');
      
      toggleToLoginBtn.classList.add('active');
      toggleToRegisterBtn.classList.remove('active');
    });
  }

  if (toggleToRegisterBtn) {
    toggleToRegisterBtn.addEventListener('click', function () {
      if (loginFormContainer.classList.contains('form-hidden')) return; // Ya está activo
      
      registerFormContainer.classList.remove('form-hidden');
      loginFormContainer.classList.add('form-hidden');
      
      toggleToRegisterBtn.classList.add('active');
      toggleToLoginBtn.classList.remove('active');
    });
  }

  // --- VALIDACIÓN DEL LOGIN ---
  const loginForm = document.getElementById('loginForm');
  const clientErrorLogin = document.getElementById('clientErrorLogin');

  function showLoginError(message) {
    if(clientErrorLogin) clientErrorLogin.innerHTML = '<div class="alert alert-danger" role="alert" style="margin:0 0 1rem 0;">' + message + '</div>';
  }
  function clearLoginError() {
    if(clientErrorLogin) clientErrorLogin.innerHTML = '';
  }

  if (loginForm) {
    const username = document.getElementById('username');
    const password = document.getElementById('password');

    loginForm.addEventListener('submit', function (e) {
      clearLoginError();
      const userVal = username.value.trim();
      const passVal = password.value;

      if (userVal === '') {
        e.preventDefault();
        showLoginError('El campo "Usuario" no puede estar vacío.');
        username.focus();
        return false;
      }

      if (passVal === '') {
        e.preventDefault();
        showLoginError('El campo "Contraseña" no puede estar vacío.');
        password.focus();
        return false;
      }
      return true;
    });

    username.addEventListener('input', clearLoginError);
    password.addEventListener('input', clearLoginError);
  }

  // --- AÑADIDO: VALIDACIÓN DEL REGISTRO ---
  const registerForm = document.getElementById('registerForm');
  const clientErrorRegister = document.getElementById('clientErrorRegister');

  function showRegisterError(message) {
    if(clientErrorRegister) clientErrorRegister.innerHTML = '<div class="alert alert-danger" role="alert" style="margin:0 0 1rem 0;">' + message + '</div>';
  }
  function clearRegisterError() {
    if(clientErrorRegister) clientErrorRegister.innerHTML = '';
  }

  if (registerForm) {
    const regNom = document.getElementById('reg_nom');
    const regUsername = document.getElementById('reg_username');
    const regEmail = document.getElementById('reg_email');
    const regPassword = document.getElementById('reg_password');
    const regPasswordConfirm = document.getElementById('reg_password_confirm');
    
    // Simple regex para email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    registerForm.addEventListener('submit', function (e) {
      clearRegisterError();

      // 1. Validar campos vacíos
      if (regNom.value.trim() === '') {
        e.preventDefault(); showRegisterError('El campo "Nombre" es obligatorio.'); regNom.focus(); return false;
      }
      if (regUsername.value.trim() === '') {
        e.preventDefault(); showRegisterError('El campo "Usuario" es obligatorio.'); regUsername.focus(); return false;
      }
      if (regEmail.value.trim() === '') {
        e.preventDefault(); showRegisterError('El campo "Email" es obligatorio.'); regEmail.focus(); return false;
      }
      if (regPassword.value === '') {
        e.preventDefault(); showRegisterError('El campo "Contraseña" es obligatorio.'); regPassword.focus(); return false;
      }
      if (regPasswordConfirm.value === '') {
        e.preventDefault(); showRegisterError('Debes confirmar la contraseña.'); regPasswordConfirm.focus(); return false;
      }

      // 2. Validar formato de email
      if (!emailRegex.test(regEmail.value.trim())) {
        e.preventDefault(); showRegisterError('El formato del email no es válido.'); regEmail.focus(); return false;
      }

      // 3. Validar longitud de contraseña
      if (regPassword.value.length < 6) {
        e.preventDefault(); showRegisterError('La contraseña debe tener al menos 6 caracteres.'); regPassword.focus(); return false;
      }

      // 4. Validar que contraseñas coinciden
      if (regPassword.value !== regPasswordConfirm.value) {
        e.preventDefault(); showRegisterError('Las contraseñas no coinciden.'); regPasswordConfirm.focus(); return false;
      }

      return true; // Si todo está bien, enviar formulario
    });

    // Limpiar errores al escribir
    regNom.addEventListener('input', clearRegisterError);
    regUsername.addEventListener('input', clearRegisterError);
    regEmail.addEventListener('input', clearRegisterError);
    regPassword.addEventListener('input', clearRegisterError);
    regPasswordConfirm.addEventListener('input', clearRegisterError);
  }

  // --- AÑADIDO: Mostrar la pestaña correcta si hay un error ---
  // Si la URL tiene ?form=register, muestra el formulario de registro al cargar
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('form') === 'register' || urlParams.has('register_success')) {
    if(toggleToRegisterBtn) toggleToRegisterBtn.click();
  }

})();