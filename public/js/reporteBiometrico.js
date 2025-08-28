const API_URL_BASE  = 'http://127.0.0.1:5041' // ---> CAMBIAR POR LA DIRECCION IP DE LA MAQUINA QUE ESTE CORRIENDO PYTHON

let biometricoData = []; // Guardar aquí los datos originales



fetch(`${API_URL_BASE}/pagos/biometrico/ver`)
  .then(res => res.json())
  .then(data => {
    biometricoData = data;
    renderTablaBiometrico(data);
  })
  .catch(error => {
    console.error('Error al cargar los datos:', error);
  });

function renderTablaBiometrico(data) {
  const tbody = document.getElementById('tabla-registros');
  tbody.innerHTML = '';

  let contador = 1;
  data.forEach(item => {
    const fecha = new Date(item.fecha);
    const dia = fecha.getUTCDate().toString().padStart(2, '0');
    const mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0');
    const anio = fecha.getUTCFullYear();
    const fechaFormateada = `${dia}/${mes}/${anio}`;

    const row = `
      <tr>
        <td class="ps-3">${contador++}</td>
        <td>${item.nombre_apellido}</td>
        <td>${item.direccion}</td>
        <td>${fechaFormateada}</td>
        <td>${item.hora}</td>
        <td class="text-center">${item.evento}</td>
      </tr>
    `;
    tbody.insertAdjacentHTML('beforeend', row);
  });
}

// Escuchar cambios en los tres filtros
document.getElementById('filtroEvento').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-fecha').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-empleado').addEventListener('input', aplicarFiltros);

function aplicarFiltros() {
  const filtroEvento = document.getElementById('filtroEvento').value;
  const filtroFecha = document.getElementById('filtro-fecha').value;
  const filtroEmpleado = document.getElementById('filtro-empleado').value.trim().toLowerCase();

  const filtrados = biometricoData.filter(item => {
    // Evento
    const cumpleEvento = filtroEvento ? item.evento === filtroEvento : true;

    // Fecha
    const fecha = new Date(item.fecha);
    const dia = fecha.getUTCDate().toString().padStart(2, '0');
    const mes = (fecha.getUTCMonth() + 1).toString().padStart(2, '0');
    const anio = fecha.getUTCFullYear();
    const fechaFormateada = `${anio}-${mes}-${dia}`;
    const cumpleFecha = filtroFecha ? fechaFormateada === filtroFecha : true;

    // Empleado
    const nombre = item.nombre_apellido ? item.nombre_apellido.toLowerCase() : '';
    const cumpleEmpleado = filtroEmpleado ? nombre.includes(filtroEmpleado) : true;

    return cumpleEvento && cumpleFecha && cumpleEmpleado;
  });

  renderTablaBiometrico(filtrados);
}




  



document.getElementById('form-subir-archivo').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch(`${API_URL_BASE}/pagos/biometrico/subir`, {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Error al subir archivo');
    }
    return response.json(); 
  })
  .then(result => {
  Swal.fire({
    icon: 'success',
    title: '¡Archivo subido!',
    text: 'El archivo se ha procesado correctamente.',
    confirmButtonText: 'Aceptar'
  }).then(() => {
    // Cierra el modal y recarga solo después de que el usuario confirme
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalSubirArchivo'));
    modal.hide();
    form.reset();
    window.location.reload();
  });
})
  .catch(error => {
    console.error('Error:', error);
    alert('Hubo un problema al subir el archivo.');
  });
});



