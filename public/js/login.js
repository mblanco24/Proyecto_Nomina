document.getElementById('btn_iniciar').addEventListener('click', () => {
    const correo = document.getElementById('email').value
    localStorage.setItem('correo', correo)
    localStorage.setItem('loggin', true)
    localStorage.setItem('evento', 'entrada')
})