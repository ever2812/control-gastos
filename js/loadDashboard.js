// Función para actualizar los números del Dashboard
function cargarResumenDashboard(mes) {
    fetch(`api/getResumen.php?mes=${mes}`)
        .then(response => response.json())
        .then(data => {
            // Seleccionamos los elementos por sus IDs o clases (asegúrate de que existan en tu HTML)
            const elSaldo = document.querySelector('.header-app h1'); // El saldo grande del header
            const elIngresos = document.querySelector('.text-success.fw-bold'); // Tarjeta verde
            const elEgresos = document.querySelector('.text-danger.fw-bold'); // Tarjeta roja

            // Formateador de moneda para que se vea profesional
            const f = new Intl.NumberFormat('es-MX', {
                style: 'currency',
                currency: 'MXN',
            });

            if (elSaldo) elSaldo.textContent = f.format(data.saldo);
            if (elIngresos) elIngresos.textContent = f.format(data.ingresos);
            if (elEgresos) elEgresos.textContent = f.format(data.egresos);
        })
        .catch(error => console.error('Error al cargar resumen:', error));
}

// Llamar a esta función al cargar la página y después de cada nuevo registro
document.addEventListener('DOMContentLoaded', () => {
    cargarResumenDashboard(mesActual);
    cargarMovimientos(mesActual);
});