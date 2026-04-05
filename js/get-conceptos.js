document.addEventListener('DOMContentLoaded', function() {
    cargarConceptos();
});

function cargarConceptos() {
    const select = document.getElementById('idConcepto');

    fetch('api/conceptos.php')
        .then(response => response.json())
        .then(data => {
            // Limpiamos el select
            select.innerHTML = '<option value="" selected disabled>Selecciona una opción...</option>';

            // Creamos los grupos visuales
            const groupEntrada = document.createElement('optgroup');
            groupEntrada.label = 'Entradas';
            
            const groupSalida = document.createElement('optgroup');
            groupSalida.label = 'Salidas';

            // Clasificamos los datos recibidos
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.idConcepto;
                option.textContent = item.nombre;

                if (item.tipo === 'entrada') {
                    groupEntrada.appendChild(option);
                } else {
                    groupSalida.appendChild(option);
                }
            });

            // Agregamos los grupos al select
            select.appendChild(groupEntrada);
            select.appendChild(groupSalida);
        })
        .catch(error => {
            console.error('Error al cargar conceptos:', error);
            select.innerHTML = '<option disabled>Error al cargar datos</option>';
        });
}