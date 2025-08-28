

// Variable global para almacenar empleados
const API_BASE_URL = 'http://127.0.0.1:5041'
let allEmployees = [];
const asd = ''

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    fetchEmployees();
});

// Obtener empleados desde la API
async function fetchEmployees() {
    try {
        const response = await fetch(`${API_BASE_URL}/usuarios/get`);

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

document.getElementById('filtroCedula').addEventListener('input', (e) => {
    const valor = e.target.value.trim().toLowerCase();

    const filtrados = allEmployees.filter(emp =>
        emp.cedula && emp.cedula.toLowerCase().includes(valor)
    );

    renderEmployees(filtrados);
});

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
            <td>${employee.email || ''}</td>
            <td>${employee.departamento || 'N/A'}</td>
            <td>${employee.cargo || 'N/A'}</td>
            <td >${employee.nombre_rol || 'N/A'}</td> 
            <td data-value="${employee.super_user}"><span style="color: ${employee.super_user ? 'green' : 'red'};">
                    ${employee.super_user ? 'Sí' : 'No'}
                </span>
            </td>
         
            <td>

                <button class="btn btn-sm btn-warning btn-edit" data-id="${employee.id}">
                    <i class="fas fa-edit"></i>
                </button>
                
            </td>
        `;
        tableBody.appendChild(row);
    });

    setupEventListeners(); // Configurar eventos después de renderizar
}





document.addEventListener('click', async function (e) {
    if (e.target.closest('.btn-edit')) {
        const button = e.target.closest('.btn-edit');
        const cedula = button.getAttribute('data-id');
        const row = button.closest('tr');
        const tdSuperUser = row.querySelector('td[data-value]');
        const tdRol = row.querySelector('td[data-rol]');
        const valorActual = tdSuperUser ? tdSuperUser.getAttribute('data-value') : 'false';
        const nuevoValor = valorActual === 'true' ? 'false' : 'true';

        const resultado = await Swal.fire({
            title: 'Acciones disponibles',
            text: '¿Qué deseas hacer con este usuario?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Cambiar estado',
            cancelButtonText: 'Cambiar rol',
            reverseButtons: true
        });

        // ✅ CAMBIAR ESTADO ACTIVO/INACTIVO
        if (resultado.isConfirmed) {
            try {
                const response = await fetch(`${API_BASE_URL}/usuarios/update/${cedula}/${nuevoValor}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    Swal.fire('¡Actualizado!', 'El estado ha sido modificado.', 'success');
                    tdSuperUser.setAttribute('data-value', nuevoValor);
                    tdSuperUser.innerHTML = `
                        <span style="color: ${nuevoValor === 'true' ? 'green' : 'red'};">
                            ${nuevoValor === 'true' ? 'Sí' : 'No'}
                        </span>
                    `;
                } else {
                    Swal.fire('Error', 'Hubo un problema al actualizar.', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'No se pudo conectar al servidor.', 'error');
            }

        } else if (resultado.dismiss === Swal.DismissReason.cancel) {
            // ✅ CAMBIAR ROL
            try {
                // Obtener roles desde la API
                const rolesRes = await fetch(`${API_BASE_URL}/usuarios/get/roles`);
                const roles = await rolesRes.json();

                // Crear un <select> con los roles
                const selectHTML = `
                    <select id="select-rol" class="swal2-select" style="width: 60%; padding: 0.5em;">
                        ${roles.map(rol => `<option value="${rol.id_rol}">${rol.nombre_rol}</option>`).join('')}
                    </select>
                `;

                const rolResultado = await Swal.fire({
                    title: 'Cambiar rol',
                    html: selectHTML,
                    preConfirm: () => {
                        const selectedRol = document.getElementById('select-rol').value;
                        return selectedRol;
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Actualizar',
                    cancelButtonText: 'Cancelar'
                });

                if (rolResultado.isConfirmed) {
                    const nuevoRolId = rolResultado.value;

                    const response = await fetch(`${API_BASE_URL}/usuarios/update/rol/${cedula}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ rol_id: nuevoRolId })
                    });

                    if (response.ok) {
                        Swal.fire('¡Rol actualizado!', 'El rol del usuario fue modificado.', 'success');
                        // Aquí puedes actualizar la tabla si deseas mostrar el nuevo rol
                        window.location.reload()
                    } else {
                        Swal.fire('Error', 'Hubo un problema al actualizar el rol.', 'error');
                    }
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'No se pudo obtener la lista de roles.', 'error');
            }
        }
    }
});
















