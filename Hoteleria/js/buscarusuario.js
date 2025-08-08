document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formBuscarUsuario');
    const mensajeDiv = document.getElementById('mensaje');
    const resultadoDiv = document.getElementById('resultado');
    const usuarioInfoDiv = document.getElementById('usuarioInfo');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        
        try {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Buscando...';
            
            const correo = document.getElementById('correo').value;
            
            const response = await fetch(`/Hoteleria/view/PanelAdmin/api_buscar_usuario.php?correo=${encodeURIComponent(correo)}`);
            
            // Verificar si la respuesta es JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error('Respuesta no válida del servidor');
            }

            const result = await response.json();
            
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Usuario no encontrado');
            }

            mostrarResultado(result.usuario);
            mostrarMensaje('Usuario encontrado', false);
            
        } catch (error) {
            console.error('Error:', error);
            mostrarMensaje(error.message, true);
            ocultarResultado();
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Buscar Usuario';
        }
    });

    function mostrarMensaje(texto, esError) {
        mensajeDiv.textContent = texto;
        mensajeDiv.className = esError ? 'error' : 'success';
    }

    function mostrarResultado(usuario) {
        usuarioInfoDiv.innerHTML = `
            <p><strong>ID:</strong> ${usuario.id_usuario}</p>
            <p><strong>Nombre:</strong> ${usuario.nombre}</p>
            <p><strong>Correo:</strong> ${usuario.correo}</p>
            <p><strong>Rol:</strong> ${usuario.rol}</p>
            <p><strong>Teléfono:</strong> ${usuario.telefono || 'No especificado'}</p>
            <p><strong>Género:</strong> ${usuario.genero || 'No especificado'}</p>
            <p><strong>Origen:</strong> ${usuario.origen || 'No especificado'}</p>
            <p><strong>Fecha Nacimiento:</strong> ${usuario.fecha_nac || 'No especificada'}</p>
        `;
        resultadoDiv.classList.remove('hidden');
    }

    function ocultarResultado() {
        resultadoDiv.classList.add('hidden');
        usuarioInfoDiv.innerHTML = '';
    }
});