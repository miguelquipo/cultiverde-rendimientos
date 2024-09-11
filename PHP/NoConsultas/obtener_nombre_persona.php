<?php
include '../db.php';

// Verificar conexión
if ($conn === false) {
    die("Conexión fallida: " . print_r(sqlsrv_errors(), true));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"];  // Cambiar de 'codigoProducto' a 'cedula'

    // Preparar consulta para obtener el nombre del trabajador
    $sql = "SELECT nombre FROM trabajadores WHERE cedula = ?";
    $params = array($cedula);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt !== false) {
        // Verificar si se encontró algún registro
        if (sqlsrv_has_rows($stmt)) {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            // Devolver el nombre de la persona en JSON
            echo json_encode(['existe' => true, 'nombre' => $row['nombre']]);  // Cambiado 'nombre_producto' a 'nombre'
        } else {
            // Si no se encuentra el trabajador, devolver 'existe' => false
            echo json_encode(['existe' => false]);
        }
    } else {
        // Manejo de errores en caso de fallo en la consulta SQL
        echo json_encode(['existe' => false, 'error' => sqlsrv_errors()]);
    }

    // Liberar recursos
    sqlsrv_free_stmt($stmt);
}

// Cerrar la conexión
sqlsrv_close($conn);
?>
