document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formActualizarUsuario');
    const mensajeDiv = document.getElementById('mensaje');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        
        try {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Actualizando...';
            
            // Obtener todos los datos del formulario
            const formData = new FormData(form);
            const userData = {
                id_usuario: formData.get('id_usuario'),
                tipo: formData.get('tipo') || 'Huesped', // Valor por defecto
                nombre: formData.get('nombre'),
                correo: formData.get('correo'),
                password: formData.get('password'),
                telefono: formData.get('telefono'),
                genero: formData.get('genero'),
                origen: formData.get('origen'),
                fecha_nac: formData.get('fecha_nac')
            };

            console.log('Datos a enviar:', userData); // Para depuración

            const response = await fetch('/Hoteleria/view/PanelAdmin/api_actualizar_usuario.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            // Verificar si la respuesta es JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error(`El servidor respondió con formato incorrecto: ${text.substring(0, 100)}...`);
            }

            const result = await response.json();
            
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Error al actualizar usuario');
            }

            mostrarMensaje('Usuario actualizado exitosamente', false);
            form.reset();

        } catch (error) {
            console.error('Error completo:', error);
            mostrarMensaje(error.message, true);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Actualizar Usuario';
        }
    });

    function mostrarMensaje(texto, esError) {
        mensajeDiv.textContent = texto;
        mensajeDiv.className = esError ? 'error' : 'success';
        mensajeDiv.style.display = 'block';
        setTimeout(() => {
            mensajeDiv.style.display = 'none';
        }, 5000);
    }
});