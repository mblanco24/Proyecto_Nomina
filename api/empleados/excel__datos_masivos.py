import pandas as pd
import numpy as np

def insersion_masiva(nombre):
# Ruta al archivo Excel
    archivo = nombre

    # Nombre de la hoja que quieres leer (por ejemplo, 'Hoja2')
    nombre_hoja = 'DAT'

    # Leer la hoja específica
    df = pd.read_excel(
        archivo,
        sheet_name=nombre_hoja,
        usecols='A:J',   # Columnas desde A hasta J
        skiprows=1,      # Saltar la fila 1 (leer desde A2)
        nrows=484      # Leer 485 filas (de la fila 2 a la 486)
    )
    # Mostrar los datos
    #print(df)

    df = df.dropna(how='all')
    df.columns = ["cedula","nombre_apellido","nomina", "cargo" ,"nivel", "unidad_de_adscripcion","nro_de_cuenta","tipo_de_cuenta" ,"bloqueo_otros", "rutas"]

    df = df.replace({np.nan: ""})

    return df.iterrows()



