from flask import Blueprint, jsonify, request,send_file
import os

from .cvs_reporte_biometrico import leer_csv
from .db import registro_de_datos, data_for_txt,reporte_de_metas,update_meta_asiggnada,ver_asignaciones_for_cedula_para_validar,ver_registros_mas_descripcion_de_meta,ver_registros, ver_metas,empleados_ , asignaciones_de_metas, ver_asignaciones,eliminar_meta_for_id, limpiar_registros_biometricos

from datetime import datetime
from collections import defaultdict
from .dias import dias_es
import json
import csv
import io
from pathlib import Path

fecha = datetime.now()
fecha_diaria = fecha.date()
metas_pagos_bp = Blueprint('metas_pagoss_api', __name__, url_prefix='/pagos')

@metas_pagos_bp.route('biometrico/subir', methods=['POST'])
def registro_datos_routes():
    try:
        if 'archivo' not in request.files:
            return jsonify({"Error": "No se envió ningún archivo"}), 400

        archivo = request.files['archivo']

        if archivo.filename == '':
            return jsonify({"Error": "Archivo sin nombre"}), 400

        # Usamos tu función personalizada para leer el CSV
        valor = leer_csv(archivo)
        
        for index, row in valor:
            fecha_hora_str  = row['fecha_hora']
        
            dt = datetime.strptime(fecha_hora_str, "%d/%m/%Y %H:%M")
            
            fecha = dt.date()
            hora = dt.time().strftime("%H:%M")  
            dia_semana_en = dt.strftime("%A")
            dia_semana = dias_es[dia_semana_en]
            evento = "ENTRADA" if "ENTRADA" in row['evento'].upper() else "SALIDA"

            registro_de_datos(
                row['cedula'],
                row['nombre'],
                row['departamento'],
                fecha,
                hora,
                evento,
                dia_semana
            )

        return jsonify({"Respuesta": "Correcto"})
    except Exception as e:
        return jsonify({"Error": str(e)}), 500

    


@metas_pagos_bp.route('biometrico/ver', methods=['GET'])
def ver_registro_datos_routes():
    try:
        registros  = ver_registros()
        return jsonify(registros)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    



@metas_pagos_bp.route('realcionbiometa/ver', methods=['GET'])
def realcionbiometa_routes():
    try:
        registros  = ver_registros_mas_descripcion_de_meta()
        return jsonify(registros)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    






@metas_pagos_bp.route('/ver/metas', methods=['GET'])
def ver_metas_routes():
    try:
        registros  = ver_metas()
        return jsonify(registros)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    




@metas_pagos_bp.route('/ver/empleados', methods=['GET'])
def ver_empleados_routes():
    try:
        registros  = empleados_()
        return jsonify(registros)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    



@metas_pagos_bp.route('/asignacion_de_metas', methods=['POST'])
def asignacion_de_metas():
    try:
        data = request.json
        cedula_empleado = data['cedula_empleado']
        fecha_asignacion = str(fecha_diaria)
        fecha_completacion= data['fecha_completacion']
        try:
            dt = datetime.strptime(fecha_completacion, "%Y-%m-%d")
            print(dt)
            dia_semana = dt.strftime("%A")
            dia_semana = dias_es[dia_semana]
            print(dia_semana)
        except Exception as a:
            print(a)
        estado = "pendiente"
        dias_ejecucion= 0
        id_meta= data['id_meta']
        feriado = data['feriado']
        asignaciones_de_metas(cedula_empleado,
                            fecha_asignacion,
                            fecha_completacion,
                            estado,
                            dias_ejecucion,
                            id_meta ,
                            dia_semana, feriado)
        return jsonify({"Respuesta":"Asignacion correcta"})
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    





@metas_pagos_bp.route('/ver/asignaciones', methods=['GET'])
def ver_asignacioness_routes():
    try:
        registros  = ver_asignaciones()

        
        return jsonify(registros)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    


@metas_pagos_bp.route('asignaciones', methods=['GET'])
def ver_asignacioness_routes2():
    try:

        agrupado = defaultdict(lambda: {"cedula": "", "nombre": "", "metas": []})
        registros  = ver_asignaciones()
        for item in registros:
            key = f"{item['nombre']} {item['apellido']}"
            if not agrupado[key]["cedula"]:
                agrupado[key]["cedula"] = item["cedula_empleado"]
                agrupado[key]["nombre"] = key

            asignacion = {
                "id_asignacion": item["id_asignacion"],
                "descripcion": item["descripcion"],
                "estado": item["estado"],
                "dias_ejecucion": item["dias_ejecucion"],
                "fecha_asignacion": item["fecha_asignacion"],
                "fecha_completacion": item["fecha_completacion"],
                "dia_asignado":item['dia_asignado'],
                "feriado":item['feriado'],
                "total_feriados":item['total_feriados'],
                "total_pagos":item['total_pagados'],
                "total_pendientes":item['total_pendientes']
            }
            agrupado[key]["metas"].append(asignacion)

        resultado = list(agrupado.values())


        return jsonify(resultado)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    
    



@metas_pagos_bp.route('/delete/asignaciones/<id>', methods=['DELETE'])
def delete_asiganaciones_route(id):
    try:
        eliminar_meta_for_id(id)
        return jsonify({"registros":"Eliminado Correctamente"})
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    


@metas_pagos_bp.route('/delete/registros/', methods=['DELETE'])
def delete_registros_route():
    try:
        limpiar_registros_biometricos()
        return jsonify({"registros":"Eliminado Correctamente"})
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    




@metas_pagos_bp.route('/asignaciones/<cedula>', methods=['GET'])
def ver_asignacioness_routes_for_cedula(cedula):
    try:
        agrupado = defaultdict(lambda: {"cedula": "", "nombre": "", "metas": []})
        registros  = ver_asignaciones_for_cedula_para_validar(cedula)
        for item in registros:
            key = f"{item['nombre']} {item['apellido']}"
            if not agrupado[key]["cedula"]:
                agrupado[key]["cedula"] = item["cedula_empleado"]
                agrupado[key]["nombre"] = key

            asignacion = {
                "id_asignacion": item["id_asignacion"],
                "descripcion": item["descripcion"],
                "estado": item["estado"],
                "dias_ejecucion": item["dias_ejecucion"],
                "fecha_asignacion": item["fecha_asignacion"],
                "fecha_completacion": item["fecha_completacion"],
                "dia_asignado":item['dia_asignado'],
                "feriado":item['feriado'],
                "total_feriados":item['total_feriados'],
                "total_pagos":item['total_pagados'],
                "total_pendientes":item['total_pendientes']
            }
            agrupado[key]["metas"].append(asignacion)

        resultado = list(agrupado.values())

        
        return jsonify(resultado)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    




@metas_pagos_bp.route('update/meta/<id_asigacion>', methods=['PUT'])
def ver_validaciones_routes(id_asigacion):
    try:
        data = request.json
        fecha =  data['fecha_pago']
        monto = data['monto']
        registros  = update_meta_asiggnada(id_asigacion, fecha, monto)

        
        return jsonify(registros)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    




@metas_pagos_bp.route('/ver/reportes', methods=['GET'])
def vreporte_de_metas_routes():
    try:
        registros  = reporte_de_metas()

        
        return jsonify(registros)
    except Exception as e:
        return jsonify({"Error":str(e)}) ,500
    
base_dir  = Path().resolve()   
DIRECTORIO_ARCHIVOS = os.path.join(base_dir, "archivos")
 # Convertir a ruta absoluta

# Crear la carpeta si no existe
os.makedirs(DIRECTORIO_ARCHIVOS, exist_ok=True)

# Ruta del archivo


ARCHIVO_NOMBRE = os.path.join(DIRECTORIO_ARCHIVOS, f"datos.txt")
    


@metas_pagos_bp.route('txt', methods=['GET'])
def data_for_txt_routes():
    try:
        registros  = data_for_txt()

        cedula_empresa = "01234567G"
        fecha_fija = "200001011"  # puedes generar fecha dinámica si deseas

        # HEADER
        header = f"HEADER  {cedula_empresa}{fecha_fija}"

        # DEBITO
        institucion = "INSTITUTO NACIONAL DE HIGIENE RAFAE".ljust(43)
        fecha_debito = datetime.now().strftime("%d/%m/%Y")  # Ej: 15/07/2025
        codigo_debito = "000102013229"
        monto_debito = "0000000000000000"  # lo llenamos más abajo
        moneda = "VEB"  
        banco_id = "40"
        lineas_credito = []
        monto_total = 0.0

        for idx, pago in enumerate(registros, start=1):
            id_pago = f"{int(pago['id_pago']):08d}"       # Ej: 00000001
            cedula = f"V{pago['cedula_empleado']}"         # Ej: V12112258
            nombre = f"{pago['nombre']} {pago['apellido']}".upper().ljust(40)[:40]
            codigo = f"{idx:03d}"                          # Ej: 001
            cuenta = pago['numero_cuenta']
            
            monto_float = float(pago['monto'])
            monto_total += monto_float
            monto_formateado = f"{monto_float:017.2f}".replace('.', ',')  # Ej: 00000000000150,00
            
            tipo_pago = "10"  # fijo o puedes variarlo
            banco = "BSCHVECA"
            email = f"{pago['nombre'].lower()}@gmail.com".ljust(50)

            linea_credito = (
                f"CREDITO {id_pago}{cedula}{nombre}"
                f"{codigo}{cuenta}{monto_formateado}{tipo_pago}{banco:<10}{email}"
            )
            lineas_credito.append(linea_credito)

        monto_total_str = f"{monto_total:017.2f}".replace('.', ',')  # Ej: 00000000000150,00


        debito = f"DEBITO  {cedula_empresa}{fecha_fija}{institucion}{fecha_debito}{codigo_debito}{monto_total_str}{moneda}{banco_id}"

        # TOTAL
        total_linea = f"TOTAL   {len(registros):08d}0002{monto_total_str}"

        # === Escribir archivo ===
        if not registros:
            return jsonify({"Error": "No hay pagos pendientes"}), 404

        with open(ARCHIVO_NOMBRE, "w", encoding="utf-8") as f:
            f.write(header + "\n")
            f.write(debito + "\n")
            for linea in lineas_credito:
                f.write(linea + "\n")
            f.write(total_linea + "\n")

        # Retornar archivo para descarga
        return send_file(
            ARCHIVO_NOMBRE,
            mimetype='text/plain',
            as_attachment=True,
            download_name=ARCHIVO_NOMBRE
        )
    except IndexError:
        # Capturar especificamente error de índice
        return jsonify({"Error": "No hay pagos pendientes"}), 404
    except Exception as e:
        return jsonify({"Error": str(e)}), 500

        