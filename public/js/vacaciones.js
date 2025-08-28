const API_BASE_URL = "http://127.0.0.1:5041";
let employees = [];
let vacations = [];

let modalEmpleado;
document.addEventListener('DOMContentLoaded', () => {
    modalEmpleado = new bootstrap.Modal(document.getElementById('employeeDetailsModal'));
         const filtroInput = document.getElementById('filtroCedula');
    filtroInput.addEventListener('input', function () {
        const filtro = this.value.trim().toLowerCase();
        const empleadosFiltrados = employees.filter(emp => 
            emp.cedula.toLowerCase().includes(filtro)
        );
        renderEmployees(empleadosFiltrados);
    });
});
// Obtener empleados desde la API
async function fetchEmployees() {
    try {
        const response = await fetch(`${API_BASE_URL}/vacaciones/`);
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        employees = await response.json();
        renderEmployees(employees);
    } catch (error) {
        console.error("Error al obtener empleados:", error);
        showAlert("Error al cargar los empleados", "danger");
    }
}

// Obtener vacaciones desde la API
async function fetchVacations() {
    try {
        const response = await fetch(`${API_BASE_URL}/vacaciones/`);
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        vacations = await response.json();
    } catch (error) {
        console.error("Error al obtener vacaciones:", error);
        showAlert("Error al cargar las vacaciones", "danger");
    }
}

// Renderizar empleados en la tabla
function renderEmployees(employees) {
    const tableBody = document.getElementById("employeeResponse");
    const noEmployeesAlert = document.getElementById("no-employees-alert");

    tableBody.innerHTML = "";

    if (employees.length === 0) {
        noEmployeesAlert.classList.remove("d-none");
        return;
    }

    noEmployeesAlert.classList.add("d-none");

    employees.forEach((employee, index) => {
        const row = document.createElement("tr");
        const antiquity = calculateAntiquity(employee.fecha_ingreso);
        const remainingDays = calculateRemainingVacationDays(employee.dias);

        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${employee.nombre} ${employee.apellido}</td>
            <td>${employee.cedula}</td>
            <td>
                <span class="badge bg-${getBadgeColor(remainingDays)}">
                    ${remainingDays} días
                </span>
            </td>
            <td>
                <button class="btn btn-sm btn-info text-white view-details-btn"
                        data-employee-cedula="${employee.cedula}">
                    <i class="fas fa-calendar-alt"></i> Detalles
                </button>
            </td>
        `;

        tableBody.appendChild(row);
    });

    setupEventListeners();
}

// Mostrar detalles del empleado
async function showEmployeeDetails(cedula) {
    try {
        // Obtener datos del empleado y sus vacaciones
        const [employeeRes, vacationsRes] = await Promise.all([
            fetch(`${API_BASE_URL}/empleados/${cedula}`),
            fetch(`${API_BASE_URL}/vacaciones/${cedula}`)
        ]);

        if (!employeeRes.ok || !vacationsRes.ok) {
            throw new Error("Error al obtener datos del empleado");
        }

        const [employee, vacations] = await Promise.all([
            employeeRes.json(),
            vacationsRes.json()
        ]);

        // Calcular días disponibles
        const remainingDays = calculateRemainingVacationDays(cedula);

        // Actualizar datos en el modal
        document.getElementById('detail-nombre').textContent = `${employee[0].nombre} ${employee[0].apellido}`;
        document.getElementById('detail-cedula').textContent = employee[0].cedula;
        document.getElementById('detail-email').textContent = employee.email || 'N/A';
        document.getElementById('detail-fecha-ingreso').textContent = new Date(employee[0].fecha_ingreso).toLocaleDateString();

        document.getElementById('detail-dias-disponibles').textContent = remainingDays;
        document.getElementById('detail-dias-disponibles').className = `badge bg-${getBadgeColor(remainingDays)}`;

        // Calcular últimas y próximas vacaciones
        const sortedVacations = [...vacations].sort((a, b) =>
            new Date(b.fecha_inicio) - new Date(a.fecha_inicio));

        const lastVacation = sortedVacations[0];;
        const upcomingVacation = sortedVacations.find(v => new Date(v.fecha_inicio) > new Date());
        const totalTaken = vacations.reduce((sum, v) => sum + v.dias, 0);

        document.getElementById('detail-ultimas-vacaciones').textContent = lastVacation
            ? `${new Date(lastVacation.fecha_inicio).toLocaleDateString()} - ${new Date(lastVacation.fecha_fin).toLocaleDateString()}`
            : 'Ninguna';

        document.getElementById('detail-proximas-vacaciones').textContent = upcomingVacation
            ? `${new Date(upcomingVacation.fecha_inicio).toLocaleDateString()} - ${new Date(upcomingVacation.fecha_fin).toLocaleDateString()}`
            : 'No programadas';

        document.getElementById('detail-total-tomados').textContent = `${totalTaken} días`;
        document.getElementById('detail-estado').textContent = employee[0].estado || 'Activo';
        document.getElementById('detail-estado').className = `badge bg-${employee[0].estado === 'Activo' ? 'success' : 'secondary'}`;

        // Mostrar modal

        modalEmpleado.show(); // ✅ Esto es suficiente


    } catch (error) {
        console.error('Error:', error);
        showAlert(`Error al cargar detalles: ${error.message}`, 'danger');
    }
}

// Configurar los modales y eventos
function setupModals() {
    // Modal para asignar días
    const assignModal = document.getElementById("assignVacationModal");
    const estadoSelect = document.getElementById("estado");

    // Mostrar/ocultar campos de aprobación
    estadoSelect.addEventListener("change", function() {
        document.getElementById("aprobacionContainer").style.display =
            this.value === "Aprobado" ? "block" : "none";
    });

    // Calcular fecha final automáticamente
    document.getElementById("fecha_inicio").addEventListener("change", calculateEndDate);
    document.getElementById("dias").addEventListener("input", calculateEndDate);

    // Confirmar asignación
    document.getElementById("confirmAssignVacation").addEventListener("click", async function() {
        console.log(document.getElementById("fecha_aprobacion").value);
        
        const formData = {
            cedula_empleado: document.getElementById("cedula_empleado").value,
            dias: document.getElementById("dias").value,
            fecha_inicio: document.getElementById("fecha_inicio").value,
            fecha_fin: document.getElementById("fecha_fin").value,
            fecha_solicitud: document.getElementById("fecha_solicitud").value,
            estado: document.getElementById("estado").value,
            fecha_aprobacion: document.getElementById("fecha_aprobacion").value
        };

        try {
            const response = await fetch(`${API_BASE_URL}/vacaciones/new`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Error en la solicitud");
            }

            const data = await response.json();
            bootstrap.Modal.getInstance(assignModal).hide();
            showAlert("Días asignados correctamente", "success");
            await fetchEmployees();
            document.getElementById("vacationForm").reset();

        } catch (error) {
            console.error("Error al asignar vacaciones:", error);
            showAlert(error.message, "danger");
        }
    });
}

// Calcular fecha final basada en días y fecha inicial
function calculateEndDate() {
    const startDate = document.getElementById("fecha_inicio").value;
    const days = document.getElementById("dias").value;

    if (startDate && days) {
        const date = new Date(startDate);
        date.setDate(date.getDate() + parseInt(days));
        document.getElementById("fecha_fin").value = date.toISOString().split('T')[0];
    }
}

// Funciones auxiliares
function calculateAntiquity(startDate) {
    const now = new Date();
    const start = new Date(startDate);
    const diffTime = Math.abs(now - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    return {
        years: Math.floor(diffDays / 365),
        months: Math.floor((diffDays % 365) / 30),
        days: Math.floor((diffDays % 365) % 30)
    };
}

function calculateRemainingVacationDays(cedula) {
    const employeeVacations = vacations.filter(v => v.cedula_empleado === cedula);
    const assignedDays = 15; // Días base asignados
    const takenDays = employeeVacations.reduce((sum, v) => sum + v.dias, 0);
    return assignedDays - takenDays;
}

function getBadgeColor(days) {
    return days > 10 ? "success" : days > 0 ? "warning" : "danger";
}

function showAlert(message, type) {
    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = "1060";
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    document.body.appendChild(alertDiv);

    setTimeout(() => { 
        alertDiv.remove();
    }, 5000);
}

// Configurar event listeners
function setupEventListeners() {
    // Botones de ver detalles
    document.addEventListener("click", function(e) {
        if (e.target.closest(".view-details-btn")) {
            const cedula = e.target.closest(".view-details-btn").getAttribute("data-employee-cedula");
            showEmployeeDetails(cedula);
        }
    });
}

// Inicialización
document.addEventListener("DOMContentLoaded", async () => {
    await fetchVacations();
    await fetchEmployees();
    setupModals();
    setupEventListeners();

    // Establecer fecha mínima para los campos de fecha
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("fecha_inicio").min = today;
    document.getElementById("fecha_solicitud").min = today;
    document.getElementById("fecha_aprobacion").min = today;
});
