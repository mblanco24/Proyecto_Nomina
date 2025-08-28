from flask import Blueprint, jsonify, request
from .db import get_all_vacaciones,crear_vacaciones , actualizar_vacaciones, eliminar_vacaciones, get_vacaciones_by_id
import bcrypt


vacaciones_bp = Blueprint('vacaciones_api', __name__, url_prefix='/vacaciones')

@vacaciones_bp.route('/', methods=['GET'])
def get_all_vacaciones1():
    vacaciones = get_all_vacaciones()
    return jsonify(vacaciones)


@vacaciones_bp.route('/new', methods=['POST'])
def crear_vacaciones1():
    data = request.json
    cedula_empleado = data['cedula_empleado']
    fecha_solicitud = data['fecha_solicitud']
    fecha_inicio = data['fecha_inicio']
    fecha_fin = data['fecha_fin']
    dias = data['dias']
    estado = data['estado']
    aprobado_por =1
    fecha_aprobacion = data['fecha_aprobacion']
    new_vacaciones = crear_vacaciones(
        cedula_empleado,
        fecha_solicitud,
        fecha_inicio,
        fecha_fin,
        dias,
        estado,
        aprobado_por,
        fecha_aprobacion
    )
    return jsonify({'message': 'vacaciones creado correctamente'}), 201

@vacaciones_bp.route('/update/<id>', methods=['PUT'])
def update_vacaciones(id):
    try:
        data = request.json
        nuevo_valor = data['nuevo_valor']
        campo = data['campo'].upper()
        actualizar_vacaciones(campo, nuevo_valor)
        return {'message': 'vacaciones actualizado correctamente'}, 200
    except Exception as e:
        return {'error': str(e)}, 500

@vacaciones_bp.route('/delete/<id>', methods=['DELETE'])
def delete_vacaciones(id):
    try:
        eliminar_vacaciones(id)
        return {'message': 'vacaciones eliminado correctamente'}, 200
    except Exception as e:
        return {'error': str(e)}, 500


@vacaciones_bp.route('/<cedula>', methods=['GET'])
def get_vacaciones_by_id_route(cedula):
    try:
        vacaciones = get_vacaciones_by_id(cedula)
        if not vacaciones:
            return {'message': 'Empleado no encontrado'}, 404
        return jsonify(vacaciones), 200
    except Exception as e:
        return {'error': str(e)}, 500