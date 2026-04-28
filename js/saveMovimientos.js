// Dentro del document.addEventListener('DOMContentLoaded', ...)

const formulario = document.getElementById('FormRegistro');
    
formulario.addEventListener('submit', function(e) {
    e.preventDefault(); 
    // Evita que la página se recargue

    // 1. Capturar los valores
    const datos = {
        // Obtenemos el tipo (entrada/salida) verificando cuál radio está marcado
        tipo: document.getElementById('btnIngreso').checked ? 'entrada' : 'salida',
        concepto_id: document.getElementById('idConcepto').value,
        monto: document.querySelector('input[type="number"]').value,
        descripcion: document.getElementById('descripcionMov').value,
        idUsuario: 1, // Por ahora, lo dejamos fijo. Luego se puede adaptar para manejar múltiples usuarios.        
    };

    // 2. Enviar vía Fetch POST
    fetch('../api/saveMovimiento.php', {
        method: 'POST',
        headers:  {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(res => {
        if (res.success) {
            // 3. Éxito: Limpiar formulario y cerrar modal
            formulario.reset();
            const modalEl = document.getElementById('modalRegistro');
            const modalBus = bootstrap.Modal.getInstance(modalEl);
            modalBus.hide();

            //refrescar movimientos y dashboard
            refrescarTodo();
            const toast = new bootstrap.Toast(document.getElementById('liveToast'));
            toast.show();

        } else {
            alert('Error: ' + res.error);
        }
    })
    .catch(error => console.error('Error al guardar:', error));
});