

const API_BASE_URL =  'http://127.0.0.1:5041'

document.addEventListener('DOMContentLoaded', function() {
    obtenerIdUsuarioPorEmail()
       const correo =  localStorage.getItem('correo')
        const validación_ubicacion = localStorage.getItem('loggin')
        if (validación_ubicacion === 'true') {
                llamada(correo);
                localStorage.setItem('loggin', 'false'); // debe ser string
            }
        
});


async function llamada(correo){
    
        try {
            // Obtener datos del formulario
            const formData = {
                correo: correo
            };

            // Enviar datos al servidor
            const response = await fetch(`${API_BASE_URL}/auditoria/create/${correo}`);

            // Procesar respuesta
            if (!response.ok) {
                const errorData = await response.json();
                throw errorData;
            }

            const data = await response.json();
        


        } catch (error) {
            console.error('Error al crear empleado:', error);

            // Mostrar errores de validación
            if (error.errors) {

            } else {
                showAlert(error.error || 'Error al crear el empleado', 'danger');
            }
        }
}


async function obtenerIdUsuarioPorEmail() {
    const email = localStorage.getItem('correo');

    if (!email) {
        console.error('No se encontró el correo en localStorage');
        return null;
    }

    try {
        const response = await fetch(`${API_BASE_URL}/usuarios/id/${encodeURIComponent(email)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.error('Error al obtener ID:', errorData.error || 'Error desconocido');
            return null;
        }

        const data = await response.json();
        console.log(data);
        localStorage.setItem('id_usuario', data.id_usuario); // Guardar el ID en localStorage
        
        return data.id_usuario;
    } catch (error) {
        console.error('Error de red al obtener el ID del usuario:', error);
        return null;
    }
}
