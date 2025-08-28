from conexion.adaptadores import conectar
from flask import request
import bcrypt

def get_all_usuario():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
select users.id,users.email,users.super_user , empleado.cedula,empleado.nombre,empleado.apellido,empleado.departamento,empleado.cargo, rol.nombre_rol
from users
JOIN empleado ON users.id = id_usuario 
LEFT JOIN rol on users.id_rol  = rol.id_rol

""")
    columnas = [desc[0] for desc in cursor.description]
    products = cursor.fetchall()
    data = [dict(zip(columnas, product)) for product in products]
    cursor.close()
    conn.close()
    return data




def actualizar_user(nuevo_valor, id):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute(f"UPDATE users SET super_user = %s WHERE id = %s", (nuevo_valor, id))
    conn.commit()
    cursor.close()
    conn.close()


def eliminar_usuario(id):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("DELETE FROM usuario WHERE id_usuario = %s", (id,))
    conn.commit()
    cursor.close()
    conn.close()



def get_roles():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""SELECT * FROM ROL""")
    columnas = [desc[0] for desc in cursor.description]
    products = cursor.fetchall()
    data = [dict(zip(columnas, product)) for product in products]
    cursor.close()
    conn.close()
    return data

def update_roles(nuevo_valor, id):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute(f"UPDATE users SET id_rol = %s WHERE id = %s", (nuevo_valor, id))
    conn.commit()
    cursor.close()
    conn.close()



def datos_de_user(id_users):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
                    select * 
                    from users
                    join empleado on users.id = empleado.id_usuario
                    where users.id = %s""",(id_users,))
    columnas = [desc[0] for desc in cursor.description]
    products = cursor.fetchall()
    data = [dict(zip(columnas, product)) for product in products]
    cursor.close()
    conn.close()
    return data



def cambiar_contraseña(id_usuario, nueva_contraseña):
    conn = conectar()
    cursor = conn.cursor()
        # Hashear la contraseña y adaptar a formato Laravel
    hashed_password = bcrypt.hashpw(nueva_contraseña.encode('utf-8'), bcrypt.gensalt()).decode('utf-8')
    hashed_laravel = hashed_password.replace("$2b$", "$2y$")
    cursor.execute(f"UPDATE users SET password = %s WHERE id = %s", (hashed_laravel, id_usuario))
    conn.commit()
    cursor.close()
    conn.close()
    
    
def id_usuario_por_email(email):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("SELECT id FROM users WHERE email = %s", (email,))
    result = cursor.fetchone()
    cursor.close()
    conn.close()
    return result[0] if result else None