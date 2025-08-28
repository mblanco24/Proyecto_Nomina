

const API_BASE_URL =  'http://127.0.0.1:5041'

document.addEventListener('DOMContentLoaded', function() {
       const correo =  localStorage.getItem('correo')

        
            llamada(correo);

        
});


async function llamada(correo){
    
        try {
            // Obtener datos del formulario
            const formData = {
                correo: correo
            };

            // Enviar datos al servidor
            const response = await fetch(`${API_BASE_URL}/auditoria/create/salida/${correo}`);

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