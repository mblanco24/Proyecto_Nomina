// Variable global para almacenar empleados
const API_BASE_URL =  'http://127.0.0.1:5041'
let allEmployees = [];
const asd = ''

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    fetchEmployees();

     const filtroInput = document.getElementById('filtroCedula');
    filtroInput.addEventListener('input', function () {
        const filtro = this.value.trim().toLowerCase();
        const empleadosFiltrados = allEmployees.filter(emp =>
            emp.cedula.toLowerCase().includes(filtro)
        );
        renderEmployees(empleadosFiltrados);
    });
});

// Obtener empleados desde la API
async function fetchEmployees() {
    try {
        const response = await fetch(`${API_BASE_URL}/empleados/`);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        allEmployees = await response.json();
        console.log('Empleados obtenidos:', allEmployees);
        renderEmployees(allEmployees);
    } catch (error) {
        console.error('Error al obtener empleados:', error);
        showAlert('Error al cargar los empleados', 'danger');
    }
}



// Renderizar empleados en la tabla
function renderEmployees(employees) {
    const tableBody = document.getElementById('cuerpoTablaEmpleados');
    tableBody.innerHTML = '';

    const infoAlert = document.querySelector('.alert-info');
    if (infoAlert) {
        infoAlert.style.display = 'none';
    }

    employees.forEach((employee, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${employee.cedula}</td>
            <td>${employee.nombre || ''} ${employee.apellido || ''}</td>
            <td>${employee.nivel || 'N/A'}</td>
            <td>${employee.departamento || 'N/A'}</td>
            <td>
                <button class="btn btn-sm btn-info btn-view" data-id="${employee.cedula}">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-warning btn-edit" data-id="${employee.cedula}">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${employee.cedula}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    setupEventListeners(); // Configurar eventos después de renderizar
}


async function showEmployeeDetails(cedula) {
    try {
        console.log(`Buscando empleado con cédula: ${cedula}`);
        const response = await fetch(`${API_BASE_URL}/empleados/${cedula}`);

        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const empleado = await response.json();
        console.log('Datos del empleado:', empleado);

        // Verifica que Bootstrap esté disponible
        if (typeof bootstrap === 'undefined') {
            throw new Error('Bootstrap no está cargado correctamente');
        }

        // Obtener el modal
        const modalElement = document.getElementById('employeeDetailsModal');
        if (!modalElement) {
            throw new Error('No se encontró el modal en el DOM');
        }

        // Llenar datos
        document.getElementById('modalEmployeeName').textContent = empleado[0].nombre || 'N/A';
        document.getElementById('modalEmployeeape').textContent = empleado[0].apellido || 'N/A';
        document.getElementById('modalEmployeePosition').textContent = empleado[0].cargo || 'N/A';
        document.getElementById('modalEmployeeCedula').textContent = empleado[0].cedula || 'N/A';
        document.getElementById('modalEmployeeDepartment').textContent = empleado[0].departamento || 'N/A';
        document.getElementById('modalEmployeeBanco').textContent = empleado[0].banco || 'N/A';
        document.getElementById('nc').textContent = empleado[0].numero_cuenta || 'N/A';

        // Mostrar modal
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

    } catch (error) {
        console.error('Error:', error);
        showAlert(`Error al cargar detalles: ${error.message}`, 'danger');
    }
}

// Mostrar alerta
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Insertar al inicio del card-body
    const cardBody = document.querySelector('.card-body');
    cardBody.prepend(alertDiv);

    // Eliminar después de 5 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Configurar el evento para el botón guardar
function setupEmployeeForm() {
    document.getElementById('guardarempleado').addEventListener('click', async function() {
        const form = document.getElementById('formNuevoEmpleado');
        const submitBtn = this;
        const originalBtnText = submitBtn.innerHTML;

        // Validar formulario antes de enviar
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        // Mostrar estado de carga
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

        try {
            // Obtener datos del formulario
            const formData = {
                cedula: document.getElementById('cedula').value,
                nombre: document.getElementById('nombre').value,
                apellido: document.getElementById('apellido').value,
                puesto: document.getElementById('cargo').value,
                nomina :document.getElementById('nomina').value,
                cargo : document.getElementById('cargo').value,
                nivel :  document.getElementById('nivel').value,
                departamento: document.getElementById('departamento').value,
                salario_base: document.getElementById('salario_base').value,
                numero_cuenta: document.getElementById('numero_cuenta').value,
                banco: document.getElementById('edit_banco').value,
                tipo_de_cuenta: document.getElementById('tipo_cuenta').value
            };

            // Enviar datos al servidor
            const response = await fetch(`${API_BASE_URL}/empleados/new`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            // Procesar respuesta
            if (!response.ok) {
                const errorData = await response.json();
                throw errorData;
            }

            const data = await response.json();


            // Cerrar modal y limpiar formulario
            const modal = bootstrap.Modal.getInstance(document.getElementById('empleadoDetalleModal'));
            modal.hide();
            form.reset();
            form.classList.remove('was-validated');

            // Mostrar mensaje de éxito
            showAlert(data.message || 'Empleado creado exitosamente', 'success');

            // Actualizar la lista de empleados
            await fetchEmployees();

        } catch (error) {
            console.error('Error al crear empleado:', error);

            // Mostrar errores de validación
            if (error.errors) {
                for (const [field, messages] of Object.entries(error.errors)) {
                    const input = document.getElementById(field);
                    if (input) {
                        input.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = messages.join(', ');
                        input.parentNode.appendChild(errorDiv);
                    }
                }
            } else {
                showAlert(error.error || 'Error al crear el empleado', 'danger');
            }
        } finally {
            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    // Limpiar errores al cambiar los campos
    const inputs = document.querySelectorAll('#formNuevoEmpleado input, #formNuevoEmpleado select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = this.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.remove();
            }
        });
    });
}

// Función para mostrar alertas
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    const cardBody = document.querySelector('.card-body');
    cardBody.prepend(alertDiv);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}


// Configurar eventos para los botones (actualizada)
function setupEventListeners() {
    // Botones de ver detalles
    document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', function() {
            const employeeCedula = this.getAttribute('data-id');
            showEmployeeDetails(employeeCedula);
        });
    });

    // Botones de editar
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const employeeCedula = this.getAttribute('data-id');
            prepareEditForm(employeeCedula);
        });
    });

    // Formulario de edición
    document.getElementById('formEditEmployee').addEventListener('submit', function(e) {
        e.preventDefault();
        updateEmployee();
    });

        // Botones de eliminar
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const employeeCedula = this.getAttribute('data-id');
            confirmDelete(employeeCedula);

        });
    });

}

// Preparar formulario de edición con datos del empleado
async function prepareEditForm(cedula) {
    try {
        const response = await fetch(`${API_BASE_URL}/empleados/${cedula}`);
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const empleado = await response.json();
        const employeeData = Array.isArray(empleado) ? empleado[0] : empleado;
        console.log(employeeData);

        // Llenar formulario
        document.getElementById('edit_cedula').value =employeeData.cedula
        document.getElementById('edit_nombre').value = employeeData.nombre || '';
        document.getElementById('edit_apellido').value = employeeData.apellido || '';
        document.getElementById('edit_email').value = employeeData.email || '';
        document.getElementById('edit_puesto').value = employeeData.cargo || '';
        document.getElementById('edit_departamento').value = employeeData.departamento || '';
        document.getElementById('edit_salario_base').value = employeeData.salario_base || '';
        document.getElementById('edit_nc').value = employeeData.numero_cuenta || '';
        document.getElementById('edit_banco').value = employeeData.banco || '';



        // Establecer banco (asegúrate que coincida exactamente con las opciones)
        if (employeeData.banco) {
            const bancoSelect = document.getElementById('edit_banco');
            bancoSelect.value = employeeData.banco;

            // Si el valor no coincide exactamente, establecer el primero como fallback
            if (bancoSelect.value !== employeeData.banco) {
                bancoSelect.value = bancoSelect.options[0].value;
            }
        }

        // Establecer tipo de cuenta (departamento)
        if (employeeData.tipo_cuenta) { // Cambia esto al campo correcto de tu API
            const tipoCuentaSelect = document.getElementById('edit_departamento');
            tipoCuentaSelect.value = employeeData.tipo_cuenta; // O employeeData.departamento si ese es el campo

            // Validar que el valor exista en las opciones
            const opcionesValidas = Array.from(tipoCuentaSelect.options).map(opt => opt.value);
            if (!opcionesValidas.includes(tipoCuentaSelect.value)) {
                tipoCuentaSelect.value = 'Corriente'; // Valor por defecto
            }
        }


        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
        modal.show();

    } catch (error) {
        console.error('Error al preparar edición:', error);
        showAlert('Error al cargar datos para edición', 'danger');
    }
}

// Actualizar empleado
async function updateEmployee() {
    const form = document.getElementById('formEditEmployee');
    const submitBtn = form.querySelector('button[type="submit"]');
   // const originalBtnText = submitBtn.innerHTML;
    const cedula = document.getElementById('edit_cedula').value;
    console.log(cedula);

    // Mostrar estado de carga
    //submitBtn.disabled = true;
    //submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualizando...';

    try {
        // Obtener datos del formulario
        const formData = {
            nombre: document.getElementById('edit_nombre').value,
            apellido: document.getElementById('edit_apellido').value,
            nomina: document.getElementById('edit_nomina').value,
            cargo: document.getElementById('edit_cargo').value,
            nivel: document.getElementById('edit_nivel').value,
            departamento: document.getElementById('edit_departamento').value,
            puesto: document.getElementById('edit_puesto').value,
            salario_base: parseFloat(document.getElementById('edit_salario_base').value),
            numero_cuenta: document.getElementById('edit_nc').value,
            banco: document.getElementById('edit_banco').value,
            tipo_de_cuenta: document.getElementById('edit_tipocuenta').value
        };

        // Enviar datos al servidor
        const response = await fetch(`${API_BASE_URL}/empleados/update/${cedula}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw errorData;
        }

        const data = await response.json();
        console.log('Empleado actualizado:', data);

        // Cerrar modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editEmployeeModal'));
        modal.hide();

        // Mostrar mensaje de éxito
        showAlert('Empleado actualizado exitosamente', 'success');

        // Actualizar la lista de empleados
        await fetchEmployees();

    } catch (error) {
        console.error('Error al actualizar empleado:', error);
        showAlert(error.message || 'Error al actualizar el empleado', 'danger');
    } finally {
        // Restaurar botón
        submitBtn.disabled = false;
        //submitBtn.innerHTML = originalBtnText;
    }
}

// Función para confirmar eliminación
async function confirmDelete(cedula) {
    // Mostrar confirmación (puedes usar SweetAlert o confirm nativo)
    const isConfirmed = confirm(`¿Estás seguro de eliminar al empleado con cédula ${cedula}?`);
console.log(isConfirmed);
    if (!isConfirmed) return;
    deleteEmployee(cedula);

}

// Función para eliminar empleado
async function deleteEmployee(cedula) {
    try {
        // Obtener el botón de eliminar
        const deleteBtn = document.querySelector(`.btn-delete[data-id="${cedula}"]`);
        const originalContent = deleteBtn.innerHTML;

        // Mostrar estado de carga
        deleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        deleteBtn.disabled = true;

        // Enviar solicitud de eliminación
        const response = await fetch(`${API_BASE_URL}/empleados/delete/${cedula}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        // Mostrar mensaje de éxito
        showAlert('Empleado eliminado correctamente', 'success');

        // Actualizar la lista de empleados
        await fetchEmployees();

    } catch (error) {
        console.error('Error al eliminar empleado:', error);
        showAlert('Error al eliminar el empleado', 'danger');

        // Restaurar botón
        const deleteBtn = document.querySelector(`.btn-delete[data-id="${cedula}"]`);
        if (deleteBtn) {
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.disabled = false;
        }
    }
}





// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    fetchEmployees();
    setupEmployeeForm();
    setupEventListeners();
});

