import pandas as pd
import io

def leer_csv(archivo):
    # Si `archivo` es un objeto FileStorage de Flask (viene de request.files)
    archivo_stream = io.StringIO(archivo.read().decode("utf-8"))

    try:
        df = pd.read_csv(archivo_stream, sep=';')  # Usa punto y coma si es el separador
    except pd.errors.ParserError:
        archivo_stream.seek(0)
        df = pd.read_csv(archivo_stream)  # Intenta sin separador si falla

    df = df.dropna(how='all')
    df.columns = ["cedula", "nombre", "departamento", "fecha_hora", "evento"]
    return df.iterrows()


