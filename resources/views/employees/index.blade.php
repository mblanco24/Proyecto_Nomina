@extends('layouts.app')

@section('content')
<style>
    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;

    }

    .scrollable-table {
        max-height: 600px; /* o la altura que prefieras */
        overflow-y: auto;
    }

    .scrollable-table table {
        margin-bottom: 0; /* evita separación si hay scroll */
    }
</style>
<h1 class="mb-4">Listado de Empleados</h1>

<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span>Empleados registrados</span>
        <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#empleadoDetalleModal"
            id="btnNuevoEmpleado">
            <i class="fas fa-plus"></i> Nuevo Empleado
        </button>
    </div>
    <div class="card-body">

        <div class="scrollable-table">
            <div class="d-flex justify-content-end mb-2">
                <input type="text" id="filtroCedula" placeholder="Filtrar por cédula" class="form-control form-control-sm" style="max-width: 200px;">
            </div>


            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cedula</th>
                        <th>Nombre Completo</th>
                        <th>Cargo</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>

                </thead>
                <tbody id="cuerpoTablaEmpleados">
                </tbody>
            </table>
        </div>

        <div class="alert alert-info" role="alert">
            No hay empleados registrados aún.
        </div>

    </div>
</div>

<div class="modal fade" id="empleadoDetalleModal" tabindex="-1" aria-labelledby="empleadoDetalleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><!-- modal-lg para mayor ancho -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="empleadoDetalleModalLabel">Registrar Nuevo Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formNuevoEmpleado" action="#" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <label for="cedula" class="col-sm-3 col-form-label">Cédula</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="cedula" name="cedula"
                                    pattern="[0-9]{1,15}" maxlength="15"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                <small class="text-muted">Solo números, máximo 15 dígitos</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) ||
                                                      (event.charCode >= 97 && event.charCode <= 122) ||
                                                      event.charCode == 32" required>
                                <small class="text-muted">No se permiten números</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="apellido" class="col-sm-3 col-form-label">Apellido</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="apellido" name="apellido"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) ||
                                                      (event.charCode >= 97 && event.charCode <= 122) ||
                                                      event.charCode == 32" required>
                                <small class="text-muted">No se permiten números</small>
                            </div>
                        </div>
                        <!-- Repite este patrón para cada input -->

<div class="row mb-3">
    <label for="nomina" class="col-sm-3 col-form-label">Nómina</label>
    <div class="col-sm-9">
        <select class="form-select" id="nomina" name="nomina" required>
            <option value="">Seleccione un tipo de nómina...</option>
            <option value="CONTRATADOS">CONTRATADOS</option>
            <option value="EMPLEADOS">EMPLEADOS</option>
            <option value="HONORARIOS PROFESIONALES">HONORARIOS PROFESIONALES</option>
            <option value="OBREROS">OBREROS</option>
            <option value="ALTO NIVEL">ALTO NIVEL</option>
        </select>
    </div>
</div>


<div class="row mb-3">
    <label for="departamento" class="col-sm-3 col-form-label">Departamento</label>
    <div class="col-sm-9">
        <select class="form-select" id="departamento" name="departamento" required>
            <option value="">Seleccione un departamento...</option>
            <option value="AUDITORIA INTERNA">AUDITORIA INTERNA</option>
            <option value="GERENCIA DE DOCENCIA E INVESTIGACION">GERENCIA DE DOCENCIA E INVESTIGACION</option>
            <option value="GERENCIA DE INFORMATICA">GERENCIA DE INFORMATICA</option>
            <option value="GERENCIA DE PLANIFICACION Y PRESUPUESTO">GERENCIA DE PLANIFICACION Y PRESUPUESTO</option>
            <option value="GERENCIA DE RECURSOS HUMANOS">GERENCIA DE RECURSOS HUMANOS</option>
            <option value="GERENCIA GESTION DE LA CALIDAD">GERENCIA GESTION DE LA CALIDAD</option>
            <option value="GERENCIA SECTORIAL DE ADMINISTRACION">GERENCIA SECTORIAL DE ADMINISTRACION</option>
            <option value="GERENCIA SECTORIAL DE DIAGNOSTICO/EPIDEMIOLOGIA">GERENCIA SECTORIAL DE DIAGNOSTICO/EPIDEMIOLOGIA</option>
            <option value="GERENCIA SECTORIAL DE PRODUCCION">GERENCIA SECTORIAL DE PRODUCCION</option>
            <option value="GERENCIA SECTORIAL DE REGISTRO Y CONTROL">GERENCIA SECTORIAL DE REGISTRO Y CONTROL</option>
            <option value="JUNTA REVISORA">JUNTA REVISORA</option>
            <option value="OFICINA DE CONSULTORIA JURIDICA">OFICINA DE CONSULTORIA JURIDICA</option>
            <option value="PRESIDENCIA">PRESIDENCIA</option>
        </select>
    </div>
</div>


<div class="row mb-3">
    <label for="cargo" class="col-sm-3 col-form-label">Cargo</label>
    <div class="col-sm-9">
        <select class="form-select" id="cargo" name="cargo" required>
            <option value="">Seleccione un cargo...</option>
            <option value="ALBANIL">ALBANIL</option>
            <option value="ASEADOR">ASEADOR</option>
            <option value="ASISTENTE DE LABORATORIO I">ASISTENTE DE LABORATORIO I</option>
            <option value="ASISTENTE DE LABORATORIO II">ASISTENTE DE LABORATORIO II</option>
            <option value="ASISTENTE DE LABORATORIO III">ASISTENTE DE LABORATORIO III</option>
            <option value="ASISTENTE DE OFICINA I">ASISTENTE DE OFICINA I</option>
            <option value="ASISTENTE DE OFICINA II">ASISTENTE DE OFICINA II</option>
            <option value="ASISTENTE DE OFICINA III">ASISTENTE DE OFICINA III</option>
            <option value="AUDITOR INTERNO">AUDITOR INTERNO</option>
            <option value="AUXILIAR DE LABORATORIO">AUXILIAR DE LABORATORIO</option>
            <option value="AUXILIAR DE SERVICIOS DE OFICINA">AUXILIAR DE SERVICIOS DE OFICINA</option>
            <option value="AUXILIAR DE TERAPIA">AUXILIAR DE TERAPIA</option>
            <option value="AUXILIAR DE VETERINARIO">AUXILIAR DE VETERINARIO</option>
            <option value="AYUDANTE DE ALMACEN">AYUDANTE DE ALMACEN</option>
            <option value="AYUDANTE DE MECANICO">AYUDANTE DE MECANICO</option>
            <option value="AYUDANTE DE SERVICIOS DE COCINA">AYUDANTE DE SERVICIOS DE COCINA</option>
            <option value="AYUDANTE DE SERVICIOS GENERALES">AYUDANTE DE SERVICIOS GENERALES</option>
            <option value="CHOFER">CHOFER</option>
            <option value="CHOFER DE TRANSPORTE">CHOFER DE TRANSPORTE</option>
            <option value="COCINERA">COCINERA</option>
            <option value="CONSULTOR JURIDICO">CONSULTOR JURIDICO</option>
            <option value="CONTRATADO (GRADO 1)">CONTRATADO (GRADO 1)</option>
            <option value="CONTRATADO (GRADO 2)">CONTRATADO (GRADO 2)</option>
            <option value="CONTRATADO (GRADO 3)">CONTRATADO (GRADO 3)</option>
            <option value="CONTRATADO (GRADO 5)">CONTRATADO (GRADO 5)</option>
            <option value="CONTRATADO (GRADO 6)">CONTRATADO (GRADO 6)</option>
            <option value="CONTRATADO BI">CONTRATADO BI</option>
            <option value="CONTRATADO BIII">CONTRATADO BIII</option>
            <option value="CONTRATADO MEDICO">CONTRATADO MEDICO</option>
            <option value="CONTRATADO MEDICO I">CONTRATADO MEDICO I</option>
            <option value="CONTRATADO MEDICO JEFE II">CONTRATADO MEDICO JEFE II</option>
            <option value="CONTRATADO MEDICO JEFE IV">CONTRATADO MEDICO JEFE IV</option>
            <option value="CONTRATADO MEDICO SALUD PUBLICA JEFE III">CONTRATADO MEDICO SALUD PUBLICA JEFE III</option>
            <option value="CONTRATADO OBRERO (GRADO 4)">CONTRATADO OBRERO (GRADO 4)</option>
            <option value="CONTRATADO PI">CONTRATADO PI</option>
            <option value="CONTRATADO PIII">CONTRATADO PIII</option>
            <option value="CONTRATADO TI">CONTRATADO TI</option>
            <option value="CONTRATADO TII">CONTRATADO TII</option>
            <option value="COORDINADOR DE MANTENIMIENTO">COORDINADOR DE MANTENIMIENTO</option>
            <option value="DIRECTOR DE CAMPUS VIRTUAL">DIRECTOR DE CAMPUS VIRTUAL</option>
            <option value="DIRECTOR DE DESPACHO">DIRECTOR DE DESPACHO</option>
            <option value="DIRECTOR DE LINEA ( E ) TECNOLOGIA E INFORMATICA">DIRECTOR DE LINEA ( E ) TECNOLOGIA E INFORMATICA</option>
            <option value="DIRECTOR DE SEGURIDAD Y TRANSPORTE">DIRECTOR DE SEGURIDAD Y TRANSPORTE</option>
            <option value="DIRECTOR DE TALENTO HUMANO">DIRECTOR DE TALENTO HUMANO</option>
            <option value="DIRECTOR(A) DE DOCENCIA">DIRECTOR(A) DE DOCENCIA</option>
            <option value="DIRECTORA DE LINEA DE CULTIVO CELULAR">DIRECTORA DE LINEA DE CULTIVO CELULAR</option>
            <option value="GERENTE SECTORIAL DE REGISTRO Y CONTROL">GERENTE SECTORIAL DE REGISTRO Y CONTROL</option>
            <option value="GESTOR DE SALUD PUBLICA I">GESTOR DE SALUD PUBLICA I</option>
            <option value="GESTOR DE SALUD PUBLICA II">GESTOR DE SALUD PUBLICA II</option>
            <option value="HERRERO">HERRERO</option>
            <option value="HONORARIOS PROFESIONALES">HONORARIOS PROFESIONALES</option>
            <option value="JARDINERO">JARDINERO</option>
            <option value="JEFE DE DEPARTAMENTO DE REDES Y SERVIDORES">JEFE DE DEPARTAMENTO DE REDES Y SERVIDORES</option>
            <option value="JEFE DE SECCION DE TALLER MECANICO">JEFE DE SECCION DE TALLER MECANICO</option>
            <option value="MECANICO AUTOMOTRIZ">MECANICO AUTOMOTRIZ</option>
            <option value="MEDICO ESPECIALISTA I">MEDICO ESPECIALISTA I</option>
            <option value="MEDICO II">MEDICO II</option>
            <option value="MEDICO JEFE II">MEDICO JEFE II</option>
            <option value="MEDICO JEFE III">MEDICO JEFE III</option>
            <option value="MEDICO JEFE IV">MEDICO JEFE IV</option>
            <option value="MENSAJERO">MENSAJERO</option>
            <option value="MENSAJERO MOTORIZADO">MENSAJERO MOTORIZADO</option>
            <option value="PINTOR">PINTOR</option>
            <option value="PRESIDENTE">PRESIDENTE</option>
            <option value="PROFESIONAL DE ADMINISTRACION I">PROFESIONAL DE ADMINISTRACION I</option>
            <option value="PROFESIONAL DE ADMINISTRACION II">PROFESIONAL DE ADMINISTRACION II</option>
            <option value="PROFESIONAL DE ADMINISTRACION III">PROFESIONAL DE ADMINISTRACION III</option>
            <option value="PROFESIONAL DE AUDITORIA II">PROFESIONAL DE AUDITORIA II</option>
            <option value="PROFESIONAL DE AUDITORIA III">PROFESIONAL DE AUDITORIA III</option>
            <option value="PROFESIONAL DE BIBLIOTECA III">PROFESIONAL DE BIBLIOTECA III</option>
            <option value="PROFESIONAL DE BIOANALISIS I">PROFESIONAL DE BIOANALISIS I</option>
            <option value="PROFESIONAL DE BIOANALISIS II">PROFESIONAL DE BIOANALISIS II</option>
            <option value="PROFESIONAL DE BIOANALISIS III">PROFESIONAL DE BIOANALISIS III</option>
            <option value="PROFESIONAL DE BIOLOGIA I">PROFESIONAL DE BIOLOGIA I</option>
            <option value="PROFESIONAL DE COMUNICACION Y RELACIONES PUBLICAS II">PROFESIONAL DE COMUNICACION Y RELACIONES PUBLICAS II</option>
            <option value="PROFESIONAL DE DERECHO I">PROFESIONAL DE DERECHO I</option>
            <option value="PROFESIONAL DE FARMACIA I">PROFESIONAL DE FARMACIA I</option>
            <option value="PROFESIONAL DE FARMACIA II">PROFESIONAL DE FARMACIA II</option>
            <option value="PROFESIONAL DE FARMACIA III">PROFESIONAL DE FARMACIA III</option>
            <option value="PROFESIONAL DE INGENIERIA I">PROFESIONAL DE INGENIERIA I</option>
            <option value="PROFESIONAL DE INGENIERIA II">PROFESIONAL DE INGENIERIA II</option>
            <option value="PROFESIONAL DE INGENIERIA III">PROFESIONAL DE INGENIERIA III</option>
            <option value="PROFESIONAL DE INVESTIGACION VETERINARIA III">PROFESIONAL DE INVESTIGACION VETERINARIA III</option>
            <option value="PROFESIONAL DE MICROBIOLOGIA II">PROFESIONAL DE MICROBIOLOGIA II</option>
            <option value="PROFESIONAL DE MICROBIOLOGIA III">PROFESIONAL DE MICROBIOLOGIA III</option>
            <option value="PROFESIONAL DE ORGANIZACION Y SISTEMAS III">PROFESIONAL DE ORGANIZACION Y SISTEMAS III</option>
            <option value="PROFESIONAL DE PLANIFICACION I">PROFESIONAL DE PLANIFICACION I</option>
            <option value="PROFESIONAL DE PLANIFICACION II">PROFESIONAL DE PLANIFICACION II</option>
            <option value="PROFESIONAL DE PRESUPUESTO III">PROFESIONAL DE PRESUPUESTO III</option>
            <option value="PROFESIONAL DE QUIMICA I">PROFESIONAL DE QUIMICA I</option>
            <option value="PROFESIONAL DE QUIMICA II">PROFESIONAL DE QUIMICA II</option>
            <option value="PROFESIONAL DE QUIMICA III">PROFESIONAL DE QUIMICA III</option>
            <option value="PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE I">PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE I</option>
            <option value="PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE II">PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE II</option>
            <option value="PROFESIONAL DE TALENTO HUMANO I">PROFESIONAL DE TALENTO HUMANO I</option>
            <option value="PROFESIONAL DE TALENTO HUMANO II">PROFESIONAL DE TALENTO HUMANO II</option>
            <option value="PROFESIONAL DE TALENTO HUMANO III">PROFESIONAL DE TALENTO HUMANO III</option>
            <option value="PROFESIONAL DE TELEMATICA I">PROFESIONAL DE TELEMATICA I</option>
            <option value="PROFESIONAL DE TELEMATICA III">PROFESIONAL DE TELEMATICA III</option>
            <option value="PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA I">PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA I</option>
            <option value="PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA II">PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA II</option>
            <option value="SUPERVISOR DE SEGURIDAD">SUPERVISOR DE SEGURIDAD</option>
            <option value="SUPERVISOR DE SERVICIOS INTERNOS">SUPERVISOR DE SERVICIOS INTERNOS</option>
            <option value="SUPERVISOR DE TRANSPORTE">SUPERVISOR DE TRANSPORTE</option>
            <option value="TECNICO DE ADMINISTRACION I">TECNICO DE ADMINISTRACION I</option>
            <option value="TECNICO DE ADMINISTRACION II">TECNICO DE ADMINISTRACION II</option>
            <option value="TECNICO DE GESTION DE SALUD PUBLICA II">TECNICO DE GESTION DE SALUD PUBLICA II</option>
            <option value="TECNICO DE QUIMICA II">TECNICO DE QUIMICA II</option>
            <option value="TECNICO DE SERVICIOS GENERALES I">TECNICO DE SERVICIOS GENERALES I</option>
            <option value="TECNICO DE SERVICIOS GENERALES II">TECNICO DE SERVICIOS GENERALES II</option>
            <option value="TECNICO DE TALENTO HUMANO II">TECNICO DE TALENTO HUMANO II</option>
            <option value="TÉCNICO DE TELEMÁTICA II">TÉCNICO DE TELEMÁTICA II</option>
            <option value="TECNICO DE VIGILANCIA EPIDEMIOLOGICA I">TECNICO DE VIGILANCIA EPIDEMIOLOGICA I</option>
            <option value="TECNICO GESTION DE SALUD PUBLICA I">TECNICO GESTION DE SALUD PUBLICA I</option>
            <option value="TECNICO GESTION DE SALUD PUBLICA II">TECNICO GESTION DE SALUD PUBLICA II</option>
            <option value="VIGILANTE">VIGILANTE</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <label for="nivel" class="col-sm-3 col-form-label">Nivel</label>
    <div class="col-sm-9">
        <select class="form-select" id="nivel" name="nivel" required>
            <option value="">Seleccione un nivel...</option>
            <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
            <option value="HONORARIOS PROFESIONALES">HONORARIOS PROFESIONALES</option>
            <option value="OBREROS">OBREROS</option>
            <option value="PROFESIONAL">PROFESIONAL</option>
            <option value="SUPERVISORIO">SUPERVISORIO</option>
            <option value="TECNICO">TECNICO</option>
        </select>
    </div>
</div>




<div class="row mb-3">
    <label for="salario_base" class="col-sm-3 col-form-label">Salario Base</label>
    <div class="col-sm-9">
        <input type="number"
               class="form-control no-spinners"
               id="salario_base"
               name="salario_base"
               min="0"
               oninput="this.value=this.value.replace(/[^0-9]/g,'');"
               required>
    </div>
</div>

<style>
    /* Elimina las flechitas en todos los navegadores */
    .no-spinners::-webkit-outer-spin-button,
    .no-spinners::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .no-spinners {
        -moz-appearance: textfield;
    }
</style>

                        <div class="row mb-3">
                            <label for="fecha_ingreso" class="col-sm-3 col-form-label">Número de Cuenta</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta"
                            pattern="[0-9]{1,20}" maxlength="20"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        <small class="text-muted">Solo números, máximo 20 dígitos</small>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fecha_ingreso" class="col-sm-3 col-form-label">Tipo de Cuenta</label>
                            <div class="col-sm-9">
                        <select class="form-select" id="tipo_cuenta" name="tipo_cuenta" required>
                            <option value="">Seleccione...</option>
                            <option value="C">Corriente</option>
                            <option value="A">Ahorros</option>
                        </select>

                            </div>
                        </div>


                     <div class="row mb-3">
                            <label for="fecha_ingreso" class="col-sm-3 col-form-label">Banco</label>
                            <div class="col-sm-9">
                        <select class="form-select" id="edit_banco" name="banco" required>
                                <option value="Banco de Venezuela">Banco de Venezuela</option>
                                <option value="Banesco">Banesco</option>
                                <option value="BBVA Provincial">BBVA Provincial</option>
                                <option value="Mercantil">Mercantil</option>
                                <option value="BNC">BNC</option>
                                <option value="Bancaribe">Bancaribe</option>
                                <option value="Exterior">Exterior</option>
                                <option value="Del Tesoro">Del Tesoro</option>
                                <option value="Bicentenario">Bicentenario</option>
                                <option value="BOD">BOD</option>
                                <option value="Caroní">Caroní</option>
                                <option value="100% Banco">100% Banco</option>
                                <option value="Del Sur">Del Sur</option>
                                <option value="Plaza">Plaza</option>
                                <option value="Sofitasa">Sofitasa</option>
                                <option value="Activo">Activo</option>
                                <option value="Bancamiga">Bancamiga</option>
                                <option value="Banplus">Banplus</option>
                                <option value="Fondo Común">Fondo Común</option>
                                <option value="Agrícola">Agrícola</option>
                                <option value="Bancrecer">Bancrecer</option>
                                <option value="Mi Banco">Mi Banco</option>
                                <option value="N58">N58</option>
                                <option value="Venezolano de Crédito">Venezolano de Crédito</option>
                                <option value="Bangente">Bangente</option>
                                <option value="BID">BID</option>
                                <option value="Banfanb">Banfanb</option>
                        </select>

                            </div>
                        </div>





                        <!-- Continúa con el resto de inputs usando el mismo patrón -->

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="guardarempleado" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para detalles del empleado -->
<div class="modal fade" id="employeeDetailsModal" tabindex="-1" aria-labelledby="employeeDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="employeeDetailsModalLabel">Detalles del Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> <span id="modalEmployeeName"></span></p>
                        <p><strong>Cédula:</strong> <span id="modalEmployeeCedula"></span></p>
                        <p><strong>Cargo:</strong> <span id="modalEmployeePosition"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Apellido:</strong> <span id="modalEmployeeape"></span></p>
                        <p><strong>Departamento:</strong> <span id="modalEmployeeDepartment"></span></p>
                        <p><strong>Banco:</strong> <span id="modalEmployeeBanco"></span></p>
                        <p><strong>Numero de Cuenta:</strong> <span id="nc"></span></p>
                    </div>
                </div>

                <!-- Puedes agregar más secciones según necesites -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para edición del empleado -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editEmployeeModalLabel">Editar Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditEmployee">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="edit_cedula" name="cedula">

                    <div class="row">

                        <div class="mb-3">
                            <label for="edit_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="edit_apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_puesto" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="edit_puesto" name="puesto" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_nomina" class="form-label">Nomina</label>
                        <select class="form-select" id="edit_nomina" name="nomina" required>
            <option value="">Seleccione un tipo de nómina...</option>
            <option value="CONTRATADOS">CONTRATADOS</option>
            <option value="EMPLEADOS">EMPLEADOS</option>
            <option value="HONORARIOS PROFESIONALES">HONORARIOS PROFESIONALES</option>
            <option value="OBREROS">OBREROS</option>
            <option value="ALTO NIVEL">ALTO NIVEL</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_departamento" class="form-label">Departamento</label>
                        <select class="form-select" id="edit_departamento" name="departamento" required>
                            <option value="Tecnología">Tecnología</option>
                            <option value="Recursos Humanos">Recursos Humanos</option>
                            <option value="Contabilidad">Contabilidad</option>
                            <option value="Ventas">Ventas</option>
                        </select>
                    </div>

                                        <div class="mb-3">
                        <label for="edit_cargo" class="form-label">Cargo</label>
                        <select class="form-select" id="edit_cargo" name="cargo" required>
            <option value="">Seleccione un cargo...</option>
            <option value="ALBANIL">ALBANIL</option>
            <option value="ASEADOR">ASEADOR</option>
            <option value="ASISTENTE DE LABORATORIO I">ASISTENTE DE LABORATORIO I</option>
            <option value="ASISTENTE DE LABORATORIO II">ASISTENTE DE LABORATORIO II</option>
            <option value="ASISTENTE DE LABORATORIO III">ASISTENTE DE LABORATORIO III</option>
            <option value="ASISTENTE DE OFICINA I">ASISTENTE DE OFICINA I</option>
            <option value="ASISTENTE DE OFICINA II">ASISTENTE DE OFICINA II</option>
            <option value="ASISTENTE DE OFICINA III">ASISTENTE DE OFICINA III</option>
            <option value="AUDITOR INTERNO">AUDITOR INTERNO</option>
            <option value="AUXILIAR DE LABORATORIO">AUXILIAR DE LABORATORIO</option>
            <option value="AUXILIAR DE SERVICIOS DE OFICINA">AUXILIAR DE SERVICIOS DE OFICINA</option>
            <option value="AUXILIAR DE TERAPIA">AUXILIAR DE TERAPIA</option>
            <option value="AUXILIAR DE VETERINARIO">AUXILIAR DE VETERINARIO</option>
            <option value="AYUDANTE DE ALMACEN">AYUDANTE DE ALMACEN</option>
            <option value="AYUDANTE DE MECANICO">AYUDANTE DE MECANICO</option>
            <option value="AYUDANTE DE SERVICIOS DE COCINA">AYUDANTE DE SERVICIOS DE COCINA</option>
            <option value="AYUDANTE DE SERVICIOS GENERALES">AYUDANTE DE SERVICIOS GENERALES</option>
            <option value="CHOFER">CHOFER</option>
            <option value="CHOFER DE TRANSPORTE">CHOFER DE TRANSPORTE</option>
            <option value="COCINERA">COCINERA</option>
            <option value="CONSULTOR JURIDICO">CONSULTOR JURIDICO</option>
            <option value="CONTRATADO (GRADO 1)">CONTRATADO (GRADO 1)</option>
            <option value="CONTRATADO (GRADO 2)">CONTRATADO (GRADO 2)</option>
            <option value="CONTRATADO (GRADO 3)">CONTRATADO (GRADO 3)</option>
            <option value="CONTRATADO (GRADO 5)">CONTRATADO (GRADO 5)</option>
            <option value="CONTRATADO (GRADO 6)">CONTRATADO (GRADO 6)</option>
            <option value="CONTRATADO BI">CONTRATADO BI</option>
            <option value="CONTRATADO BIII">CONTRATADO BIII</option>
            <option value="CONTRATADO MEDICO">CONTRATADO MEDICO</option>
            <option value="CONTRATADO MEDICO I">CONTRATADO MEDICO I</option>
            <option value="CONTRATADO MEDICO JEFE II">CONTRATADO MEDICO JEFE II</option>
            <option value="CONTRATADO MEDICO JEFE IV">CONTRATADO MEDICO JEFE IV</option>
            <option value="CONTRATADO MEDICO SALUD PUBLICA JEFE III">CONTRATADO MEDICO SALUD PUBLICA JEFE III</option>
            <option value="CONTRATADO OBRERO (GRADO 4)">CONTRATADO OBRERO (GRADO 4)</option>
            <option value="CONTRATADO PI">CONTRATADO PI</option>
            <option value="CONTRATADO PIII">CONTRATADO PIII</option>
            <option value="CONTRATADO TI">CONTRATADO TI</option>
            <option value="CONTRATADO TII">CONTRATADO TII</option>
            <option value="COORDINADOR DE MANTENIMIENTO">COORDINADOR DE MANTENIMIENTO</option>
            <option value="DIRECTOR DE CAMPUS VIRTUAL">DIRECTOR DE CAMPUS VIRTUAL</option>
            <option value="DIRECTOR DE DESPACHO">DIRECTOR DE DESPACHO</option>
            <option value="DIRECTOR DE LINEA ( E ) TECNOLOGIA E INFORMATICA">DIRECTOR DE LINEA ( E ) TECNOLOGIA E INFORMATICA</option>
            <option value="DIRECTOR DE SEGURIDAD Y TRANSPORTE">DIRECTOR DE SEGURIDAD Y TRANSPORTE</option>
            <option value="DIRECTOR DE TALENTO HUMANO">DIRECTOR DE TALENTO HUMANO</option>
            <option value="DIRECTOR(A) DE DOCENCIA">DIRECTOR(A) DE DOCENCIA</option>
            <option value="DIRECTORA DE LINEA DE CULTIVO CELULAR">DIRECTORA DE LINEA DE CULTIVO CELULAR</option>
            <option value="GERENTE SECTORIAL DE REGISTRO Y CONTROL">GERENTE SECTORIAL DE REGISTRO Y CONTROL</option>
            <option value="GESTOR DE SALUD PUBLICA I">GESTOR DE SALUD PUBLICA I</option>
            <option value="GESTOR DE SALUD PUBLICA II">GESTOR DE SALUD PUBLICA II</option>
            <option value="HERRERO">HERRERO</option>
            <option value="HONORARIOS PROFESIONALES">HONORARIOS PROFESIONALES</option>
            <option value="JARDINERO">JARDINERO</option>
            <option value="JEFE DE DEPARTAMENTO DE REDES Y SERVIDORES">JEFE DE DEPARTAMENTO DE REDES Y SERVIDORES</option>
            <option value="JEFE DE SECCION DE TALLER MECANICO">JEFE DE SECCION DE TALLER MECANICO</option>
            <option value="MECANICO AUTOMOTRIZ">MECANICO AUTOMOTRIZ</option>
            <option value="MEDICO ESPECIALISTA I">MEDICO ESPECIALISTA I</option>
            <option value="MEDICO II">MEDICO II</option>
            <option value="MEDICO JEFE II">MEDICO JEFE II</option>
            <option value="MEDICO JEFE III">MEDICO JEFE III</option>
            <option value="MEDICO JEFE IV">MEDICO JEFE IV</option>
            <option value="MENSAJERO">MENSAJERO</option>
            <option value="MENSAJERO MOTORIZADO">MENSAJERO MOTORIZADO</option>
            <option value="PINTOR">PINTOR</option>
            <option value="PRESIDENTE">PRESIDENTE</option>
            <option value="PROFESIONAL DE ADMINISTRACION I">PROFESIONAL DE ADMINISTRACION I</option>
            <option value="PROFESIONAL DE ADMINISTRACION II">PROFESIONAL DE ADMINISTRACION II</option>
            <option value="PROFESIONAL DE ADMINISTRACION III">PROFESIONAL DE ADMINISTRACION III</option>
            <option value="PROFESIONAL DE AUDITORIA II">PROFESIONAL DE AUDITORIA II</option>
            <option value="PROFESIONAL DE AUDITORIA III">PROFESIONAL DE AUDITORIA III</option>
            <option value="PROFESIONAL DE BIBLIOTECA III">PROFESIONAL DE BIBLIOTECA III</option>
            <option value="PROFESIONAL DE BIOANALISIS I">PROFESIONAL DE BIOANALISIS I</option>
            <option value="PROFESIONAL DE BIOANALISIS II">PROFESIONAL DE BIOANALISIS II</option>
            <option value="PROFESIONAL DE BIOANALISIS III">PROFESIONAL DE BIOANALISIS III</option>
            <option value="PROFESIONAL DE BIOLOGIA I">PROFESIONAL DE BIOLOGIA I</option>
            <option value="PROFESIONAL DE COMUNICACION Y RELACIONES PUBLICAS II">PROFESIONAL DE COMUNICACION Y RELACIONES PUBLICAS II</option>
            <option value="PROFESIONAL DE DERECHO I">PROFESIONAL DE DERECHO I</option>
            <option value="PROFESIONAL DE FARMACIA I">PROFESIONAL DE FARMACIA I</option>
            <option value="PROFESIONAL DE FARMACIA II">PROFESIONAL DE FARMACIA II</option>
            <option value="PROFESIONAL DE FARMACIA III">PROFESIONAL DE FARMACIA III</option>
            <option value="PROFESIONAL DE INGENIERIA I">PROFESIONAL DE INGENIERIA I</option>
            <option value="PROFESIONAL DE INGENIERIA II">PROFESIONAL DE INGENIERIA II</option>
            <option value="PROFESIONAL DE INGENIERIA III">PROFESIONAL DE INGENIERIA III</option>
            <option value="PROFESIONAL DE INVESTIGACION VETERINARIA III">PROFESIONAL DE INVESTIGACION VETERINARIA III</option>
            <option value="PROFESIONAL DE MICROBIOLOGIA II">PROFESIONAL DE MICROBIOLOGIA II</option>
            <option value="PROFESIONAL DE MICROBIOLOGIA III">PROFESIONAL DE MICROBIOLOGIA III</option>
            <option value="PROFESIONAL DE ORGANIZACION Y SISTEMAS III">PROFESIONAL DE ORGANIZACION Y SISTEMAS III</option>
            <option value="PROFESIONAL DE PLANIFICACION I">PROFESIONAL DE PLANIFICACION I</option>
            <option value="PROFESIONAL DE PLANIFICACION II">PROFESIONAL DE PLANIFICACION II</option>
            <option value="PROFESIONAL DE PRESUPUESTO III">PROFESIONAL DE PRESUPUESTO III</option>
            <option value="PROFESIONAL DE QUIMICA I">PROFESIONAL DE QUIMICA I</option>
            <option value="PROFESIONAL DE QUIMICA II">PROFESIONAL DE QUIMICA II</option>
            <option value="PROFESIONAL DE QUIMICA III">PROFESIONAL DE QUIMICA III</option>
            <option value="PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE I">PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE I</option>
            <option value="PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE II">PROFESIONAL DE SEGURIDAD, HIGIENE Y AMBIENTE II</option>
            <option value="PROFESIONAL DE TALENTO HUMANO I">PROFESIONAL DE TALENTO HUMANO I</option>
            <option value="PROFESIONAL DE TALENTO HUMANO II">PROFESIONAL DE TALENTO HUMANO II</option>
            <option value="PROFESIONAL DE TALENTO HUMANO III">PROFESIONAL DE TALENTO HUMANO III</option>
            <option value="PROFESIONAL DE TELEMATICA I">PROFESIONAL DE TELEMATICA I</option>
            <option value="PROFESIONAL DE TELEMATICA III">PROFESIONAL DE TELEMATICA III</option>
            <option value="PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA I">PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA I</option>
            <option value="PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA II">PROFESIONAL DE VIGILANCIA EPIDEMIOLOGICA II</option>
            <option value="SUPERVISOR DE SEGURIDAD">SUPERVISOR DE SEGURIDAD</option>
            <option value="SUPERVISOR DE SERVICIOS INTERNOS">SUPERVISOR DE SERVICIOS INTERNOS</option>
            <option value="SUPERVISOR DE TRANSPORTE">SUPERVISOR DE TRANSPORTE</option>
            <option value="TECNICO DE ADMINISTRACION I">TECNICO DE ADMINISTRACION I</option>
            <option value="TECNICO DE ADMINISTRACION II">TECNICO DE ADMINISTRACION II</option>
            <option value="TECNICO DE GESTION DE SALUD PUBLICA II">TECNICO DE GESTION DE SALUD PUBLICA II</option>
            <option value="TECNICO DE QUIMICA II">TECNICO DE QUIMICA II</option>
            <option value="TECNICO DE SERVICIOS GENERALES I">TECNICO DE SERVICIOS GENERALES I</option>
            <option value="TECNICO DE SERVICIOS GENERALES II">TECNICO DE SERVICIOS GENERALES II</option>
            <option value="TECNICO DE TALENTO HUMANO II">TECNICO DE TALENTO HUMANO II</option>
            <option value="TÉCNICO DE TELEMÁTICA II">TÉCNICO DE TELEMÁTICA II</option>
            <option value="TECNICO DE VIGILANCIA EPIDEMIOLOGICA I">TECNICO DE VIGILANCIA EPIDEMIOLOGICA I</option>
            <option value="TECNICO GESTION DE SALUD PUBLICA I">TECNICO GESTION DE SALUD PUBLICA I</option>
            <option value="TECNICO GESTION DE SALUD PUBLICA II">TECNICO GESTION DE SALUD PUBLICA II</option>
            <option value="VIGILANTE">VIGILANTE</option>
                        </select>
                    </div>

                                    <div class="mb-3">
                        <label for="edit_nivel" class="form-label">Nivel</label>
                        <select class="form-select" id="edit_nivel" name="nivel" required>
            <option value="">Seleccione un nivel...</option>
            <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
            <option value="HONORARIOS PROFESIONALES">HONORARIOS PROFESIONALES</option>
            <option value="OBREROS">OBREROS</option>
            <option value="PROFESIONAL">PROFESIONAL</option>
            <option value="SUPERVISORIO">SUPERVISORIO</option>
            <option value="TECNICO">TECNICO</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="edit_salario_base" class="form-label">Salario Base</label>
                        <input type="number" class="form-control" id="edit_salario_base" name="salario_base" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_departamento" class="form-label">Tipo de cuenta</label>
                        <select class="form-select" id="edit_tipocuenta" name="departamento" required>
                            <option value="Corriente">Corriente</option>
                            <option value="Ahorros">Ahorro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nc" class="form-label">Numero de cuenta</label>
                        <input type="text" class="form-control" id="edit_nc" name="nc" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_banco" class="form-label">Banco</label>
                        <select class="form-select" id="edit_banco" name="banco" required>
                            <option value="Banco de Venezuela">Banco de Venezuela</option>
                            <option value="Banesco">Banesco</option>
                            <option value="BBVA Provincial">BBVA Provincial</option>
                            <option value="Banco Mercantil">Banco Mercantil</option>
                            <option value="Banco Nacional de Crédito">Banco Nacional de Crédito</option>
                            <option value="Bancaribe">Bancaribe</option>
                            <option value="Banco Exterior">Banco Exterior</option>
                            <option value="Banco del Tesoro">Banco del Tesoro</option>
                            <option value="Banco Bicentenario">Banco Bicentenario</option>
                            <option value="Banco Occidental de Descuento">Banco Occidental de Descuento</option>
                            <option value="Banco Caroní">Banco Caroní</option>
                            <option value="100% Banco">100% Banco</option>
                            <option value="Del Sur">Del Sur</option>
                            <option value="Banco Plaza">Banco Plaza</option>
                            <option value="Banco Sofitasa">Banco Sofitasa</option>
                            <option value="Banco Activo">Banco Activo</option>
                            <option value="Bancamiga">Bancamiga</option>
                            <option value="Banplus">Banplus</option>
                            <option value="Banco Fondo Común">Banco Fondo Común</option>
                            <option value="Banco Agrícola de Venezuela">Banco Agrícola de Venezuela</option>
                            <option value="Bancrecer">Bancrecer</option>
                            <option value="Mi Banco">Mi Banco</option>
                            <option value="N58 Banco Digital">N58 Banco Digital</option>
                            <option value="Banco Venezolano de Crédito">Banco Venezolano de Crédito</option>
                            <option value="Bangente">Bangente</option>
                            <option value="Banco Internacional de Desarrollo">Banco Internacional de Desarrollo</option>
                            <option value="Banco de la Fuerza Armada Nacional Bolivariana (Banfanb)">Banco de la Fuerza Armada Nacional Bolivariana (Banfanb)</option>
                        </select>
                    </div>

                </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
    </div>
    </form>
</div>
</div>
</div>


<script src="{{ asset('js/empleados.js') }}"></script>
@endsection
