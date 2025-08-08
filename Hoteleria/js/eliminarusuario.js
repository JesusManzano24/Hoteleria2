document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formEliminarUsuario');
    const mensajeDiv = document.getElementById('mensaje');
    const confirmacionDiv = document.getElementById('confirmacion');
    const btnConfirmar = document.getElementById('btnConfirmar');
    const btnCancelar = document.getElementById('btnCancelar');
    let idUsuarioAEliminar = null;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        idUsuarioAEliminar = document.getElementById('id_usuario').value;
        
        if (!idUsuarioAEliminar) {
            mostrarMensaje('Por favor ingrese un ID válido', true);
            return;
        }

        // Mostrar confirmación
        form.style.display = 'none';
        confirmacionDiv.style.display = 'block';
    });

    btnConfirmar.addEventListener('click', async function() {
        try {
            btnConfirmar.disabled = true;
            btnConfirmar.textContent = 'Eliminando...';
            
            const response = await fetch('/Hoteleria/view/PanelAdmin/api_eliminar_usuario.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id_usuario: idUsuarioAEliminar })
            });

            const result = await response.json();
            
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Error al eliminar usuario');
            }

            mostrarMensaje(result.message, false);
            resetForm();

        } catch (error) {
            console.error('Error:', error);
            mostrarMensaje(error.message, true);
        } finally {
            btnConfirmar.disabled = false;
            btnConfirmar.textContent = 'Confirmar Eliminación';
        }
    });

    btnCancelar.addEventListener('click', function() {
        resetForm();
    });

    function resetForm() {
        form.reset();
        form.style.display = 'block';
        confirmacionDiv.style.display = 'none';
        idUsuarioAEliminar = null;
    }

    function mostrarMensaje(texto, esError) {
        mensajeDiv.textContent = texto;
        mensajeDiv.className = esError ? 'error' : 'success';
        mensajeDiv.style.display = 'block';
        
        setTimeout(() => {
            mensajeDiv.style.display = 'none';
        }, 5000);
    }
});