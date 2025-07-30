// Carga los datos de los archivos PHP
fetch("data/cancelaciones.php")
  .then((res) => res.json())
  .then((data) => crearCancelaciones(data));

fetch("data/zonas.php")
  .then((res) => res.json())
  .then((data) => crearZonas(data));

fetch("data/recomiendan.php")
  .then((res) => res.json())
  .then((data) => crearRecomiendan(data));

fetch("data/satisfaccion.php")
  .then((res) => res.json())
  .then((data) => crearSatisfaccion(data));

fetch("data/perfiles.php")
  .then((res) => res.json())
  .then((data) => crearPerfiles(data));

function crearCancelaciones(data) {
  const ctx = document.getElementById("cancelacionesChart").getContext("2d");
  const chart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: data.meses,
      datasets: data.datasets,
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: "Cancelaciones por Mes (agrupado por método y tipo)"
        }
      },
      scales: {
        x: { stacked: true },
        y: { stacked: true }
      }
    },
  });
}

function crearZonas(data) {
  const ctx = document.getElementById("zonasChart").getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: data.meses,
      datasets: data.zonas.map((zona) => ({
        label: zona.nombre,
        data: zona.valores,
        fill: false,
        borderColor: zona.color,
      })),
    },
  });
}

function crearRecomiendan(data) {
  const ctx = document.getElementById("recomiendanChart").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: data.labels,
      datasets: [
        {
          label: "Veces Compartido",
          data: data.valores,
          backgroundColor: "#4CAF50",
        },
      ],
    },
    options: {
      indexAxis: 'y',
    },
  });
}

function crearSatisfaccion(data) {
  const ctx = document.getElementById("satisfaccionChart").getContext("2d");
  new Chart(ctx, {
    type: "bubble",
    data: {
      datasets: data.map((item) => ({
        label: item.servicios,
        data: [{
          x: item.dia,
          y: item.calificacion,
          r: item.reseñas / 2,
        }],
        backgroundColor: "rgba(75,192,192,0.5)",
      }))
    }
  });
}

function crearPerfiles(data) {
  const ctx = document.getElementById("perfilesChart").getContext("2d");
  new Chart(ctx, {
    type: "scatter",
    data: {
      datasets: data.map((perfil) => ({
        label: `${perfil.genero} - ${perfil.origen}`,
        data: [{ x: perfil.precio, y: perfil.servicios }],
        backgroundColor: "rgba(153, 102, 255, 0.5)",
        pointRadius: perfil.reservas / 2,
      }))
    }
  });
}