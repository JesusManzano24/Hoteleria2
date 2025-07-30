const metodoSelect = document.getElementById("metodoPago");
const infoPago = document.getElementById("infoPago");

metodoSelect.addEventListener("change", function () {
  const metodo = metodoSelect.value;

  if (metodo === "Tarjeta") {
    infoPago.innerHTML = `
      <strong>Tarjeta:</strong> Puedes pagar con Visa, Mastercard o AMEX.<br><br>
      <label>Número de tarjeta:</label>
      <input type="text" maxlength="16" placeholder="XXXX XXXX XXXX XXXX" required /><br>
      <label>Nombre del titular:</label>
      <input type="text" placeholder="Como aparece en la tarjeta" required /><br>
      <label>Fecha de vencimiento:</label>
      <input type="month" required /><br>
      <label>CVV:</label>
      <input type="text" maxlength="4" placeholder="XXX" required />
    `;
  } else if (metodo === "Transferencia") {
    infoPago.innerHTML = `
      <strong>Transferencia:</strong> Realiza un pago vía SPEI.<br><br>
      <p><strong>Banco:</strong> Banco Ejemplo S.A.</p>
      <p><strong>Cuenta:</strong> 123456789012345</p>
      <p><strong>CLABE:</strong> 012345678901234567</p>
    `;
  } else if (metodo === "Oxxo Pay") {
  infoPago.innerHTML = `
    <strong>Oxxo Pay:</strong> Paga en cualquier tienda OXXO.<br><br>
    <label>Correo para recibir el comprobante:</label>
    <input type="email" placeholder="tu@email.com" required /><br><br>

    <div id="comprobanteQR" style="margin-top: 20px; text-align: center;">
      <div style="background: #fff; border: 1px solid #ccc; padding: 20px; border-radius: 10px; display: inline-block;">
        <h3 style="color:#0f1c2f;">Comprobante de Pago</h3>
        <p><strong>Referencia:</strong> 123456789</p>
        <p><strong>Hotel:</strong> Playa Coral</p>
        <p><strong>Total:</strong> $2,400.00 MXN</p>
        <div id="oxxoQR" style="margin: 15px auto;"></div>
        <button onclick="descargarQR()">Descargar código QR</button>
      </div>
    </div>
  `;

  generarQR(); // 👈 Esto es lo que faltaba
  }
});

// Generador QR con datos de ejemplo
function generarQR() {
  const qrData = "OXXO-REF:123456789|MONTO:$2400.00|HOTEL:Playa Coral";
  const qrElement = document.getElementById("oxxoQR");
  qrElement.innerHTML = ""; // limpiar si ya existe
  const qrCode = new QRCode(qrElement, {
    text: qrData,
    width: 180,
    height: 180,
    colorDark: "#0f1c2f",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  });
}

function descargarQR() {
  const qrCanvas = document.querySelector("#oxxoQR canvas");
  const link = document.createElement("a");
  link.href = qrCanvas.toDataURL("image/png");
  link.download = "comprobante_oxxo.png";
  link.click();
}