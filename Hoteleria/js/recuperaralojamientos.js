document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const lista = document.querySelector("#lista-alojamientos");
    const mensaje = document.createElement("div");
    form.parentElement.insertBefore(mensaje, form);

    function cargarAlojamientos() {
        fetch("../php/obtener_alojamientos.php")
            .then(res => {
                if (!res.ok) {
                    throw new Error(`Error HTTP: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                lista.innerHTML = "";
                if (data.length === 0) {
                    lista.innerHTML = "<li>No hay alojamientos registrados.</li>";
                    return;
                }

                data.forEach(aloj => {
                    const li = document.createElement("li");
                    li.innerHTML = `
                        <strong>${aloj.nombre}</strong> - $${aloj.precio} MXN<br>
                        ${aloj.tipo_alojamiento} - ${aloj.estado}<br>
                        ${aloj.direccion}
                    `;
                    lista.appendChild(li);
                });
            })
            .catch(err => {
                console.error("Error al obtener alojamientos:", err);
                lista.innerHTML = `<li>Ocurrió un error al cargar los alojamientos.</li>`;
            });
    }

    // Cargar al inicio
    cargarAlojamientos();

    // Enviar el formulario vía fetch
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("../php/registrar_alojamiento.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                mensaje.innerHTML = `<p style="color:green;">${data.success}</p>`;
                form.reset();
                cargarAlojamientos();
            } else {
                mensaje.innerHTML = `<p style="color:red;">${data.error}</p>`;
            }
        })
        .catch(error => {
            console.error("Error al enviar formulario:", error);
            mensaje.innerHTML = `<p style="color:red;">Error en la petición.</p>`;
        });
    });
});
