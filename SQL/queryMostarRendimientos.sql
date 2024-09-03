
--
SELECT
    productos.id_producto AS id_rendimiento,
    SUM(rendimiento.cantidad_vendida) AS cantidad_vendida,
    productos.nombre_producto,
    trabajadores.nombre AS nombre_trabajador,
    trabajadores.apellido AS apellido_trabajador,
    CONVERT(varchar(10), MAX(rendimiento.fecha_registro), 103) AS fecha_registro,
    CONVERT(varchar(8), MAX(rendimiento.hora_registro), 108) AS hora_registro,
    CASE 
        WHEN DATEDIFF(MINUTE, MAX(CONVERT(datetime, rendimiento.fecha_registro) + CONVERT(datetime, rendimiento.hora_registro)), GETDATE()) <= 5 THEN 'Reciente'
        WHEN DATEDIFF(MINUTE, MAX(CONVERT(datetime, rendimiento.fecha_registro) + CONVERT(datetime, rendimiento.hora_registro)), GETDATE()) > 5 AND DATEDIFF(MINUTE, MAX(CONVERT(datetime, rendimiento.fecha_registro) + CONVERT(datetime, rendimiento.hora_registro)), GETDATE()) <= 10 THEN 'Un tanto tarde'
        ELSE 'Tarde'
    END AS estado_tiempo
FROM
    rendimiento
INNER JOIN
    productos ON rendimiento.id_producto = productos.id_producto
INNER JOIN
    trabajadores ON rendimiento.id_trabajador = trabajadores.id_trabajador
WHERE
    CAST(rendimiento.hora_registro AS TIME) >= 
    (
        SELECT MAX(hora_registro)
        FROM rendimiento
        WHERE id_tipo_ingreso = 2 AND CAST(fecha_registro AS DATE) = CAST(GETDATE() AS DATE)
    )
AND
    CAST(rendimiento.hora_registro AS TIME) < 
    (
        SELECT MAX(hora_registro)
        FROM rendimiento
        WHERE id_tipo_ingreso = 3 AND CAST(fecha_registro AS DATE) = CAST(GETDATE() AS DATE)
    )
AND
    CAST(rendimiento.fecha_registro AS DATE) = CAST(GETDATE() AS DATE)
GROUP BY
    productos.id_producto, productos.nombre_producto, trabajadores.nombre, trabajadores.apellido
ORDER BY
    MAX(rendimiento.hora_registro) DESC;
