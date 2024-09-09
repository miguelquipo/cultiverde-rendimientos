CREATE PROCEDURE sp_ObtenerPorcentajeIngresos
AS
BEGIN
    SELECT
        CONCAT(t.nombre, ' ', t.apellido) AS nombre_completo,
        (SELECT imagen FROM trabajadores WHERE id_trabajador = t.id_trabajador) AS imagen,
        MAX(r.fecha_registro) AS fecha_registro,
        CAST(ROUND(
            SUM(r.cantidad_vendida) * 100.0 / NULLIF(MAX(p.rendimiento_producto_hora), 0) / 
            CASE 
                WHEN DATEPART(WEEKDAY, MAX(r.fecha_registro)) BETWEEN 2 AND 6 THEN 7  -- Lunes a Viernes
                ELSE 5  -- Sábado y Domingo
            END
        , 2) AS DECIMAL(10)) AS porcentaje_ingresos_por_hora
    FROM
        trabajadores t
    JOIN
        rendimiento r ON t.id_trabajador = r.id_trabajador
    JOIN
        productos p ON r.id_producto = p.id_producto
    WHERE
        CONVERT(DATE, r.fecha_registro) = CONVERT(DATE, GETDATE())
    GROUP BY
        t.id_trabajador, t.nombre, t.apellido
    ORDER BY
        porcentaje_ingresos_por_hora DESC;
END;
