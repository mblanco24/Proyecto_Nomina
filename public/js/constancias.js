// 1. Definir la constante con el nombre correcto al inicio del archivo
const API_BASE_URL = "http://127.0.0.1:5041"; // Cambiar por la IP correcta

// 2. Variables globales
let employees = [];
let constancias = [];


// 3. Evento DOMContentLoaded corregido
document.addEventListener('DOMContentLoaded', async  function () {
    setupConstanciaModal();
    fetchConstancias();
    const filtroInput = document.getElementById('filtroCedula');
    filtroInput.addEventListener('input', function () {
        const filtro = this.value.trim().toLowerCase();
        const constanciasFiltradas = constancias.filter(c =>
            c.cedula_empleado && c.cedula_empleado.toLowerCase().includes(filtro)
        );
        renderConstancias(constanciasFiltradas);
    });

    const valor_correlativo = await correlativo_constancia();
    console.log(valor_correlativo)
    localStorage.setItem('correlativo', `000${valor_correlativo[0]['id_constancia']}`)
    

});

// 4. Función fetchEmployees corregida

async function correlativo_constancia() {
    try {
        const response = await fetch(`${API_BASE_URL}/constancias/correlativo`);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        constancias = await response.json();
        

    } catch (error) {
        console.error('Error al obtener constancias:', {

        });
        
    }
    return constancias
}


// 5. Función fetchConstancias corregida
async function fetchConstancias() {
    try {
        const response = await fetch(`${API_BASE_URL}/constancias/`);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        constancias = await response.json();
        renderConstancias(constancias);
    } catch (error) {
        console.error('Error al obtener constancias:', {
            error: error,
            endpoint: `${API_BASE_URL}/constancias/`,
            message: error.message
        });
        showAlert('Error al cargar las constancias', 'danger');
    }
}

// 6. Resto de las funciones manteniendo la consistencia en el uso de API_BASE_URL
function renderEmployeeOptions(employees) {
    const select = document.getElementById('employeeSelect');
    if (!select) return;

    while (select.options.length > 1) {
        select.remove(1);
    }

    employees.forEach(employee => {
        const option = document.createElement('option');
        option.value = employee.id;
        option.textContent = employee.name || `${employee.nombre} ${employee.apellido}`;
        select.appendChild(option);
    });
}

// 7. Función setupConstanciaModal corregida
function setupConstanciaModal() {
    const form = document.querySelector('#requestConstanciaModal form');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = {
            cedula_empleado: document.getElementById('cedula_empleado').value,
            tipo_constancia: document.getElementById('tipo_constancia').value,
            fecha_generacion: document.getElementById('fecha_generacion').value
        };

        try {
            const response = await fetch(`${API_BASE_URL}/constancias/new`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const result = await response.json();
            showAlert('Solicitud de constancia enviada con éxito', 'success');
            window.location.reload();
        } catch (error) {
            console.error('Error al enviar solicitud:', error);
            showAlert('Error al enviar la solicitud de constancia', 'danger');
        }
    });
}

// 8. Función renderConstancias corregida
function renderConstancias(constancias) {
    const tbody = document.querySelector('.card-body tbody');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (constancias.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center">
                    <div class="alert alert-info m-0">No hay solicitudes de constancias registradas</div>
                </td>
            </tr>
        `;
        return;
    }

    constancias.forEach((constancia, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${constancia.cedula_empleado || 'N/A'}</td>
            <td>${constancia.tipo_constancia || 'N/A'}</td>
            <td>${constancia.fecha_generacion || 'N/A'}</td>
            <td>
                <button class="btn btn-sm btn-success btn-download"
                        data-id="${constancia.id}"
                        data-employee_name="${constancia.empleado_nombre || ''} ${constancia.empleado_apellido || ''}"
                        data-type="${constancia.tipo_constancia || ''}"
                        data-contenido="Por medio de la presente hacemos constar que el(la) Sr(a). ${constancia.empleado_nombre || ''} labora en nuestra empresa bajo el puesto de"
                        data-fecha="${new Date().toLocaleDateString('es-ES')}">
                    <i class="fas fa-download"></i> Descargar
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });

    setupDownloadButtons();
}



// 9. Funciones restantes manteniendo la consistencia
function setupDownloadButtons() {
    document.querySelectorAll('.btn-download').forEach(button => {
        button.addEventListener('click', function() {
            const data = {
                id: this.getAttribute('data-id'),
                employee_name: this.getAttribute('data-employee_name'),
                type: this.getAttribute('data-type'),
                contenido: this.getAttribute('data-contenido'),
                fecha: new Date().toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })
            };
            generatePDF(data);
        });
    });
}

async function generatePDF(data) {
    try {
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Constancia de ${data.type}</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; margin: 2cm; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .title { font-size: 18px; font-weight: bold; text-decoration: underline; }
                    .content { margin: 40px 0; text-align: justify; }
                    .footer { margin-top: 50px; text-align: right; }
                    .signature { margin-top: 80px; border-top: 1px solid #000; width: 50%; float: right; padding-top: 10px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="title">CONSTANCIA DE ${(data.type || '').toUpperCase()}</div>
                    <div>N° ${localStorage.getItem('correlativo')}</div>
                </div>

                <div class="content">
                    <p>A QUIEN CORRESPONDA:</p>
                    <p>${data.contenido}</p>
                    <p>Esta constancia es expedida a solicitud del interesado para los fines que estime conveniente.</p>
                </div>

                <div class="footer">
                    <div>Caracas, ${data.fecha}</div>
                    <div class="signature">
                        <p>_________________________</p>
                        <p>Nombre del Responsable</p>
                        <p>Gerente de Recursos Humanos</p>
                    </div>
                </div>
            </body>
            </html>
        `;

        const opt = {
            margin: 10,
            filename: `constancia_${(data.type || '').toLowerCase()}_${data.id}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        const element = document.createElement('div');
        element.innerHTML = html;
        document.body.appendChild(element);

        await html2pdf().set(opt).from(element).save();
        document.body.removeChild(element);
    } catch (error) {
        console.error('Error al generar PDF:', error);
        showAlert('Error al generar el PDF', 'danger');
    }
}

function showAlert(message, type) {
    const existingAlert = document.querySelector('.alert.alert-dismissible');
    if (existingAlert) existingAlert.remove();

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    const container = document.querySelector('.card-body');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    }
}
document.getElementById('btn_modal').addEventListener('click', () => {
  // Fetch empleados
  fetch(`${API_BASE_URL}/pagos/ver/empleados`)
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




});



