<?php
include '../db.php';

// Verificar conexión
if ($conn === false) {
    die("Conexión fallida: " . sqlsrv_errors());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoProducto = $_POST["codigoProducto"];

    $sql = "{call sp_GetNombreProducto(?)}";
    $params = array($codigoProducto);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt !== false) {
        if (sqlsrv_has_rows($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            echo json_encode(['existe' => true, 'nombre' => $row['nombre_producto']]);
        } else {
            echo json_encode(['existe' => false]);
        }
    } else {
        echo json_encode(['existe' => false, 'error' => sqlsrv_errors()]);
    }

    sqlsrv_free_stmt($stmt);
}

sqlsrv_close($conn);
?>
