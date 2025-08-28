const API_URL_BASE  = 'http://127.0.0.1:5041' // ---> CAMBIAR POR LA DIRECCION IP DE LA MAQUINA QUE ESTE CORRIENDO PYTHON

fetch(`${API_URL_BASE}/pagos/ver/asignaciones`)
  .then(res => res.json())
  .then(data => {   
    const tbody = document.getElementById('registros_metas');
    tbody.innerHTML = '';

    let contador = 1;
    data.forEach(item => {
        const fechaFormateada = new Date(item.fecha_completacion).toLocaleDateString();
      const row = `
        <tr>

          <td>${item.cedula_empleado}</td>
           <td>${item.nombre} ${item.apellido} </td>
          <td>${item.descripcion}</td>
          <td>${fechaFormateada}</td>
          <td>${item.estado}</td>
        </tr>
      `;
      tbody.insertAdjacentHTML('beforeend', row);
    });
  })
  .catch(error => {
    console.error('Error al cargar los datos:', error);
  });

