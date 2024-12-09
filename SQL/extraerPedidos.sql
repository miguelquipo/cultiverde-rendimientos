	
INSERT INTO Pedidos (fecha_pedido, codigo_cliente, cliente, codigo_articulo, articulo, cantidad)
SELECT
    CONVERT(varchar(10), V.FECHA_ELABO_CPD, 23) AS fecha_pedido,
    V.codigo_cle AS codigo_cliente,
    VA.NOMBRE_CLE AS cliente,
    VI.CODIGO_ART AS codigo_articulo,
    VO.NOMBRE_ART AS articulo,
    ROUND(CAST(VI.CANTIDAD_DPD AS decimal(10, 2)), 2) AS cantidad
FROM
    VentureCultivos.base_cultiverde2017.dbo.J_CABECE_PEDIDO V
    LEFT OUTER JOIN VentureCultivos.base_cultiverde2017.dbo.J_CLIENTE va ON va.CODIGO_CLE = v.CODIGO_CLE
    LEFT OUTER JOIN VentureCultivos.base_cultiverde2017.dbo.J_ESTADO_PEDIDO vE ON vE.CODIGO_EPE = v.CODIGO_EPE
    LEFT OUTER JOIN VentureCultivos.base_cultiverde2017.dbo.J_DETALL_PEDIDO vI ON vI.CODIGO_CPD = v.CODIGO_CPD
    LEFT OUTER JOIN VentureCultivos.base_cultiverde2017.dbo.C_ARTICULO vO ON vO.CODIGO_ART = vI.CODIGO_ART
    LEFT OUTER JOIN VentureCultivos.base_cultiverde2017.dbo.J_TIPO_CLIENTE vU ON vU.CODIGO_TCL = vA.CODIGO_TCL
    LEFT OUTER JOIN VentureCultivos.base_cultiverde2017.dbo.J_tipo_venta XA ON XA.codigo_tvn = v.codigo_tvn
WHERE
    DatePart("yyyy", v.FECHA_ELABO_CPD) = datepart(year, dateadd("yy", 0, getdate())) AND
    DatePart("mm", v.FECHA_ELABO_CPD) >= datepart(MONTH, dateadd("MM", 0, getdate())) AND
    VI.CANTIDAD_DPD > 0 AND
    V.CODIGO_EPE = '00101' AND
    NOT EXISTS (
        SELECT 1 
        FROM Pedidos P 
        WHERE P.fecha_pedido = CONVERT(varchar(10), V.FECHA_ELABO_CPD, 23) 
        AND P.codigo_cliente = V.codigo_cle 
        AND P.codigo_articulo = VI.CODIGO_ART
    )
ORDER BY
    v.FECHA_ELABO_CPD ASC,
    VO.NOMBRE_ART ASC;

	
