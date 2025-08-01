// registro.js - VERSIÓN CON RUTAS CORREGIDAS Y MEJORAS
document.addEventListener('DOMContentLoaded', function() {
  // ——————————————————————————————————————————————
  // 1) Variables y selects del DOM
  let clickCount = 0;
  const logo = document.getElementById('logo');
  const registroFormContainer = document.getElementById('registroFormContainer');
  const adminLoginFormContainer = document.getElementById('adminLoginFormContainer');
  const registroForm = document.getElementById('registroForm');
  const adminLoginForm = document.getElementById('adminLoginForm');
  const regisAdminBtn = document.getElementById('RegisAdmin');
  const adminOption = document.getElementById('adminOption');
  const tipoUsuarioSelect = document.getElementById('tipo_usuario');

  // Elemento para mostrar mensajes de debug
  const debugInfo = document.createElement('div');
  debugInfo.className = 'debug-info';
  debugInfo.innerHTML = 'Debug Console:<br>';
  document.body.appendChild(debugInfo);

  // Función para mostrar mensajes de debug
  function logDebug(message) {
    debugInfo.innerHTML += `${message}<br>`;
    console.log(message);
  }

  // Mostrar elementos cargados en debug
  logDebug('Elementos cargados:');
  logDebug(`- Logo: ${logo ? 'OK' : 'No encontrado'}`);
  logDebug(`- Botón RegisAdmin: ${regisAdminBtn ? 'OK' : 'No encontrado'}`);
  logDebug(`- Opción Admin: ${adminOption ? 'OK' : 'No encontrado'}`);
  logDebug(`- Select tipo usuario: ${tipoUsuarioSelect ? 'OK' : 'No encontrado'}`);

  // ——————————————————————————————————————————————
  // 2) Mostrar el formulario de admin al hacer 3 clics en el logo
  if (logo) {
    logo.addEventListener('click', () => {
      clickCount++;
      logDebug(`Clics en logo: ${clickCount}/3`);
      
      if (clickCount === 3) {
        logDebug('Mostrando formulario de admin');
        if (registroFormContainer) registroFormContainer.style.display = 'none';
        if (adminLoginFormContainer) adminLoginFormContainer.style.display = 'block';
        clickCount = 0;
      }
    });
  }

  // ——————————————————————————————————————————————
  // 3) Lógica MEJORADA para el botón "Registrar Administrador"
  function handleAdminRegister(event) {
    // Prevenir cualquier comportamiento por defecto
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }
    
    logDebug('Botón Registrar Admin clickeado');
    
    // Verificar elementos necesarios
    if (!adminOption || !tipoUsuarioSelect || !adminLoginFormContainer || !registroFormContainer) {
      logDebug('ERROR: Faltan elementos requeridos');
      return;
    }

    // 1. Mostrar y seleccionar opción Admin
    adminOption.style.display = 'block';
    tipoUsuarioSelect.value = 'Admin';

    // 2. Cambiar visibilidad de formularios
    adminLoginFormContainer.style.display = 'none';
    registroFormContainer.style.display = 'block';
    
    // 3. Scroll suave al formulario de registro
    setTimeout(() => {
      registroFormContainer.scrollIntoView({ behavior: 'smooth' });
    }, 100);

    // Verificación final
    logDebug('Opción Admin visible');
    logDebug('Valor seleccionado: ' + tipoUsuarioSelect.value);
  }

  // Configuración del event listener para el botón
  if (regisAdminBtn) {
    logDebug('Configurando event listener para RegisAdmin');
    regisAdminBtn.addEventListener('click', handleAdminRegister);
  } else {
    logDebug('ERROR: Elemento RegisAdmin no encontrado en el DOM');
  }

  // ——————————————————————————————————————————————
  // 4) Envío del formulario de registro
  if (registroForm) {
    // Asegurarnos que el formulario tenga el enctype correcto
    //registroForm.setAttribute('enctype', 'multipart/form-data'); descomentar solo si se usara foto_perfil
    
    registroForm.addEventListener('submit', function(event) {
      event.preventDefault();

      // Fecha de registro al día
      document.getElementById('fecha_registro').value =
        new Date().toISOString().split('T')[0];

      const formData = new FormData(this);

      // RUTA CORREGIDA: Usar el endpoint de registro específico
      fetch('../../controller/RegistroController.php', {
        method: 'POST',
        body: formData
      })
      .then(res => {
        if (!res.ok) {
          return res.text().then(txt => {
            throw new Error(`HTTP ${res.status}\n${txt}`);
          });
        }
        return res.text();
      })
      .then(txt => {
        logDebug('>>> RESPUESTA RAW registro: ' + txt);
        let data;
        try {
          data = JSON.parse(txt);
        } catch (e) {
          throw new Error('No es JSON válido: ' + e.message);
        }
        if (data.success) {
          alert('Registro exitoso!');
          // RUTA ABSOLUTA para mejor compatibilidad
          window.location.href = '/Hoteleria/view/Login/login.html';
        } else {
          alert('Error en el registro: ' + data.error);
        }
      })
      .catch(err => {
        console.error('Error registro:', err);
        alert('Hubo un error al registrar. Revisa la consola.');
      });
    });
  }

  // ——————————————————————————————————————————————
  // 5) Envío del formulario de login de administrador
  if (adminLoginForm) {
    adminLoginForm.addEventListener('submit', function(event) {
      event.preventDefault();

      const correo = document.getElementById('adminCorreo').value.trim();
      const password = document.getElementById('adminPassword').value;

      if (!correo || !password) {
        alert('Debes ingresar correo y contraseña de administrador.');
        return;
      }

      // CORRECCIÓN IMPORTANTE: Usar el controlador de LOGIN, no de registro
     fetch('../../controller/LoginController.php?action=admin', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          correo,
          password
        })
      })
      .then(res => {
        if (!res.ok) {
          return res.text().then(txt => {
            throw new Error(`HTTP ${res.status}\n${txt}`);
          });
        }
        return res.text();
      })
      .then(txt => {
        logDebug('>>> RAW login_admin: ' + txt);

        let data;
        try {
          data = JSON.parse(txt);
        } catch (e) {
          throw new Error('Respuesta no es JSON válido: ' + e.message);
        }

        if (data.success) {
          // RUTA CORREGIDA: Redirigir al panel de admin
          window.location.href = '../view/admin/dashboard.html';
        } else {
          alert(data.error || 'Credenciales incorrectas');
        }
      })
      .catch(err => {
        console.error('Error login_admin:', err);
        alert('Hubo un error al iniciar sesión. Revisa la consola.');
      });
    });
  }
});