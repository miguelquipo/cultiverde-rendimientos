<?php
include 'db.php';

// Establece la zona horaria si es necesario
date_default_timezone_set('America/Chicago');

// Obtén la fecha actual
$hoy = date('Y-m-d');

// Consulta para verificar si hay una entrada de inicio para hoy
$sql = "SELECT COUNT(*) AS count FROM boton_actividades WHERE accion = 'INICIO' AND CAST(fecha AS DATE) = ?";

$params = array($hoy);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(json_encode(['error' => 'Error en la consulta: ' . print_r(sqlsrv_errors(), true)]));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Devuelve el resultado como JSON
echo json_encode(['iniciado' => $row['count'] > 0]);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
