from flask import Blueprint, jsonify, request
from .db import insertar_registro_entrada, ver_registros
from datetime import datetime

fecha = datetime.now()
fecha_diaria = fecha.date()
hora_diaria = fecha.time()

auditoria_bp = Blueprint('auditoria_api', __name__, url_prefix='/auditoria')

@auditoria_bp.route('/create/<correo>', methods=['GET'])
def get_all_auditoria1(correo):


    fecha  = str(fecha_diaria)
    hora = str(hora_diaria)
    evento  = "entrada"
    auditoria = insertar_registro_entrada(correo,fecha, hora,evento)
    return jsonify(auditoria)


@auditoria_bp.route('/create/salida/<correo>', methods=['GET'])
def create_log_route(correo):


    fecha  = str(fecha_diaria)
    hora = str(hora_diaria)
    evento  = "salida"
    auditoria = insertar_registro_entrada(correo,fecha, hora,evento)
    return jsonify(auditoria)


@auditoria_bp.route('ver', methods=['GET'])
def ver_registros_route():
    auditoria = ver_registros()
    return jsonify(auditoria)
