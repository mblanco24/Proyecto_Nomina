
// Función para aplicar filtros
    function aplicarFiltros() {
        const empleado = document.getElementById('filtro-empleado').value.toLowerCase();
        const direccion = document.getElementById('filtro-direccion').value;
        const fecha = document.getElementById('filtro-fecha').value;

        const filas = document.querySelectorAll('#tabla-biometrico tbody tr');

        filas.forEach(fila => {
            const celdaEmpleado = fila.cells[1].textContent.toLowerCase();
            const celdaDireccion = fila.cells[2].textContent;
            const celdaFecha = fila.cells[3].textContent.split(' ')[0];

            const coincideEmpleado = empleado === '' || celdaEmpleado.includes(empleado);
            const coincideDireccion = direccion === '' || celdaDireccion === direccion;
            const coincideFecha = fecha === '' || celdaFecha.includes(fecha.replace(/-/g, '/'));

            if (coincideEmpleado && coincideDireccion && coincideFecha) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }

    // Función para limpiar filtros
    function limpiarFiltros() {
        document.getElementById('filtro-empleado').value = '';
        document.getElementById('filtro-direccion').value = '';
        document.getElementById('filtro-fecha').value = '';
        aplicarFiltros();
    }

    // Función para subir CSV
    function subirCSV() {
        const formData = new FormData(document.getElementById('form-csv'));

        if (!document.getElementById('archivo-csv').files[0]) {
            alert('Por favor seleccione un archivo CSV');
            return;
        }

        // Mostrar carga
        const btnSubir = document.querySelector('#modalCsv .modal-footer button:last-child');
        btnSubir.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        btnSubir.disabled = true;

        // Simulación de envío (reemplazar con AJAX real)
        setTimeout(() => {
            alert('Archivo procesado correctamente (simulación)');
            $('#modalCsv').modal('hide');
            btnSubir.innerHTML = 'Subir';
            btnSubir.disabled = false;

            // Aquí iría la actualización de la tabla con los nuevos datos
        }, 2000);

        /*
        // Implementación real con AJAX:
        fetch('/subir-csv-biometrico', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            $('#modalCsv').modal('hide');
            // Actualizar la tabla con data.registros
        })
        .catch(error => {
            console.error('Error:', error);
        });
        */
    }

// Función para abrir modal de asignación con empleado específico
function asignarMetaModal(empleadoId, empleadoNombre) {
    $('#nuevaMetaModal select[name="empleado_id"]').val(empleadoId);
    $('#nuevaMetaModal').modal('show');
}

// Función para abrir modal de edición de progreso
function editarProgresoModal(asignacionId, metaNombre, progresoActual) {
    $('#asignacion_id').val(asignacionId);
    $('#meta_nombre').val(metaNombre);
    $('#rangoProgreso').val(progresoActual);
    $('#valorProgreso').text(progresoActual + '%');
    $('#editarProgresoModal').modal('show');
}

// Función para actualizar el valor del rango
function actualizarValor(valor) {
    $('#valorProgreso').text(valor + '%');
}

// Manejar envío del formulario de asignación
$('#formAsignarMeta').on('submit', function(e) {
    e.preventDefault();

    // Aquí iría la llamada AJAX para guardar
    console.log('Datos a enviar:', $(this).serialize());

    // Simulación de respuesta exitosa
    alert('Meta asignada correctamente');
    $('#nuevaMetaModal').modal('hide');
    $(this).trigger('reset');
});

// Manejar envío del formulario de progreso
$('#formEditarProgreso').on('submit', function(e) {
    e.preventDefault();

    // Aquí iría la llamada AJAX para actualizar
    console.log('Datos a enviar:', $(this).serialize());

    // Simulación de respuesta exitosa
    alert('Progreso actualizado correctamente');
    $('#editarProgresoModal').modal('hide');
    $(this).trigger('reset');
});

$(document).ready(function() {
    // Inicializar tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
