document.addEventListener('DOMContentLoaded', function() {
    const selectorMes = document.getElementById('filtroMes');
    
    // Establecer el mes actual por defecto en el input
    const hoy = new Date();
    const mesActual = hoy.toISOString().substring(0, 7); // Formato "2026-04"
    selectorMes.value = mesActual;

    // Cargar datos iniciales
    refrescarTodo();

    // Evento: Cuando cambie el mes, refrescar todo
    selectorMes.addEventListener('change', refrescarTodo);
});

function refrescarTodo() {
    const mes = document.getElementById('filtroMes').value;
    
    // Pasamos el mes como parámetro a nuestras funciones
    cargarResumenDashboard(mes);
    cargarMovimientos(mes);
}