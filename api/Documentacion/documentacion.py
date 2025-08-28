from flask import Blueprint, jsonify, request
from .db import get_all_constancia , crear_constancia, actualizar_constancia, eliminar_constancia, correlativos
import bcrypt


constancia_bp = Blueprint('constancia_api', __name__, url_prefix='/constancias')

@constancia_bp.route('/', methods=['GET'])
def get_all_constancia1():
    constancia = get_all_constancia()
    return jsonify(constancia)


@constancia_bp.route('/new', methods=['POST'])
def crear_new_constancia():
    try:
        data = request.json
        tipo_constancia = data['tipo_constancia']
        cedula_empleado = data['cedula_empleado']
        fecha_generacion =  data['fecha_generacion']
        new_constancia = crear_constancia(tipo_constancia,cedula_empleado,fecha_generacion)
        return jsonify({'message': 'constancia creado correctamente'}), 201
    except Exception as e:
        return jsonify({'error': str(e)}), 500




@constancia_bp.route('/update/<id>', methods=['PUT'])
def update_constancia(id):
    try:
        data = request.json
        nuevo_valor = data['nuevo_valor']
        campo = data['campo'].upper()
        actualizar_constancia(campo, nuevo_valor)
        return {'message': 'constancia actualizado correctamente'}, 200
    except Exception as e:
        return {'error': str(e)}, 500

@constancia_bp.route('/delete/<id>', methods=['DELETE'])
def delete_constancia(id):
    try:
        eliminar_constancia(id)
        return {'message': 'constancia eliminado correctamente'}, 200
    except Exception as e:
        return {'error': str(e)}, 500
    


@constancia_bp.route('correlativo', methods=['GET'])
def correlativo_route():
    constancia = correlativos()
    return jsonify(constancia)