from conexion.adaptadores import conectar
from flask import  request
import  bcrypt



def obetener_id_de_user(correo):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""select users.id
                    from users 
                    join empleado on users.id = empleado.id_usuario
                    where users.email = %s
                    """,(correo,))
    auditorias = cursor.fetchall()
    cursor.close()
    conn.close()
    return auditorias


def insertar_registro_entrada(correo,fecha, hora, evento):
    id_user  = obetener_id_de_user(correo)
    print(id_user)
    conn = conectar()
    cursor = conn.cursor()
    if id_user:
        cursor.execute(
            "INSERT INTO reporte_it (fecha, hora, id_usuario, evento) VALUES (%s, %s, %s, %s)",
            (fecha, hora, id_user[0][0], evento)
        )
    else:
        raise ValueError("Usuario no encontrado")    
    conn.commit()
    conn.close()



def ver_registros():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
            select reporte_it.* ,users.email, empleado.cedula
            from reporte_it
            join users on reporte_it.id_usuario  = users.id
            join empleado on users.id = empleado.id_usuario""")
    columnas = [desc[0] for desc in cursor.description]
    empleados = cursor.fetchall()
    empleado = [dict(zip(columnas, empleado)) for empleado in empleados]
    cursor.close()
    conn.close()
    return empleado

