from flask import Blueprint, jsonify, request
from .db import get_all_empleado, crear_empleado, actualizar_empleado, eliminar_empleado, get_empleado_by_id, crear_empleado_masivo
import bcrypt
from datetime import datetime
from middleware.jwt_required import token_required
from .excel__datos_masivos import insersion_masiva

fecha = datetime.now()
fecha_diaria = fecha.date()
empleados_bp = Blueprint('empleados_api', __name__, url_prefix='/empleados')

@empleados_bp.route('/', methods=['GET'])
def get_all_empleado1():
    transporte = get_all_empleado()
    return jsonify(transporte)

@empleados_bp.route('/new', methods=['POST'])
def create_new_empleado():
    try:
        data = request.json

        cedula = data['cedula']
        nombre = data['nombre']
        apellido= data['apellido']
        nomina= data['nomina']
        cargo= data['cargo']
        nivel= data['nivel']
        departamento= data['departamento']
        numero_cuenta= data['numero_cuenta']
        activo =False
        tipo_de_cuenta= data['tipo_de_cuenta']
        banco = data['banco']
        salario_base = data['salario_base']
        new_empleado = crear_empleado(
                    cedula,
                    nombre,
                    apellido,
                    nomina,
                    cargo,
                    nivel,
                    departamento,
                    salario_base,
                    numero_cuenta,
                    banco,
                    activo
                    ,tipo_de_cuenta
        )
        if 'error' in new_empleado:
            return jsonify(new_empleado), 400  # Error esperado (como duplicado)

        return jsonify(new_empleado)
    
    except Exception as e:
        return jsonify({"Error":str(e)}),500




@empleados_bp.route('/update/<cedula>', methods=['PUT'])
def update_empleado(cedula):
    try:
        data = request.json

        nombre = data['nombre']
        apellido = data['apellido']
        nomina = data['nomina']
        cargo = data['cargo']
        nivel = data['nivel']
        departamento = data['departamento']
        salario_base = data['salario_base']
        numero_cuenta = data['numero_cuenta']
        banco = data['banco']
        tipo_de_cuenta = data['tipo_de_cuenta']

        actualizar_empleado(
            nombre,
            apellido,
            nomina,
            cargo,
            nivel,
            departamento,
            salario_base,
            numero_cuenta,
            banco,
            tipo_de_cuenta,
            cedula
        )

        return {'message': 'Empleado actualizado correctamente'}, 200
    except Exception as e:
        return {'error': str(e)}, 500







@empleados_bp.route('/delete/<cedula>', methods=['DELETE'])
def delete_empleado(cedula):
    try:
        eliminar_empleado(cedula)
        return {'message': 'Empleado eliminado correctamente'}, 200
    except Exception as e:
        return {'error': str(e)}, 500
    


@empleados_bp.route('/<cedula>', methods=['GET'])
def get_empleado_by_id_route(cedula):
    try:
        empleado = get_empleado_by_id(cedula)
        if not empleado:
            return {'message': 'Empleado no encontrado'}, 404
        return jsonify(empleado), 200
    except Exception as e:
        return {'error': str(e)}, 500   
    






@empleados_bp.route('create/masivo', methods=['POST'])
def create_new_empleado_masivo():
    try:
   


        valor = insersion_masiva("prueba2.xlsm")

        
        for index, row in valor:
            partes   = row['nombre_apellido'].split()
            activo = False
            if len(partes) == 1:
                nombre = partes[0]
                apellido = ''
            elif len(partes) >= 2:
                nombre = ' '.join(partes[:-1])
                apellido = partes[-1]
            new_empleado  = crear_empleado_masivo(
                row['cedula'],
                nombre,
                apellido,
                row['nomina'],
                row['cargo'],
                row['nivel'],
                row['unidad_de_adscripcion'],
                row['nro_de_cuenta'],
                activo,
                row['bloqueo_otros'],
                row['rutas'],
                row['tipo_de_cuenta'],
            )


        if 'error' in new_empleado:
            return jsonify(new_empleado), 400  # Error esperado (como duplicado)

        return jsonify(new_empleado)
    
    except Exception as e:
        return jsonify({"Error":str(e)}),500
