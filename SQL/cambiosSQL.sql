USE [dbrendimientos11]
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerBuenoHora]    Script Date: 28/10/2024 6:56:42 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_ObtenerBuenoHora]
AS
BEGIN
    SELECT
CONCAT(
    SUBSTRING(t.nombre, 1, CHARINDEX(' ', t.nombre + ' ') - 1), 
    ' ', 
    SUBSTRING(t.apellido, 1, CHARINDEX(' ', t.apellido + ' ') - 1)
) AS nombre_apellido_alias
,
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
        t.id_trabajador, t.nombre, t.apellido
    HAVING
        ROUND(SUM(r.cantidad_vendida) * 100.0 / NULLIF(MAX(p.rendimiento_producto_hora), 0), 2) BETWEEN 75 AND 99.99
    ORDER BY
        porcentaje_ingresos_por_hora DESC
    OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY;
END


USE [dbrendimientos11]
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerDesempeno]    Script Date: 28/10/2024 6:56:33 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_ObtenerDesempeno]
AS
BEGIN
    SELECT
	CONCAT(
    SUBSTRING(t.nombre, 1, CHARINDEX(' ', t.nombre + ' ') - 1), 
    ' ', 
    SUBSTRING(t.apellido, 1, CHARINDEX(' ', t.apellido + ' ') - 1)
) AS nombre_apellido_alias
,
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
        t.id_trabajador, t.nombre, t.apellido
    HAVING
        ROUND(SUM(r.cantidad_vendida) * 100.0 / NULLIF(MAX(p.rendimiento_producto_hora), 0), 2) >= 100
    ORDER BY
        porcentaje_ingresos_por_hora DESC
    OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY;
END


USE [dbrendimientos11]
GO
/****** Object:  StoredProcedure [dbo].[sp_ObtenerObservacion]    Script Date: 28/10/2024 6:55:30 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_ObtenerObservacion]
AS
BEGIN
    SELECT
CONCAT(
    SUBSTRING(t.nombre, 1, CHARINDEX(' ', t.nombre + ' ') - 1), 
    ' ', 
    SUBSTRING(t.apellido, 1, CHARINDEX(' ', t.apellido + ' ') - 1)
) AS nombre_apellido_alias

,
   
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
        t.id_trabajador, t.nombre, t.apellido
    HAVING
        ROUND(SUM(r.cantidad_vendida) * 100.0 / NULLIF(MAX(p.rendimiento_producto_hora), 0), 2) < 75
    ORDER BY
        porcentaje_ingresos_por_hora DESC
    OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY;
END
