from conexion.adaptadores import conectar
from flask import  request
import  bcrypt


def get_all_vacaciones():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
                   Select vacaciones.*, empleado.cedula,empleado.nombre,empleado.apellido
from vacaciones 
join empleado on vacaciones.cedula_empleado = empleado.cedula
                   """)
    columnas = [desc[0] for desc in cursor.description]
    vacaciones = cursor.fetchall()
    vacaciones = [dict(zip(columnas, vacaciones)) for vacaciones in vacaciones]
    cursor.close()
    conn.close()
    return vacaciones

def crear_vacaciones(cedula_empleado, fecha_solicitud, fecha_inicio, fecha_fin, dias, estado, aprobado_por, fecha_aprobacion):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute(
        "INSERT INTO vacaciones (cedula_empleado, fecha_solicitud, fecha_inicio, fecha_fin, dias, estado, aprobado_por, fecha_aprobacion) "
        "VALUES ( %s, %s,%s, %s, %s, %s, %s, %s)",
        ( cedula_empleado, fecha_solicitud, fecha_inicio, fecha_fin, dias, estado, aprobado_por, fecha_aprobacion))
    conn.commit()
    conn.close()
    return {'message': 'vacaciones creado correctamente'}

def actualizar_vacaciones(campo, nuevo_valor, id):
    conn = conectar()
    cursor = conn.cursor()
    if campo.upper() == "PASSWORD":
        nuevo_valor = bcrypt.hashpw(nuevo_valor.encode('utf-8'), bcrypt.gensalt())
    cursor.execute(
        f"UPDATE vacaciones SET {campo} = %s WHERE id = %s",
        (nuevo_valor, id)
    )
    conn.commit()
    conn.close()
    return {'message': 'vacaciones actualizado correctamente'}

def eliminar_vacaciones(id):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("DELETE FROM vacaciones WHERE id = %s", (id,))
    conn.commit()
    conn.close()
    return {'message': 'vacaciones eliminado correctamente'}


def get_vacaciones_by_id(cedula):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM empleado WHERE cedula = %s", (cedula,))
    columnas = [desc[0] for desc in cursor.description]
    vacaciones = cursor.fetchall()
    vacaciones = [dict(zip(columnas, vacaciones)) for vacaciones in vacaciones]
    cursor.close()
    conn.close()
    return vacaciones


