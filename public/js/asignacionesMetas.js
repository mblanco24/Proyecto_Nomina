
const API_URL_BASE  = "http://127.0.0.1:5041" // ---> CAMBIAR POR LA DIRECCION IP DE LA MAQUINA QUE ESTE CORRIENDO PYTHON


document.getElementById('btn-asignacion').addEventListener('click', () => {
  // Fetch empleados
  fetch(`${API_URL_BASE}/pagos/ver/empleados`)
    .then(res => res.json())
    .then(data => {
      const selectEmpleado = document.querySelector('select[name="empleado_id"]');
      selectEmpleado.innerHTML = ''; // Limpiar

      const defaultOption = document.createElement('option');
      defaultOption.value = '';
      defaultOption.textContent = '-- Seleccione un empleado --';
      selectEmpleado.appendChild(defaultOption);

      data.forEach(empleado => {
        const option = document.createElement('option');
        option.value = empleado.cedula;
        option.textContent = `${empleado.nombre} ${empleado.apellido}`;
        selectEmpleado.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error al cargar empleados:', error);
    });

  // Fetch metas
  fetch(`${API_URL_BASE}/pagos/ver/metas`)
    .then(res => res.json())
    .then(data => {
      const selectMeta = document.querySelector('select[name="meta_id"]');
      selectMeta.innerHTML = ''; // Limpiar

      const defaultOption = document.createElement('option');
      defaultOption.value = '';
      defaultOption.textContent = '-- Seleccione una meta --';
      selectMeta.appendChild(defaultOption);

      data.forEach(meta => {
        const option = document.createElement('option');
        option.value = meta.id_meta;
        option.textContent = meta.descripcion;
        selectMeta.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error al cargar metas:', error);
    });



    document.getElementById('asignar').addEventListener('click', function (e) {
        e.preventDefault();
       const cedula = document.querySelector('select[name="empleado_id"]').value
       const meta = document.querySelector('select[name="meta_id"]').value
       const fecha_limite = document.querySelector('input[name="fecha_limite"]').value
       const feriadoCheckbox  = document.querySelector('input[name="Feriado"]')
       const feriado = feriadoCheckbox.checked;

       console.log("feriado" , feriado);
       
       console.log(cedula);
       console.log(meta);
       console.log(fecha_limite);

        fetch(`${API_URL_BASE}/pagos/asignacion_de_metas`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'  // Importante para indicar que el cuerpo es JSON
        },
        body: JSON.stringify({
            cedula_empleado: cedula,
            fecha_completacion: fecha_limite,
            id_meta: meta,
            feriado : feriado
        })
        })
        .then(response => response.json())
        .then(data => {
         Swal.fire('Meta asignada', '', 'success').then(() => {
          location.reload();
        });

          
        console.log('Respuesta del servidor:', data.Respuesta);
        })
        .catch(error => {
        console.error('Error en la petición:', error);
        });
       
    })
});

let asignacionesData = [];
let biometricoData = [];
let currentPage = 1;
const itemsPerPage = 8; 
let empleadosFiltrados = [];


document.addEventListener("DOMContentLoaded", async () => {
    try {
        const [asignacionesResp, biometricoResp] = await Promise.all([
            fetch(`${API_URL_BASE}/pagos/asignaciones`),
            fetch(`${API_URL_BASE}/pagos/biometrico/ver`)
        ]);

        asignacionesData = await asignacionesResp.json();
        biometricoData = await biometricoResp.json();

        renderAccordion(asignacionesData, biometricoData , currentPage);

        const filtroInput = document.getElementById('filtroCedula');
        filtroInput.addEventListener('input', () => {
            const filtro = filtroInput.value.trim().toLowerCase();
            currentPage = 1;  // Reiniciar a la primera página

            empleadosFiltrados = asignacionesData.filter(emp =>
                emp.cedula && emp.cedula.toLowerCase().includes(filtro)
            );

            renderAccordion(empleadosFiltrados, biometricoData, currentPage);
        });;

    } catch (error) {
        console.error("Error cargando datos:", error);
    }
});


function renderAccordion(empleados, biometrico, page = 1) {
    const container = document.getElementById('metasAccordion');
    container.innerHTML = ''; // Limpiar el contenido previo


    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const empleadosPaginados = empleados.slice(startIndex, endIndex);

    empleadosPaginados.forEach((empleado, index) => {
        const globalIndex = startIndex + index;
        const collapseId = `collapse${globalIndex}`;
        const headingId = `heading${globalIndex}`;


        const metasRows = empleado.metas.map(meta => {
            // Buscar registros biométricos por cédula y día
            const registros = biometrico.filter(reg => 
                reg.cedula === empleado.cedula && reg.dia === meta.dia_asignado
            );

            const entrada = registros.find(r => r.evento === 'ENTRADA');
            const salida = registros.find(r => r.evento === 'SALIDA');
            const ruta = entrada?.rutas || salida?.rutas || 'N/A';

            const llegada = entrada?.hora || 'N/D';
            const salidaHora = salida?.hora || 'N/D';
            
                let colorClase = '';
                if (llegada !== 'N/D') {
                    const [horaStr, minutoStr] = llegada.split(':');
                    const hora = parseInt(horaStr, 10);
                    const minuto = parseInt(minutoStr, 10);
                    const totalMinutos = hora * 60 + minuto;

                    if (totalMinutos < 420) {
                        colorClase = 'text-success'; // Antes de 7:00
                    } else if (totalMinutos <= 430) {
                        colorClase = 'text-warning'; // Entre 7:00 y 7:10
                    } else {
                        colorClase = 'text-danger'; // Después de 7:10
                    }
                }

                    return `
                <tr>
                    <td>${meta.descripcion}</td>
                    <td>${formatDate(meta.fecha_completacion)}</td>
                    <td>${meta.estado}</td>
                    <td>${meta.dia_asignado}</td>
                    <td class="${meta.feriado ? 'text-success' : 'text-danger'}">
                        ${meta.feriado ? 'Sí' : 'No'}
                    </td>
                    <td class="${colorClase}">${llegada}</td>
                    <td>${salidaHora}</td>
                    <td>${ruta}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="eliminarMeta(${meta.id_asignacion})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                            <button class="btn btn-sm btn-success" onclick="mostrarModalValidarMeta(${meta.id_asignacion})">
                                <i></i> Completada
                            </button>
                        
                    </td>
                </tr>
            `;
        }).join('');

        const accordionItem = `
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header" id="${headingId}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold">${empleado.nombre}</span>
                                <span class="text-muted ms-3">${empleado.cedula}</span>
                            </div>
                            <div>
                                <span class="badge bg-secondary">Unidad</span>
                                <span class="badge bg-info ms-2">Cargo</span>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="${collapseId}" class="accordion-collapse collapse" aria-labelledby="${headingId}" data-bs-parent="#metasAccordion">
                    <div class="accordion-body pt-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-0">Metas asignadas</h6>
                            
                        </div>
                        <div class="scrollable-table">

                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Meta</th>
                                        <th>Asignación</th>
                                        <th>Estado</th>
                                        <th>Día</th>
                                        <th>Feriado</th>
                                        <th>Hora Llegada</th>
                                        <th>Hora Salida</th>
                                        <th>Ruta</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${metasRows}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', accordionItem);
    });
    renderPagination(empleados.length, page);
}




function formatDate(fechaStr) {
    if (!fechaStr) return '';

    // Asegúrate de que sea un Date válido
    const fecha = new Date(fechaStr);
    if (isNaN(fecha)) return '';

    const day = String(fecha.getUTCDate()).padStart(2, '0');
    const month = fecha.getUTCMonth(); // 0-indexed
    const year = fecha.getUTCFullYear();

    const meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
    return `${day} ${meses[month]} ${year}`;
}


function asignarMetaModal(cedula, nombre) {
    alert(`Abrir modal para asignar meta a ${nombre} (${cedula})`);
}

function eliminarMeta(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${API_URL_BASE}/pagos/delete/asignaciones/${id}`, {
                method: 'DELETE',
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al eliminar la meta');
                }
                Swal.fire('Meta eliminada correctamente', '', 'success').then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar la meta', 'error');
            });
        }
    });
}


function formatDateISO(date) {
  const d = new Date(date);
  const year = d.getFullYear();
  const month = String(d.getMonth() + 1).padStart(2, '0'); // Enero es 0
  const day = String(d.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}


function Validar(id, fecha_pago, monto) {
  fetch(`${API_URL_BASE}/pagos/update/meta/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      fecha_pago: fecha_pago,
      monto: monto
    })
  })
  .then(res => res.json())
  .then(data => {
    console.log("Respuesta del servidor:", data);
    Swal.fire('Meta validada', 'La meta fue actualizada correctamente.', 'success');
  })
  .catch(error => {
    console.error('Error al actualizar:', error);
    Swal.fire('Error', 'No se pudo actualizar la meta.', 'error');
  });
}

async function mostrarModalValidarMeta(id) {
  const { value: formValues } = await Swal.fire({
    title: 'Validar Meta',
    html:
      `<input type="date" id="swal-fecha-pago" class="swal2-input" placeholder="Fecha de Pago">` +
      `<input type="number" id="swal-monto" class="swal2-input" placeholder="Monto">`,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar',
    preConfirm: () => {
      const fechaPago = document.getElementById('swal-fecha-pago').value;
      const monto = document.getElementById('swal-monto').value;

      if (!fechaPago || !monto) {
        Swal.showValidationMessage('Todos los campos son obligatorios');
        return false;
      }

      return {
        fecha_pago: fechaPago,
        monto: parseFloat(monto)
      };
    }
  });

  if (formValues) {
    // Llamamos a la función de validación con los datos ingresados
    Validar(id, formValues.fecha_pago, formValues.monto);
  }
}


function formatToDateOnly(fechaStr) {
    return new Date(fechaStr).toISOString().slice(0, 10); // YYYY-MM-DD
}

document.getElementById('btn-reporte').addEventListener('click', () =>{
   fetch(`${API_URL_BASE}/pagos/ver/reportes`)
  .then(response => response.json())
  .then(data => {
    generarTabla(data);
  })
  .catch(error => {
    console.error("Error al obtener los datos:", error);
  });

function generarTabla(data) {
  const container = document.getElementById("tablaReportesContainer");

  const tabla = document.createElement("table");
  tabla.className = "table table-bordered table-hover";

  tabla.innerHTML = `
    <thead class="table-light">
      <tr>
        <th rowspan="2">CÉDULA</th>
        <th rowspan="2">NOMBRE Y APELLIDO</th>
        <th rowspan="2">NIVEL/CARGO</th>
        <th rowspan="2">DIRECCIÓN</th>
        <th rowspan="2">DIAS PENDIENTES</th>
        <th colspan="4" class="text-center">TOTAL METAS</th>
      </tr>
      <tr>
        <th>L-V</th>
        <th>S-D-F</th>
        <th>DÍA PEND.</th>
        <th>TOTAL</th>
        <th>MONTO</th>
      </tr>
    </thead>
    <tbody></tbody>
    <tfoot>
      <tr class="table-active fw-bold">
        <td colspan="4" class="text-end">TOTALES:</td>
        <td class="text-center" id="totalDiasPend"></td>
        <td class="text-center" id="totalLV"></td>
        <td class="text-center" id="totalSDF"></td>
        <td class="text-center" id="totalDiaPend"></td>
        <td class="text-center" id="totalMetas"></td>
        <td class="text-end" id="totalMonto"></td>
      </tr>
    </tfoot>
  `;

  const tbody = tabla.querySelector("tbody");

  let totalDiasPend = 0;
  let totalLV = 0;
  let totalSDF = 0;
  let totalDiaPend = 0;
  let totalMetas = 0;
  let totalMonto = 0;

  data.forEach(item => {
    const diaPend = item["DIAS PENDIENTES"] || 0;
    const lv = item["TOTAL DÍA PEND. L-V"] || 0;
    const sdf = item["S-D-F"] || 0;
    const total = lv + sdf;
    const monto = total * item['monto'];

    const fila = document.createElement("tr");
    fila.innerHTML = `
      <td data-id=${item['CÉDULA']}>${item["CÉDULA"]}</td>
      <td>${item["NOMBRE Y APELLIDO"]}</td>
      <td>${item["NIVEL/CARGO"]}</td>
      <td>${item["DIRECCIÓN"]}</td>
      <td class="text-center">${diaPend}</td>
      <td class="text-center">${lv}</td>
      <td class="text-center">${sdf}</td>
      <td class="text-center">${diaPend}</td>
      <td class="text-center">${total}</td>
      <td class="text-end">${monto.toFixed(2)}</td>
    `;
    tbody.appendChild(fila);

    totalDiasPend += diaPend;
    totalLV += lv;
    totalSDF += sdf;
    totalDiaPend += diaPend;
    totalMetas += total;
    totalMonto += monto;
  });

  tabla.querySelector("#totalDiasPend").textContent = totalDiasPend;
  tabla.querySelector("#totalLV").textContent = totalLV;
  tabla.querySelector("#totalSDF").textContent = totalSDF;
  tabla.querySelector("#totalDiaPend").textContent = totalDiaPend;
  tabla.querySelector("#totalMetas").textContent = totalMetas;
  tabla.querySelector("#totalMonto").textContent = totalMonto.toFixed(2);

  container.innerHTML = "";
  container.appendChild(tabla);
}
})



document.getElementById('btn-exportar').addEventListener('click', async () => {
    try {
        const response = await fetch('http://127.0.0.1:5041/pagos/txt', {
            method: 'GET',
        });

    if (!response.ok) {
        const errorData = await response.json();
        Swal.fire({
          icon: 'error',
          title: '¡Hubo un error!',
          text: errorData.Error || 'Error desconocido',
          confirmButtonText: 'Aceptar'
      });
        return;
    }

        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);

        const a = document.createElement('a');
        a.href = url;
        a.download = 'pago_empleados.txt';
        document.body.appendChild(a);
        a.click();
        a.remove();

        window.URL.revokeObjectURL(url);
    } catch (error) {
      console.log(error);
      
        alert('Hubo un error inesperado: ' + error.message);
    }
});



function renderPagination(totalItems, currentPage) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const pagination = document.getElementById('paginacion');
    pagination.innerHTML = '';

    const createPageItem = (page, label, isActive = false, isDisabled = false) => {
        return `
            <li class="page-item ${isActive ? 'active' : ''} ${isDisabled ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${page}">${label}</a>
            </li>
        `;
    };

    // Anterior
    pagination.innerHTML += createPageItem(currentPage - 1, 'Anterior', false, currentPage === 1);

    // Números de página
    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += createPageItem(i, i, currentPage === i);
    }

    // Siguiente
    pagination.innerHTML += createPageItem(currentPage + 1, 'Siguiente', false, currentPage === totalPages);

    // Eventos de clic
    pagination.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const page = parseInt(e.target.dataset.page);
            if (!isNaN(page) && page >= 1 && page <= totalPages) {
                currentPage = page;
                const datos = empleadosFiltrados.length ? empleadosFiltrados : asignacionesData;
                renderAccordion(datos, biometricoData, currentPage);
            }
        });
    });
}


