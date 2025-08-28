from conexion.adaptadores import conectar
from flask import  request
import  bcrypt


def registro_de_datos(*args):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("INSERT INTO register_biometrico (cedula,nombre_apellido,direccion,fecha,hora,evento, dia) VALUES (%s, %s, %s, %s,%s,%s,%s)",args)
    conn.commit()
    conn.close()
    
  
def ver_registros():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""select register_biometrico.*, empleado.rutas
from register_biometrico
JOIN empleado ON empleado.cedula  = register_biometrico.cedula
""")
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    cursor.close()
    conn.close()
    return data



def ver_metas():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("select * from meta")
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    cursor.close()
    conn.close()
    return data



def empleados_():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("select cedula,nombre,apellido from empleado")
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    cursor.close()
    conn.close()
    return data


def asignaciones_de_metas(*args):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("INSERT INTO asignacion_meta (cedula_empleado,fecha_asignacion,fecha_completacion,estado,dias_ejecucion,id_meta, dia_asignado, feriado) VALUES "
    "(%s, %s, %s, %s,%s,%s,%s,%s)",args)
    conn.commit()
    conn.close()
    


def ver_asignaciones():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""

           SELECT 
    asignacion_meta.*,
    meta.descripcion,
    empleado.nombre,
    empleado.apellido,

    -- Conteo de días pendientes del empleado
    (
        SELECT COUNT(*) 
        FROM asignacion_meta am2 
        WHERE am2.cedula_empleado = asignacion_meta.cedula_empleado 
          AND am2.estado = 'pendiente'
    ) AS total_pendientes,

    -- Conteo de días pagados del empleado
    (
        SELECT COUNT(*) 
        FROM asignacion_meta am3 
        WHERE am3.cedula_empleado = asignacion_meta.cedula_empleado 
          AND am3.estado = 'pagado'
    ) AS total_pagados,

    -- Conteo de días feriados del empleado
    (
        SELECT COUNT(*) 
        FROM asignacion_meta am4 
        WHERE am4.cedula_empleado = asignacion_meta.cedula_empleado 
          AND am4.feriado = TRUE
    ) AS total_feriados

FROM asignacion_meta
JOIN meta ON meta.id_meta = asignacion_meta.id_meta
JOIN empleado ON asignacion_meta.cedula_empleado = empleado.cedula;

            
""")
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    cursor.close()
    conn.close()
    return data








def eliminar_meta_for_id(id_meta):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("delete from asignacion_meta where id_asignacion = %s",(id_meta,))
    conn.commit()
    conn.close()


def limpiar_registros_biometricos():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("delete from register_biometrico")
    conn.commit()
    conn.close()





  
def ver_registros_mas_descripcion_de_meta():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
            select register_biometrico.*,meta.descripcion
            from register_biometrico
            JOIN empleado on empleado.cedula  =register_biometrico.cedula
            JOIN asignacion_meta ON asignacion_meta.cedula_empleado = register_biometrico.cedula 
            JOIN meta ON asignacion_meta.id_meta = meta.id_meta
            """)
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    cursor.close()
    conn.close()
    return data




def ver_asignaciones_for_cedula_para_validar(cedula):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""

           SELECT 
    asignacion_meta.*,
    meta.descripcion,
    empleado.nombre,
    empleado.apellido,

    -- Conteo de días pendientes del empleado
    (
        SELECT COUNT(*) 
        FROM asignacion_meta am2 
        WHERE am2.cedula_empleado = asignacion_meta.cedula_empleado 
          AND am2.estado = 'pendiente'
    ) AS total_pendientes,

    -- Conteo de días pagados del empleado
    (
        SELECT COUNT(*) 
        FROM asignacion_meta am3 
        WHERE am3.cedula_empleado = asignacion_meta.cedula_empleado 
          AND am3.estado = 'pagado'
    ) AS total_pagados,

    -- Conteo de días feriados del empleado
    (
        SELECT COUNT(*) 
        FROM asignacion_meta am4 
        WHERE am4.cedula_empleado = asignacion_meta.cedula_empleado 
          AND am4.feriado = TRUE
    ) AS total_feriados

FROM asignacion_meta
JOIN meta ON meta.id_meta = asignacion_meta.id_meta
JOIN empleado ON asignacion_meta.cedula_empleado = empleado.cedula
where asignacion_meta.cedula_empleado = %s

            
""",(cedula,))
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    cursor.close()
    conn.close()
    return data






def update_meta_asiggnada(id_asignacion,fecha_pago, monto):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("update asignacion_meta set estado = 'procesado' , monto = %s where id_asignacion = %s RETURNING cedula_empleado", (monto,id_asignacion))
    cedula_empleado = cursor.fetchone()[0]
    print(cedula_empleado)
    cursor.execute("insert into pago (cedula_empleado,fecha_pago,monto, estatus) values(%s,%s,%s ,%s)",(cedula_empleado,fecha_pago, monto,'pendiente'))
    conn.commit()
    conn.close()




def reporte_de_metas():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
        SELECT
            e.cedula AS "CÉDULA",
            CONCAT(e.nombre, ' ', e.apellido) AS "NOMBRE Y APELLIDO",
            e.nivel || '/' || e.cargo AS "NIVEL/CARGO",
            e.departamento AS "DIRECCIÓN",
            am.monto,
            COUNT(CASE WHEN am.estado = 'procesado' THEN 1 END) AS "DIAS PENDIENTES",
            COUNT(CASE 
                WHEN am.estado = 'procesado' AND am.dia_asignado IN ('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes') AND am.feriado = false 
                THEN 1 END) AS "TOTAL DÍA PEND. L-V",
            COUNT(CASE 
                WHEN am.estado = 'procesado' AND (am.dia_asignado IN ('Sábado', 'Domingo') OR am.feriado = true)
                THEN 1 END) AS "S-D-F"
            
        FROM asignacion_meta am
        JOIN empleado e ON am.cedula_empleado = e.cedula
        JOIN meta m ON am.id_meta = m.id_meta
        GROUP BY e.cedula, e.nombre, e.apellido, e.nivel, e.cargo, e.departamento,am.monto
        ORDER BY e.nombre;

                        
""")
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    cursor.close()
    conn.close()
    return data



def update_meta_asiggnada_for_id(id_asignacion):
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("update asignacion_meta set estado = 'procesado' where id_asignacion = %s RETURNING cedula_empleado", (id_asignacion,))
    conn.commit()
    conn.close()


def data_for_txt():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("""
        select pago.*, empleado.numero_cuenta, empleado.nombre, empleado.apellido
        from pago
        join empleado on pago.cedula_empleado = empleado.cedula
		where pago.estatus = 'pendiente'

""")
    columnas = [desc[0] for desc in cursor.description]
    empleado = cursor.fetchall()
    data = [dict(zip(columnas, row)) for row in empleado]
    
    cursor.execute("update pago set estatus = 'pagado' where cedula_empleado = %s" , (data[0]['cedula_empleado'],))
    cursor.execute("update asignacion_meta set estado = 'pagado' where estado = 'procesado' ")
    conn.commit()

    cursor.close()
    conn.close()
    return data


def update_pagos():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("update pago set estatus = 'pagado' where cedula_empleado = %s")
    conn.commit()
    conn.close()
    
