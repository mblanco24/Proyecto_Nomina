import datetime

# === Datos fijos (HEADER y DEBITO) ===
cedula_empresa = "01234567G"
fecha_fija = "200001011"  # puedes generar fecha dinámica si deseas

# HEADER
header = f"HEADER  {cedula_empresa}{fecha_fija}"

# DEBITO
institucion = "INSTITUTO NACIONAL DE HIGIENE RAFAE".ljust(43)
fecha_debito = datetime.datetime.now().strftime("%d/%m/%Y")  # Ej: 15/07/2025
codigo_debito = "000102013229"
monto_debito = "0000000000000000"  # lo llenamos más abajo
moneda = "VEB"  
banco_id = "40"

# === Datos de ejemplo (entrada JSON) ===
pagos = [
    {
        "apellido": "MARIANELA",
        "cedula_empleado": "12112258",
        "fecha_pago": "Mon, 14 Jul 2025 00:00:00 GMT",
        "id_pago": "1",
        "metodo_pago": None,
        "monto": "150.00",
        "nombre": "PADRINO",
        "numero_cuenta": "11111111111111111111"
    },
    {
        "apellido": "IDELMAR",
        "cedula_empleado": "14955826",
        "fecha_pago": "Mon, 14 Jul 2025 00:00:00 GMT",
        "id_pago": "2",
        "metodo_pago": None,
        "monto": "350.00",
        "nombre": "PINTO",
        "numero_cuenta": "11111111111111111111"
    }
]

# === Generar líneas de CREDITO ===
lineas_credito = []
monto_total = 0.0

for idx, pago in enumerate(pagos, start=1):
    id_pago = f"{int(pago['id_pago']):08d}"       # Ej: 00000001
    cedula = f"V{pago['cedula_empleado']}"         # Ej: V12112258
    nombre = f"{pago['nombre']} {pago['apellido']}".upper().ljust(40)[:40]
    codigo = f"{idx:03d}"                          # Ej: 001
    cuenta = pago['numero_cuenta']
    
    monto_float = float(pago['monto'])
    monto_total += monto_float
    monto_formateado = f"{monto_float:017.2f}".replace('.', ',')  # Ej: 00000000000150,00
    
    tipo_pago = "10"  # fijo o puedes variarlo
    banco = "BSCHVECA"
    email = f"{pago['nombre'].lower()}@gmail.com".ljust(50)

    linea_credito = (
        f"CREDITO {id_pago}{cedula}{nombre}"
        f"{codigo}{cuenta}{monto_formateado}{tipo_pago}{banco:<10}{email}"
    )
    lineas_credito.append(linea_credito)

# === Formato de monto total para DEBITO y TOTAL ===
monto_total_str = f"{monto_total:017.2f}".replace('.', ',')  # Ej: 00000000000150,00

# DEBITO final
debito = f"DEBITO  {cedula_empresa}{fecha_fija}{institucion}{fecha_debito}{codigo_debito}{monto_total_str}{moneda}{banco_id}"

# TOTAL
total_linea = f"TOTAL   {len(pagos):08d}0002{monto_total_str}"

# === Escribir archivo ===
with open("pago_empleados.txt", "w", encoding="utf-8") as f:
    f.write(header + "\n")
    f.write(debito + "\n")
    for linea in lineas_credito:
        f.write(linea + "\n")
    f.write(total_linea + "\n")

print("Archivo generado: pago_empleados.txt")
