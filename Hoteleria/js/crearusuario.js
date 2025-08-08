document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formCrearUsuario');
    if (!form) {
        console.error('Formulario no encontrado');
        return;
    }

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.textContent;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            // Deshabilitar botón durante el envío
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creando usuario...';

            // Obtener datos del formulario
            const formData = new FormData(form);
            const userData = {
                tipo: formData.get('tipo'),
                nombre: formData.get('nombre'),
                correo: formData.get('correo'),
                password: formData.get('password'),
                telefono: formData.get('telefono'),
                genero: formData.get('genero'),
                origen: formData.get('origen'),
                fecha_nac: formData.get('fecha_nac')
            };

            // Enviar datos al servidor
            const response = await fetch('/Hoteleria/view/PanelAdmin/api_crear_usuario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData)
            });

            // Procesar respuesta
            const result = await response.json();
            
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Error al crear usuario');
            }

            alert(`Usuario creado exitosamente con ID: ${result.id_usuario}`);
            form.reset();

        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalBtnText;
        }
    });
});