(function () {
  const form = document.getElementById('loginForm');
  if (!form) return;

  const username = document.getElementById('username');
  const password = document.getElementById('password');
  const clientError = document.getElementById('clientError');

  function showError(message) {
    clientError.innerHTML = '<div class="alert alert-danger" role="alert" style="margin:0 0 1rem 0;">' + message + '</div>';
  }
  function clearError() {
    clientError.innerHTML = '';
  }

  form.addEventListener('submit', function (e) {
    clearError();

    const userVal = username.value.trim();
    const passVal = password.value;

    if (userVal === '') {
      e.preventDefault();
      showError('El campo "Usuario" no puede estar vacío.');
      username.focus();
      return false;
    }

    if (passVal === '') {
      e.preventDefault();
      showError('El campo "Contraseña" no puede estar vacío.');
      password.focus();
      return false;
    }

    

    // Si pasa validación cliente, permitir submit (servidor validará también)
    return true;
  });

  // Limpiar mensaje cliente al escribir
  username.addEventListener('input', clearError);
  password.addEventListener('input', clearError);
})();
