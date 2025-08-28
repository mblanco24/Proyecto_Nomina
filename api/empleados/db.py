from conexion.adaptadores import conectar
from flask import  request
import  bcrypt
import psycopg2

def get_all_empleado():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM empleado")
    columnas = [desc[0] for desc in cursor.description]
    empleados = cursor.fetchall()
    empleado = [dict(zip(columnas, empleado)) for empleado in empleados]
    cursor.close()
    conn.close()
    return empleado






def crear_empleado(cedula,nombre,apellido,nomina,cargo,nivel,departamento,salario_base,numero_cuenta,banco,activo,tipo_de_cuenta):
    conn = conectar()
    cursor = conn.cursor()
    email = f"{nombre}.{apellido}@gmail.com"
    try:
        # Hashear la cédula como contraseña
        hashed_password = bcrypt.hashpw(cedula.encode('utf-8'), bcrypt.gensalt()).decode('utf-8')

        hashed_laravel = hashed_password.replace("$2b$", "$2y$")
        
        # Intentar insertar en usuario
        cursor.execute(
            "INSERT INTO users (name,email,password) VALUES (%s, %s, %s) RETURNING id",
            (nombre, email, hashed_laravel)

        )
        id_usuario = cursor.fetchone()[0]
        print(id_usuario)
        # Insertar en empleado
        cursor.execute(
            "INSERT INTO empleado (cedula,nombre,apellido,nomina,cargo,nivel,departamento,salario_base,numero_cuenta,banco,activo,id_usuario,tipo_de_cuenta) "
            "VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s)",
            (cedula,nombre,apellido,nomina,cargo,nivel,departamento,salario_base,numero_cuenta,banco,activo,id_usuario,tipo_de_cuenta)  # Desempaquetar los args
        )

        conn.commit()
        return {'message': 'Empleado creado correctamente'}

    except psycopg2.IntegrityError as e:
        conn.rollback()
        # Verifica si es una violación de clave única
        if 'usuario_cedula_key' in str(e) or 'unique_cedula' in str(e):
            return {'error': 'Ya existe un usuario con esa cédula'}
        elif 'usuario_email_key' in str(e) or 'unique_email' in str(e):
            return {'error': 'Ya existe un usuario con ese correo electrónico'}
        elif 'empleado_cedula_key' in str(e) or 'unique_cedula_empleado' in str(e):
            return {'error': 'Ya existe un empleado con esa cédula'}
        else:
            return {'error': 'Error de integridad: ' + str(e)}

    except Exception as ex:
        conn.rollback()
        return {'error': f'Ocurrió un error: {str(ex)}'}

    finally:
        conn.close()






def actualizar_empleado(nombre, apellido, nomina, cargo, nivel, departamento, salario_base, numero_cuenta, banco, tipo_de_cuenta, cedula):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
        UPDATE empleado 
        SET nombre = %s,
            apellido = %s,
            nomina = %s,
            cargo = %s,
            nivel = %s,
            departamento = %s,
            salario_base = %s,
            numero_cuenta = %s,
            banco = %s,
            tipo_de_cuenta = %s
        WHERE cedula = %s
    """, (
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
    ))
    conn.commit()
    conn.close()
    return {'message': 'Empleado actualizado correctamente'}






def eliminar_empleado(cedula):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("DELETE FROM empleado WHERE cedula = %s", (cedula,))
    conn.commit()
    conn.close()
    return {'message': 'Empleado eliminado correctamente'}




def get_empleado_by_id(cedula):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
                select empleado.* , users.email
                from empleado
                JOIN users ON empleado.id_usuario = users.id
                WHERE empleado.cedula  = %s
                """, (cedula,))
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    empleado = [dict(zip(columnas, empleado)) for empleado in empleado]
    cursor.close()
    conn.close()
    return empleado


def crear_empleado_masivo(cedula,nombre,apellido,nomina,cargo,nivel,departamento,numero_cuenta,activo,bloqueo_pagos,rutas,tipo_de_cuenta):
    conn = conectar()
    cursor = conn.cursor()
    cedula = str(cedula)  # Asegúrate de que sea string

    email = f"{nombre}.{apellido}@gmail.com"
    
    try:
        # Hashear la cédula como contraseña
        hashed_password = bcrypt.hashpw(cedula.encode('utf-8'), bcrypt.gensalt()).decode('utf-8')
        hashed_laravel = hashed_password.replace("$2b$", "$2y$")
        
        # Insertar en tabla users
        cursor.execute(
            "INSERT INTO users (name, email, password) VALUES (%s, %s, %s) RETURNING id",
            (nombre, email, hashed_laravel)
        )
        id_usuario = cursor.fetchone()[0]

        # Insertar en tabla empleado
        cursor.execute(
            "INSERT INTO empleado (cedula,nombre,apellido,nomina,cargo,nivel,departamento,numero_cuenta,activo,id_usuario,bloqueo_pagos,rutas,tipo_de_cuenta) "
            "VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s)",
            (cedula,nombre,apellido,nomina,cargo,nivel,departamento,numero_cuenta,activo,id_usuario,bloqueo_pagos,rutas,tipo_de_cuenta)  # Desempaquetar los args
        )

        conn.commit()
        return {'message': 'Empleado creado correctamente'}

    except psycopg2.IntegrityError as e:
        conn.rollback()
        if 'usuario_cedula_key' in str(e) or 'unique_cedula' in str(e):
            return {'error': 'Ya existe un usuario con esa cédula'}
        elif 'usuario_email_key' in str(e) or 'unique_email' in str(e):
            return {'error': 'Ya existe un usuario con ese correo electrónico'}
        elif 'empleado_cedula_key' in str(e) or 'unique_cedula_empleado' in str(e):
            return {'error': 'Ya existe un empleado con esa cédula'}
        else:
            return {'error': 'Error de integridad: ' + str(e)}

    except Exception as ex:
        conn.rollback()
        return {'error': f'Ocurrió un error: {str(ex)}'}

    finally:
        conn.close()
