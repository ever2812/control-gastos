document.addEventListener('DOMContentLoaded', function() {
    verificarSesion();
});

function verificarSesion() {
    fetch('../api/check/index.php')
        .then(response => response.json())
        .then(data => {
            if (!data.logged) {
                // Si no hay sesión, mandarlo al login de inmediato
                console.warn("No hay sesión activa. Redirigiendo a login...");

                window.location.href = '../index.html';
            } else {
                // Si hay sesión, personalizamos la interfaz
                console.log("Bienvenido:", data.nombre);

                //document.getElementById('nombreUsuario').textContent = data.nombre;
                
                // Ahora sí, cargamos los datos del dashboard
                refrescarTodo(); 
            }
        })
        .catch(error => {
            console.error('Error verificando sesión:', error);
            window.location.href = '../index.html';
        });
}