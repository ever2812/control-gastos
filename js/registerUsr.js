document.getElementById('FormRegistro').addEventListener('submit', function (e) {
    e.preventDefault();

    const nombre = this.querySelector('input[name="nombreUsuario"]').value;
    const email = this.querySelector('input[name="emailUsuario"]').value;
    const password = this.querySelector('input[name="psdUsuario"]').value;


    // Capturamos el elemento del Toast 
    //const toastElement = document.getElementById('liveToast');
    // const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastElement);


    const btn = this.querySelector('button');
    btn.disabled = true; // Evitar múltiples clics
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';


    fetch('api/registro/index.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombre, email, password })
    })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                //alerta tradicional
                alert(res.message);

                //###########PENDIENVE LA IMPLEMENTACION DE TOAST PARA MOSTRAR MENSAJES DE FORMA MÁS NAVY BLUE###########
                // toastElement.querySelector('.toast-body').textContent = res.message;
                // toastElement.classList.replace('bg-danger', 'bg-success');

                // 3. ¡MOSTRAR EL TOAST!
                // toastBootstrap.show();

                // llamar la función toggleAuth para que el usuario pase al formulario de login automáticamente
                toggleAuth();
            } else {
                alert(res.message);


                // Aquí podrías usar un Toast para que se vea más Navy Blue
                toastElement.querySelector('.toast-body').textContent = res.message;
                toastElement.classList.replace('bg-success', 'bg-danger');
                toastBootstrap.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al conectar con el servidor.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Registrarme';
        });
});