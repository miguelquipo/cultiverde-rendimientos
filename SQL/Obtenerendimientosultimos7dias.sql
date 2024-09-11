;WITH RangoInicio AS (
    SELECT
        fecha_registro,
        hora_registro AS hora_inicio,
        LEAD(hora_registro) OVER (PARTITION BY CAST(fecha_registro AS DATE) ORDER BY hora_registro) AS hora_fin,
        ROW_NUMBER() OVER (PARTITION BY CAST(fecha_registro AS DATE) ORDER BY hora_registro) AS rn
    FROM rendimiento
    WHERE id_tipo_ingreso = 2
),
RangoFin AS (
    SELECT
        fecha_registro,
        hora_registro AS hora_fin,
        ROW_NUMBER() OVER (PARTITION BY CAST(fecha_registro AS DATE) ORDER BY hora_registro) AS rn
    FROM rendimiento
    WHERE id_tipo_ingreso = 3
),
RangosDefinidos AS (
    SELECT
        r.fecha_registro,
        r.hora_inicio,
        ISNULL(f.hora_fin, '23:59:59') AS hora_fin
    FROM RangoInicio r
    LEFT JOIN RangoFin f ON r.fecha_registro = f.fecha_registro AND r.rn = f.rn
)
SELECT
    rendimiento.id_producto AS code_producto,
    rendimiento.cantidad_vendida,
    productos.nombre_producto,
    productos.cliente,  -- Nuevo campo agregado
    productos.valor_en_tallos,  -- Nuevo campo agregado
    trabajadores.nombre AS nombre_trabajador,
    trabajadores.apellido AS apellido_trabajador,
    CONVERT(varchar(10), rendimiento.fecha_registro, 103) AS fecha_registro,
    CONVERT(varchar(8), rendimiento.hora_registro, 108) AS hora_registro,
    DATENAME(WEEKDAY, rendimiento.fecha_registro) AS dia_semana,
    DATEPART(WEEK, rendimiento.fecha_registro) AS semana_ano,
    (3600.0 / productos.rendimiento_producto_hora) AS valor_segundos,
    (3600.0 / productos.rendimiento_producto_hora) / 60 AS valor_minutos,
    (3600.0 / productos.rendimiento_producto_hora) / 3600 AS valor_horas,
    CONCAT(
        CONVERT(varchar(8), r.hora_inicio, 108), ' - ',
        CONVERT(varchar(8), r.hora_fin, 108)
    ) AS rango,
    -- Calcular el porcentaje de cantidad vendida y dividirlo por 100
    (rendimiento.cantidad_vendida * 100.0 / NULLIF(productos.rendimiento_producto_hora, 0) / 
    CASE 
        WHEN DATEPART(WEEKDAY, rendimiento.fecha_registro) BETWEEN 2 AND 6 THEN 7  -- Lunes a Viernes
        ELSE 5  -- Sábado y Domingo
    END) / 100 AS porcentaje_ingresos_por_hora
FROM
    rendimiento
INNER JOIN
    productos ON rendimiento.id_producto = productos.id_producto
INNER JOIN
    trabajadores ON rendimiento.id_trabajador = trabajadores.id_trabajador
LEFT JOIN
    RangosDefinidos r ON
    CAST(rendimiento.fecha_registro AS DATE) = r.fecha_registro
    AND CAST(rendimiento.hora_registro AS TIME) BETWEEN r.hora_inicio AND r.hora_fin
WHERE
    rendimiento.fecha_registro >= DATEADD(DAY, -7, CAST(GETDATE() AS DATE))
    AND rendimiento.fecha_registro <= CAST(GETDATE() AS DATE)
    AND rendimiento.id_tipo_ingreso IN (1, 5)
ORDER BY
    rendimiento.fecha_registro, rendimiento.hora_registro;

