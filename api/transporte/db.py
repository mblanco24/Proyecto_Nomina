from conexion.adaptadores import conectar
from flask import  request
import  bcrypt



def crear_transporte(cedula, usuario, fecha, hora_entrada, hora_salida, ruta):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""  INSERT INTO asistencia_ruta (cedula, usuario, fecha, hora_entrada, hora_salida, ruta) VALUES (%s, %s, %s, %s, %s, %s)""",
        (cedula, usuario, fecha, hora_entrada, hora_salida, ruta))
    conn.commit()
    conn.close()
    return {'message': 'Transporte creado correctamente'}



def ver_transporte():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("select * from asistencia_ruta")
    columnas = [desc[0] for desc in cursor.description]
    products = cursor.fetchall()
    data = [dict(zip(columnas, product)) for product in products]
    cursor.close()
    conn.close()
    return data