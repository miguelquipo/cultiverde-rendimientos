<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Verifica si la conexión a la base de datos ha fallado
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Procedimiento almacenado que acabamos de crear
$sql = "EXEC sp_ObtenerPorcentajeIngresos"; 

// Ejecuta la consulta
$result = sqlsrv_query($conn, $sql);

// Arreglo donde almacenaremos los datos
$porcentajes = [];

if ($result !== false) {
    // Recorrer los resultados de la consulta
    while ($trabajador = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $porcentajes[] = $trabajador; // Añadir cada fila al arreglo
    }
    sqlsrv_free_stmt($result); // Liberar el recurso de la consulta
}

// Cierra la conexión a la base de datos
sqlsrv_close($conn);

// Establece el encabezado para devolver JSON
header('Content-Type: application/json');

// Devuelve los resultados en formato JSON
echo json_encode($porcentajes);
?>
