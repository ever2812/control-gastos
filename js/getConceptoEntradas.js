// Variable global para guardar los conceptos una sola vez
let listaConceptos = [];

document.addEventListener('DOMContentLoaded', function() {
    // 1. Cargar los datos desde el servidor al iniciar
    fetch('api/getConceptos.php')
        .then(response => response.json())
        .then(data => {
            listaConceptos = data;
            // 2. Poblar el select inicialmente con 'entrada' (por defecto)
            filtrarConceptos('entrada');
        });

    // 3. Escuchar cambios en los botones Radio
    const btnIngreso = document.getElementById('btnIngreso');
    const btnEgreso = document.getElementById('btnEgreso');

    btnIngreso.addEventListener('change', () => filtrarConceptos('entrada'));
    btnEgreso.addEventListener('change', () => filtrarConceptos('salida'));
});

/**
 * Función para limpiar y llenar el select según el tipo
 * @param {string} tipo - 'entrada' o 'salida'
 */
function filtrarConceptos(tipo) {

    const select = document.getElementById('idConcepto');
    
    // Limpiar opciones actuales
    select.innerHTML = '<option value="" selected disabled>Selecciona un concepto...</option>';

    // Filtrar el array global según el tipo seleccionado
    const filtrados = listaConceptos.filter(item => item.tipo === tipo);

    // Crear y agregar las nuevas opciones
    filtrados.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.nombre;
        select.appendChild(option);
    });
    
    console.log(`Select actualizado con conceptos de: ${tipo}`);
}