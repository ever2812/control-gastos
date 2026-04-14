document.addEventListener('DOMContentLoaded', function() {
    // Además de cargar conceptos, cargamos los movimientos
    cargarMovimientos(mesActual);
});

function cargarMovimientos(mes) {
    const tablaCuerpo = document.getElementById('tablaMovimientos');
    const listaMovil = document.querySelector('.mobile-list');

    fetch(`api/getMovimientos.php?mes=${mes}`)
        .then(response => response.json())
        .then(data => {
            tablaCuerpo.innerHTML = '';
            listaMovil.innerHTML = '';

            data.forEach(mov => {
                const esIngreso = mov.tipo === 'entrada';
                const claseMonto = esIngreso ? 'text-success' : 'text-danger';
                const simbolo = esIngreso ? '+' : '-';
                const badgeClase = esIngreso ? 'badge-income' : 'badge-expense';

                                // --- 2. Renderizar para Móvil (Lista de tarjetas) ---
                const itemMovil = `
                    <div class="transaction-item shadow-sm">
                        <div>
                            <strong class="d-block">${mov.concepto_nombre}</strong>
                            <small class="text-muted">${formatearFecha(mov.fecha_operacion)} • ${mov.descripcion || ''}</small>
                        </div>
                        <span class="fw-bold ${claseMonto}">${simbolo}$${mov.monto}</span>
                    </div>`;
                listaMovil.innerHTML += itemMovil;
                
                // --- 1. Renderizar para Desktop (Tabla) ---
                const fila = `
                    <tr>
                        <td>${formatearFecha(mov.fecha_operacion)}</td>
                        <td>
                            ${mov.concepto_nombre} -
                            <small class="text-muted">${mov.descripcion || ''}</small>
                        </td>
                        <td><span >${mov.tipo.toUpperCase()}</span></td>
                        <td class="text-end fw-bold ${claseMonto}">${simbolo}$${mov.monto}</td>
                    </tr>`;
                tablaCuerpo.innerHTML += fila;


            });
        })
        .catch(error => console.error('Error:', error));
}

// Función auxiliar para fechas bonitas
function formatearFecha(fechaStr) {
    const opciones = { day: '2-digit', month: 'short' };
    return new Date(fechaStr).toLocaleDateString('es-ES', opciones);
}