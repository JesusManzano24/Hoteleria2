document.addEventListener('DOMContentLoaded', function() {
    const elements = {
        loading: document.getElementById('loading'),
        tabla: document.getElementById('tabla-usuarios'),
        cuerpoTabla: document.getElementById('cuerpo-tabla'),
        error: document.getElementById('error-message')
    };

    async function loadUsers() {
        try {
            const response = await fetch('../../view/PanelAdmin/api_usuarios.php');
            const textData = await response.text();
            
            // Depuración: ver respuesta cruda
            console.log('API Response:', textData);
            
            // Verificar si es HTML de error
            if (textData.trim().startsWith('<')) {
                throw new Error('El servidor devolvió un error HTML');
            }
            
            const data = JSON.parse(textData);
            
            if (!data || data.status !== 'success') {
                throw new Error(data.message || 'Error en los datos recibidos');
            }
            
            displayUsers(data.data);
            
        } catch (error) {
            console.error('Error completo:', error);
            elements.loading.style.display = 'none';
            elements.error.innerHTML = `
                <strong>Error al cargar usuarios:</strong><br>
                ${error.message}<br>
                <small>Ver consola para más detalles</small>
            `;
            elements.error.style.display = 'block';
        }
    }

    function displayUsers(usuarios) {
        elements.cuerpoTabla.innerHTML = usuarios.map(usuario => `
            <tr>
                <td>${usuario.id_usuario}</td>
                <td>${escapeHtml(usuario.nombre)}</td>
                <td>${escapeHtml(usuario.correo)}</td>
                <td>${usuario.telefono ? escapeHtml(usuario.telefono) : 'N/A'}</td>
                <td>${escapeHtml(usuario.rol)}</td>
                <td>${new Date(usuario.fecha_registro).toLocaleString('es-MX')}</td>
            </tr>
        `).join('');
        
        elements.loading.style.display = 'none';
        elements.tabla.style.display = 'table';
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text.toString()
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    loadUsers();
});