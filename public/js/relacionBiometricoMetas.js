const API_BASE_URL = 'http://127.0.0.1:5041'

const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

async function cargarTablaBiometrico() {
    try {
        const response = await fetch(`${API_BASE_URL}/pagos/realcionbiometa/ver`);
        const datos = await response.json();

        // Agrupar datos por cédula y nombre
        const agrupado = {};

        datos.forEach(item => {
            const clave = item.cedula + '|' + item.nombre_apellido;
            const dia = item.dia;
            const evento = item.evento;
            const hora = item.hora;
            const fecha = new Date(item.fecha).toLocaleDateString('es-VE');
            const ruta = item.descripcion;

            if (!agrupado[clave]) {
                agrupado[clave] = {
                    cedula: item.cedula,
                    nombre: item.nombre_apellido,
                    ruta: ruta || 'No registrado',
                    dias: {}
                };
            }

            if (!agrupado[clave].dias[dia]) {
                agrupado[clave].dias[dia] = {
                    entrada: 'No registrado',
                    salida: 'No registrado',
                    fecha: fecha
                };
            }

            if (evento === 'ENTRADA') {
                agrupado[clave].dias[dia].entrada = hora;
            } else if (evento === 'SALIDA') {
                agrupado[clave].dias[dia].salida = hora;
            }
        });

        // Obtener la primera fecha por cada día de la semana
        const fechasPorDia = {};

        datos.forEach(item => {
            const dia = item.dia;
            if (!fechasPorDia[dia]) {
                const fechaUTC = item.fecha;
                const partes = fechaUTC.split(', ')[1].split(' '); // ["14", "Apr", "2025"]
                const meses = {
                    Jan: '01', Feb: '02', Mar: '03', Apr: '04', May: '05', Jun: '06',
                    Jul: '07', Aug: '08', Sep: '09', Oct: '10', Nov: '11', Dec: '12'
                };
                const fechaFormateada = `${partes[0]}/${meses[partes[1]]}/${partes[2]}`;
                fechasPorDia[dia] = fechaFormateada;
            }
        });

        // Construir thead
        const thead = document.getElementById('table-head');
        thead.innerHTML = `
            <tr>
                <th rowspan="3">CÉDULA</th>
                <th rowspan="3">APELLIDOS Y NOMBRES</th>
                ${diasSemana.map(d => `<th colspan="2">${d.toUpperCase()}</th>`).join('')}
                <th rowspan="3">Descripcion de Meta</th>
                <th rowspan="3" width="15%">Estatus de Meta</th>
            </tr>
            <tr>
                ${diasSemana.map(d => {
                    const fecha = fechasPorDia[d] || '';
                    return `<th colspan="2" class="small">${fecha}</th>`;
                }).join('')}
            </tr>
            <tr>
                ${diasSemana.map(() => `
                    <th>ENTRADA</th>
                    <th>SALIDA</th>
                `).join('')}
            </tr>
        `;

        // Construir tbody
        const tbody = document.getElementById('table-body');
        tbody.innerHTML = '';

    function obtenerClasePorHora(horaStr) {
        if (horaStr === 'No registrado') return 'text-muted';

        const [hora, minuto] = horaStr.split(':').map(Number);
        const totalMinutos = hora * 60 + minuto;

        if (totalMinutos < 420) {
            return 'bg-success text-white'; // Verde
        } else if (totalMinutos <= 430) {
            return 'bg-warning text-dark'; // Amarillo
        } else {
            return 'bg-danger text-white'; // Rojo
        }
    }

    Object.values(agrupado).forEach(usuario => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td class="text-center">${usuario.cedula}</td>
            <td>${usuario.nombre}</td>
            ${diasSemana.map(d => {
                const diaData = usuario.dias[d] || { entrada: 'No registrado', salida: 'No registrado' };
                const entrada = diaData.entrada;
                const salida = diaData.salida;

                const entradaClase = obtenerClasePorHora(entrada);

                return `
                    <td class="text-center ${entradaClase}">${entrada}</td>
                    <td class="text-center ${salida === 'No registrado' ? 'text-muted' : ''}">${salida}</td>
                `;
            }).join('')}
            <td class="text-center ${usuario.ruta === 'No registrado' ? 'text-muted' : ''}">${usuario.ruta}</td>
            <td>
                <select class="form-select form-select-sm">
                    <option value="">Seleccionar</option>
                    <option value="procede">Cumple Meta</option>
                    <option value="no_procede">No Cumple Meta</option>
                </select>
            </td>
        `;

        tbody.appendChild(tr);
    });

    } catch (error) {
        console.error('Error al cargar la tabla biométrica:', error);
        Swal.fire('Error', 'No se pudo cargar la tabla de asistencia.', 'error');
    }
}


cargarTablaBiometrico();
