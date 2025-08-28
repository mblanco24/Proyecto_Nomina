const API_BASE_URL = 'http://127.0.0.1:5041';

let registrosGlobal = []; // almacena todos los registros


document.addEventListener('DOMContentLoaded', function () {
    verRegistros();

    const filtroTipo = document.getElementById('filtro-tipo');
    const filtroFecha = document.getElementById('filtro-fecha');

    // Aplicar filtros al cambiar tipo
    filtroTipo.addEventListener('change', aplicarFiltros);

    // Aplicar filtros al cambiar fecha
    filtroFecha.addEventListener('change', aplicarFiltros);
});


function aplicarFiltros() {
    const tipo = document.getElementById('filtro-tipo').value;
    const fecha = document.getElementById('filtro-fecha').value; // formato: YYYY-MM-DD

    let filtrados = registrosGlobal;

    // Filtro por tipo
    if (tipo !== 'todos') {
        filtrados = filtrados.filter(r => r.evento === tipo);
    }

    // Filtro por fecha
    if (fecha) {
        filtrados = filtrados.filter(r => {
            const fechaRegistro = new Date(r.fecha);
            const fechaFormateada = fechaRegistro.toISOString().split('T')[0]; // YYYY-MM-DD
            return fechaFormateada === fecha;
        });
    }

    pintarTabla(filtrados);
}



async function verRegistros() {
    try {
        const response = await fetch(`${API_BASE_URL}/auditoria/ver`);

        if (!response.ok) {
            const errorData = await response.json();
            throw errorData;
        }

        const data = await response.json();
        registrosGlobal = data; // Guardamos todos los registros
        pintarTabla(registrosGlobal); // Pintamos todos inicialmente

    } catch (error) {
        console.error('Error al obtener registros:', error);
        showAlert(error.error || 'Error al obtener registros', 'danger');
    }
}

function pintarTabla(registros) {
    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = '';

    registros.forEach(registro => {
        const fila = document.createElement('tr');

        const fechaHora = `${formatearFecha(registro.fecha)} ${formatearHora(registro.hora)}`;

        fila.innerHTML = `
            <td>${fechaHora}</td>
            <td>${registro.email}</td>
            <td>${registro.cedula}</td>
            <td>${registro.evento}</td>
        `;

        tbody.appendChild(fila);
    });
}



function formatearFecha(fechaStr) {
    const fecha = new Date(fechaStr);
    const dia = fecha.getUTCDate().toString().padStart(2, '0');
    const mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0'); // Enero = 0
    const año = fecha.getUTCFullYear();

    return `${dia}/${mes}/${año}`;
}

function formatearHora(horaStr) {
    return horaStr.split('.')[0]; // 
}

// Función para mostrar alertas
function showAlert(message, type) {
    alert(`${type.toUpperCase()}: ${message}`);
}
