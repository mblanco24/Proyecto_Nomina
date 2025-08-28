from adaptadores import conectar  # Asegúrate de que este archivo se llama db.py o ajusta el import

def probar_conexion():
    conn = conectar()
    if conn:
        print("✅ Conexión exitosa a la base de datos.")
        conn.close()
    else:
        print("❌ No se pudo conectar a la base de datos.")

if __name__ == "__main__":
    probar_conexion()
