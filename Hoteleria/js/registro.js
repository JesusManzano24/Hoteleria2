document.addEventListener('DOMContentLoaded', function() {
  // ——————————————————————————————————————————————
  // 1) Configuración inicial y elementos del DOM
  const BASE_PATH = '../../'; // Ruta base para todos los recursos
  let clickCount = 0;
  
  // Elementos del DOM
  const elements = {
    logo: document.getElementById('logo'),
    registroFormContainer: document.getElementById('registroFormContainer'),
    adminLoginFormContainer: document.getElementById('adminLoginFormContainer'),
    registroForm: document.getElementById('registroForm'),
    adminLoginForm: document.getElementById('adminLoginForm'),
    regisAdminBtn: document.getElementById('RegisAdmin'),
    adminOption: document.getElementById('adminOption'),
    tipoUsuarioSelect: document.getElementById('tipo_usuario')
  };

  // ——————————————————————————————————————————————
  // 2) Configuración de debug
  const debugInfo = document.createElement('div');
  debugInfo.className = 'debug-info';
  debugInfo.innerHTML = 'Debug Console:<br>';
  document.body.appendChild(debugInfo);

  function logDebug(message) {
    debugInfo.innerHTML += `${message}<br>`;
    console.log(message);
  }

  // Verificación inicial de elementos
  logDebug('Elementos cargados:');
  Object.entries(elements).forEach(([name, element]) => {
    logDebug(`- ${name}: ${element ? 'OK' : 'No encontrado'}`);
  });

  // ——————————————————————————————————————————————
  // 3) Mostrar formulario de admin con 3 clics en el logo
  if (elements.logo) {
    elements.logo.addEventListener('click', () => {
      clickCount++;
      logDebug(`Clics en logo: ${clickCount}/3`);
      
      if (clickCount === 3) {
        logDebug('Mostrando formulario de admin');
        if (elements.registroFormContainer) elements.registroFormContainer.style.display = 'none';
        if (elements.adminLoginFormContainer) elements.adminLoginFormContainer.style.display = 'block';
        clickCount = 0;
      }
    });
  }

  // ——————————————————————————————————————————————
  // 4) Lógica para el botón "Registrar Administrador"
  function handleAdminRegister(event) {
    event?.preventDefault();
    event?.stopPropagation();
    
    logDebug('Botón Registrar Admin clickeado');
    
    if (!elements.adminOption || !elements.tipoUsuarioSelect || 
        !elements.adminLoginFormContainer || !elements.registroFormContainer) {
      logDebug('ERROR: Faltan elementos requeridos');
      return;
    }

    elements.adminOption.style.display = 'block';
    elements.tipoUsuarioSelect.value = 'Admin';
    elements.adminLoginFormContainer.style.display = 'none';
    elements.registroFormContainer.style.display = 'block';
    
    setTimeout(() => {
      elements.registroFormContainer.scrollIntoView({ behavior: 'smooth' });
    }, 100);

    logDebug('Opción Admin visible');
    logDebug(`Valor seleccionado: ${elements.tipoUsuarioSelect.value}`);
  }

  if (elements.regisAdminBtn) {
    logDebug('Configurando event listener para RegisAdmin');
    elements.regisAdminBtn.addEventListener('click', handleAdminRegister);
  } else {
    logDebug('ERROR: Elemento RegisAdmin no encontrado');
  }

  // ——————————————————————————————————————————————
  // 5) Envío del formulario de registro
  if (elements.registroForm) {
    elements.registroForm.addEventListener('submit', function(event) {
      event.preventDefault();

      // Establecer fecha actual
      document.getElementById('fecha_registro').value = new Date().toISOString().split('T')[0];

      const formData = new FormData(this);

      fetch(`${BASE_PATH}controller/RegistroController.php`, {
        method: 'POST',
        body: formData
      })
      .then(async res => {
        const text = await res.text();
        logDebug('>>> RESPUESTA RAW registro: ' + text);
        
        if (!res.ok) {
          throw new Error(`HTTP ${res.status}: ${text}`);
        }
        
        try {
          return JSON.parse(text);
        } catch (e) {
          throw new Error(`Respuesta no es JSON válido: ${text.substring(0, 100)}...`);
        }
      })
      .then(data => {
        if (!data) throw new Error('No se recibieron datos');
        
        if (data.success) {
          alert('Registro exitoso!');
          window.location.href = '../view/Login/login.html';
        } else {
          alert(`Error en el registro: ${data.error}`);
        }
      })
      .catch(err => {
        console.error('Error completo en registro:', err);
        alert('Error al registrar. Ver detalles en consola.');
      });
    });
  }

  // ——————————————————————————————————————————————
// 6) Envío del formulario de login de administrador (MEJORADO)
  if (elements.adminLoginForm) {
    elements.adminLoginForm.addEventListener('submit', function(event) {
      event.preventDefault();

      const correo = document.getElementById('adminCorreo').value.trim();
      const password = document.getElementById('adminPassword').value;

      if (!correo || !password) {
        showAlert('error', 'Debes ingresar correo y contraseña');
        return;
      }

      // Mostrar carga
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Verificando...';
      submitBtn.disabled = true;

      fetch(`${BASE_PATH}controller/LoginController.php?action=admin`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ correo, password })
      })
      .then(async res => {
        const text = await res.text();
        logDebug('>>> RAW login_admin: ' + text);
        
        if (!res.ok) {
          throw new Error(`HTTP ${res.status}: ${text}`);
        }
        
        try {
          return JSON.parse(text);
        } catch (e) {
          throw new Error(`Respuesta no es JSON válido: ${text.substring(0, 100)}...`);
        }
      })
      .then(data => {
        if (!data) throw new Error('No se recibieron datos del servidor');
        
        if (data.success && data.redirect) {
          showAlert('success', 'Acceso concedido. Redirigiendo...');
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1500);
        } else {
          // Mensajes específicos según el tipo de error
          const errorMessage = data.error.includes('Acceso solo para administradores') 
            ? 'Solo usuarios administradores pueden acceder a esta sección'
            : data.error.includes('Credenciales incorrectas') 
              ? 'Usuario o contraseña incorrectos'
              : 'Error al iniciar sesión. Por favor intenta nuevamente';
          
          showAlert('error', errorMessage);
        }
      })
      .catch(err => {
        console.error('Error completo en login:', err);
        showAlert('error', 'Error al contactar al servidor. Intenta más tarde');
      })
      .finally(() => {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
      });
    });
  }

  // Función para mostrar alertas bonitas
  function showAlert(type, message) {
    // Eliminar alertas previas
    const existingAlerts = document.querySelectorAll('.custom-alert');
    existingAlerts.forEach(alert => alert.remove());

    const alertDiv = document.createElement('div');
    alertDiv.className = `custom-alert ${type}`;
    alertDiv.innerHTML = `
      <span>${message}</span>
      <button onclick="this.parentElement.remove()">&times;</button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto-eliminar después de 5 segundos
    setTimeout(() => {
      alertDiv.remove();
    }, 5000);
  }
});