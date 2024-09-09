CREATE PROCEDURE sp_ContarRangosHoy
AS
BEGIN
    ;WITH RangoInicio AS (
        SELECT
            fecha_registro,
            hora_registro AS hora_inicio,
            LEAD(hora_registro) OVER (PARTITION BY CAST(fecha_registro AS DATE) ORDER BY hora_registro) AS hora_fin,
            ROW_NUMBER() OVER (PARTITION BY CAST(fecha_registro AS DATE) ORDER BY hora_registro) AS rn
        FROM rendimiento
        WHERE id_tipo_ingreso = 2
        AND CAST(fecha_registro AS DATE) = CAST(GETDATE() AS DATE) -- Filtrar solo el día de hoy
    ),
    RangoFin AS (
        SELECT
            fecha_registro,
            hora_registro AS hora_fin,
            ROW_NUMBER() OVER (PARTITION BY CAST(fecha_registro AS DATE) ORDER BY hora_registro) AS rn
        FROM rendimiento
        WHERE id_tipo_ingreso = 3
        AND CAST(fecha_registro AS DATE) = CAST(GETDATE() AS DATE) -- Filtrar solo el día de hoy
    ),
    RangosDefinidos AS (
        SELECT
            r.fecha_registro,
            r.hora_inicio,
            ISNULL(f.hora_fin, '23:59:59') AS hora_fin -- Asignar el fin del día si no hay un fin definido
        FROM RangoInicio r
        LEFT JOIN RangoFin f ON r.fecha_registro = f.fecha_registro AND r.rn = f.rn
    )
    SELECT
        COUNT(*) AS total_rangos
    FROM RangosDefinidos;
END;
