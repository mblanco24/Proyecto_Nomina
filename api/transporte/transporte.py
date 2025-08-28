from flask import Blueprint, jsonify, request
from .db import crear_transporte , ver_transporte
from middleware.jwt_required import token_required
from datetime import time

transportes_bp = Blueprint('transportes_api', __name__, url_prefix='/transportes')

@transportes_bp.route('/', methods=['GET'])
def get_all_transporte1():
    transporte = ver_transporte()  # suponiendo que devuelve lista de dicts o modelos
    transporte_serializado = []
    
    for item in transporte:
        transporte_serializado.append({
            'cedula': item['cedula'],
            'usuario': item['usuario'],
            'fecha': item['fecha'],  # si es datetime.date, convierte también con .isoformat()
            'hora_entrada': item['hora_entrada'].strftime('%H:%M:%S') if isinstance(item['hora_entrada'], time) else item['hora_entrada'],
            'hora_salida': item['hora_salida'].strftime('%H:%M:%S') if isinstance(item['hora_salida'], time) else item['hora_salida'],
            'ruta': item['ruta']
        })

    return jsonify(transporte_serializado)



@transportes_bp.route('/new', methods=['POST'])
def crear_transporte1():
    data = request.json
    cedula = data['cedula']
    usuario = data['usuario']
    fecha = data['fecha']
    hora_entrada = data['hora_entrada']
    hora_salida = data['hora_salida']
    ruta = data['ruta']
    new_transporte = crear_transporte(
       cedula, usuario, fecha, hora_entrada, hora_salida, ruta
    )
    return jsonify({'message': 'transporte creado correctamente'}), 201
