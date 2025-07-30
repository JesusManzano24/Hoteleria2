// login_admin.js

// Selecciona el formulario de login de administrador
const adminLoginForm = document.getElementById('adminLoginForm');

adminLoginForm.addEventListener('submit', function(event) {
  event.preventDefault();

  // 1) Leer campos y validar presencia
  const correo   = document.getElementById('adminCorreo').value.trim();
  const password = document.getElementById('adminPassword').value;

  if (!correo || !password) {
    alert('Debes ingresar correo y contraseña de administrador.');
    return;
  }

  // 2) Preparar y enviar payload JSON
  fetch('../php/login_admin.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ correo, password })
  })
  .then(response => {
    // 3) Capturar errores HTTP
    if (!response.ok) {
      return response.text().then(txt => {
        throw new Error(`HTTP ${response.status} ${response.statusText}\n${txt}`);
      });
    }
    // 4) Leer siempre como texto para ver warnings o HTML extra
    return response.text();
  })
  .then(txt => {
    // 5) Mostrar en consola la respuesta cruda
    console.log('>>> RAW login_admin:', txt);

    // 6) Intentar parsear a JSON
    let data;
    try {
      data = JSON.parse(txt);
    } catch (e) {
      throw new Error('Respuesta no es JSON válido: ' + e.message);
    }
    return data;
  })
  .then(data => {
    // 7) Procesar respuesta JSON
    if (data.success) {
      // Login correcto → redirigir al panel de admin
      window.location.href = 'admin.html';
    } else {
      // Mostrar mensaje de error que envió el servidor
      alert(data.error || 'Error de autenticación');
    }
  })
  .catch(error => {
    // 8) Capturar cualquier excepción y mostrar en consola
    console.error('Error al iniciar sesión:', error);
    alert('Hubo un error al iniciar sesión. Revisa la consola para más detalles.');
  });
});

