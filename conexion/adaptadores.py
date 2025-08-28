import psycopg2


def conectar():
    """
    Establece una conexión a la base de datos PostgreSQL.
    
    Returns:
        conn: Objeto de conexión a la base de datos.
    """
    try:
        conn = psycopg2.connect(
            host="127.0.0.1",
            database="nomina",
            user="postgres",
            password="q",
            port="5432"
        )
        return conn
    except Exception as e:
        print(f"Error al conectar a la base de datos: {e}")
        return None