document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    const resp = await fetch('api/login/index.php', {
        method: 'POST',
        body: JSON.stringify(data)
    });
    const res = await resp.json();
    
    if(res.success){
        localStorage.setItem('idUser', res.idUser);
        window.location.href = 'admin/';
    } 

    else alert(res.message);
});