from conexion.adaptadores import conectar
from flask import  request
import  bcrypt


def get_all_constancia():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM constancia")
    columnas = [desc[0] for desc in cursor.description]
    constancia = cursor.fetchall()
    constancia = [dict(zip(columnas, constancia)) for constancia in constancia]
    cursor.close()
    conn.close()
    return constancia

def crear_constancia(tipo_constancia,cedula_empleado, fecha_generacion):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute(
        "INSERT INTO constancia (tipo_constancia, cedula_empleado, fecha_generacion) "
        "VALUES (%s, %s, %s)",
        ( tipo_constancia,cedula_empleado, fecha_generacion))
    conn.commit()
    conn.close()
    return {'message': 'constancia creado correctamente'}




def actualizar_constancia(campo, nuevo_valor, id):
    conn = conectar()
    cursor = conn.cursor()
    if campo.upper() == "PASSWORD":
        nuevo_valor = bcrypt.hashpw(nuevo_valor.encode('utf-8'), bcrypt.gensalt())
    cursor.execute(
        f"UPDATE constancia SET {campo} = %s WHERE id = %s",
        (nuevo_valor, id)
    )
    conn.commit()
    conn.close()
    return {'message': 'constancia actualizado correctamente'}

def eliminar_constancia(id):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("DELETE FROM constancia WHERE id = %s", (id,))
    conn.commit()
    conn.close()
    return {'message': 'constancia eliminado correctamente'}



def correlativos():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""select id_constancia from constancia
ORDER BY id_constancia DESC
LIMIT 1;""")
    columnas = [desc[0] for desc in cursor.description]
    constancia = cursor.fetchall()
    data = [dict(zip(columnas, constancia)) for constancia in constancia]
    cursor.close()
    conn.close()
    return data