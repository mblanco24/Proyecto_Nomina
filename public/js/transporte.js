// Inicialización
const API_BASE_URL = 'http://127.0.0.1:5041'

document.addEventListener('DOMContentLoaded', function() {
    transporteVer();
});


document.getElementById('btn_registro').addEventListener('click', () => {
    Swal.fire({
        title: 'Registrar Asistencia',
        customClass: {
            popup: 'swal-wide'
        },
        html: `
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <div style="display: flex; gap: 10px;">
                    <input id="cedula" class="swal2-input" placeholder="Cédula">
                    <input id="usuario" class="swal2-input" placeholder="Usuario">
                </div>
                <div style="display: flex; gap: 10px;">
                    <input id="fecha" type="date" class="swal2-input" placeholder="Fecha">
                    <input id="entrada" type="time" class="swal2-input" placeholder="Hora Entrada">
                    <input id="salida" type="time" class="swal2-input" placeholder="Hora Salida">
                </div>
                <div>
                    <input id="ruta" class="swal2-input" placeholder="Ruta" style="width: 60%;">
                </div>
            </div>
        `,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        preConfirm: () => {
            const cedula = document.getElementById('cedula').value;
            const usuario = document.getElementById('usuario').value;
            const fecha = document.getElementById('fecha').value;
            const entrada = document.getElementById('entrada').value;
            const salida = document.getElementById('salida').value;
            const ruta = document.getElementById('ruta').value;

            if (!cedula || !usuario || !fecha || !entrada || !salida || !ruta) {
                Swal.showValidationMessage('Todos los campos son obligatorios');
                return false;
            }

            return { cedula, usuario, fecha, entrada, salida, ruta };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const datos = result.value;

            fetch(`${API_BASE_URL}/transportes/new`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cedula: datos.cedula,
                    usuario: datos.usuario,
                    fecha: datos.fecha,
                    hora_entrada: datos.entrada,
                    hora_salida: datos.salida,
                    ruta: datos.ruta
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al guardar el registro');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire('Guardado', 'Registro exitoso', 'success').then(() =>{
                    location.reload()
                })
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo guardar el registro', 'error');
            });
        }
    });
});

let transporteData = [];
async function transporteVer() {
    try {
        const response = await fetch(`${API_BASE_URL}/transportes/`);
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        transporteData = await response.json(); // Guardar globalmente
        renderTabla(transporteData); // Llamar a función de renderizado

    } catch (error) {
        console.error('Error al obtener empleados:', error);
        showAlert('Error al cargar los empleados', 'danger');
    }
}


function renderTabla(data) {
    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = '';

    data.forEach(item => {
        const fechaObj = new Date(item.fecha);
        const year = fechaObj.getUTCFullYear();
        const month = String(fechaObj.getUTCMonth() + 1).padStart(2, '0');
        const day = String(fechaObj.getUTCDate()).padStart(2, '0');
        const fechaFormateada = `${year}-${month}-${day}`;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.cedula}</td>
            <td>${item.usuario}</td>
            <td>${fechaFormateada}</td>
            <td>${item.hora_entrada}</td>
            <td>${item.hora_salida}</td>
            <td>${item.ruta}</td>
        `;

        tbody.appendChild(tr);
    });
}


document.getElementById('filtro-fecha').addEventListener('input', () => {
    const valorFecha = document.getElementById('filtro-fecha').value;
    if (!valorFecha) {
        renderTabla(transporteData); // Mostrar todo si se borra
        return;
    }

    // Filtrar por coincidencia exacta
    const filtrados = transporteData.filter(item => {
        const fechaObj = new Date(item.fecha);
        const year = fechaObj.getUTCFullYear();
        const month = String(fechaObj.getUTCMonth() + 1).padStart(2, '0');
        const day = String(fechaObj.getUTCDate()).padStart(2, '0');
        const fechaFormateada = `${year}-${month}-${day}`;
        return fechaFormateada === valorFecha;
    });

    renderTabla(filtrados);
});
