import pandas as pd
from datetime import datetime

# Diccionario para traducir los días de la semana
dias_es = {
    'Monday': 'Lunes',
    'Tuesday': 'Martes',
    'Wednesday': 'Miércoles',
    'Thursday': 'Jueves',
    'Friday': 'Viernes',
    'Saturday': 'Sábado',
    'Sunday': 'Domingo'
}

# Leer el archivo CSV y limpiar filas vacías
df = pd.read_csv("prueba.csv", sep=';')
df = df.dropna(how='all')
df.columns = ["cedula", "nombre", "departamento", "fecha_hora", "evento"]

# Procesar cada fila
for index, row in df.iterrows():
    fecha_hora_str = row["fecha_hora"]  # ejemplo: "14/4/2025 5:49"

    dt = datetime.strptime(fecha_hora_str, "%d/%m/%Y %H:%M")

    
    fecha = dt.date()
    hora = dt.time().strftime("%H:%M")  

    dia_semana_en = dt.strftime("%A")
    dia_semana = dias_es[dia_semana_en]

    print("Día:", dia_semana)
    print("Fecha:", fecha)
    print("Hora:", hora)
    print("------")
