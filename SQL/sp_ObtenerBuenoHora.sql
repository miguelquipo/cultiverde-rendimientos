USE [dbrendimientos]
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerBuenoHora]    Script Date: 4/9/2024 10:41:43 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_ObtenerBuenoHora]
AS
BEGIN
    SELECT
        CONCAT(LEFT(t.nombre, 3), UPPER(SUBSTRING(t.apellido, 1, 5))) AS nombre_apellido_alias,
        p.nombre_producto AS producto_nombre,
        (SELECT imagen FROM trabajadores WHERE id_trabajador = t.id_trabajador) AS imagen,
        MAX(r.fecha_registro) AS fecha_registro,
        CAST(ROUND(SUM(r.cantidad_vendida) * 100.0 / NULLIF(MAX(p.rendimiento_producto_hora), 0), 2) AS DECIMAL(10,2)) AS porcentaje_ingresos_por_hora
    FROM
        trabajadores t
    JOIN
        rendimiento r ON t.id_trabajador = r.id_trabajador
    JOIN
        productos p ON r.id_producto = p.id_producto
    WHERE
        r.hora_registro >= 
            (
                SELECT MAX(hora_registro)
                FROM rendimiento
                WHERE id_tipo_ingreso = 2 AND CONVERT(DATE, fecha_registro) = CONVERT(DATE, GETDATE())
            )
        AND
        r.hora_registro < 
            (
                SELECT MAX(hora_registro)
                FROM rendimiento
                WHERE id_tipo_ingreso = 3 AND CONVERT(DATE, fecha_registro) = CONVERT(DATE, GETDATE())
            )
        AND CONVERT(DATE, r.fecha_registro) = CONVERT(DATE, GETDATE())
    GROUP BY
        t.id_trabajador, t.nombre, t.apellido, p.nombre_producto
    HAVING
        ROUND(SUM(r.cantidad_vendida) * 100.0 / NULLIF(MAX(p.rendimiento_producto_hora), 0), 2) BETWEEN 75 AND 99.99
    ORDER BY
        porcentaje_ingresos_por_hora DESC
    OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY;
END
