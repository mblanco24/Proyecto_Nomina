from conexion.adaptadores import conectar

def user_auth(cedula):
    db = conectar()
    cursor = db.cursor()
    cursor.execute("SELECT cedula, contrasena_hash from Usuario where cedula = %s" , (cedula,) )
    columns = [column[0] for column in cursor.description]
    rows = cursor.fetchall()
    data = [dict(zip(columns, row)) for row in rows]
    
    return rows
    
    
 