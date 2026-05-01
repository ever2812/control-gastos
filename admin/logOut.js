document.addEventListener('DOMContentLoaded', function() {
    const btnSalir = document.getElementById('btnSalir');

    if (btnSalir) {
        btnSalir.addEventListener('click', function(e) {
            e.preventDefault(); // Evita que el enlace '#' haga scroll hacia arriba
            confirmarSalida();
        });
    }
});

function confirmarSalida() {
    // Usamos una confirmación elegante
    if (confirm("¿Deseas cerrar tu sesión?")) {
        // Llamada al logout.php que creamos antes
        fetch('../api/logout/index.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.clear();
                    window.location.href = '../login.html';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = '../login.html';
            });
    }
}