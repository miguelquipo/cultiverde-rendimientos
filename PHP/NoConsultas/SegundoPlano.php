<?php
// Conexión a SQL Server
$serverName = "localhost\\SQLEXPRESS";
$uid = "sa";
$pwd = "faber33";
$databaseName = "dbrendimientos";
$connectionInfo = array(
    "UID" => $uid,
    "PWD" => $pwd,
    "Database" => $databaseName,
    "TrustServerCertificate" => true,
    "Encrypt" => false
);
$conn = sqlsrv_connect($serverName, $connectionInfo);

if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

// Define el intervalo de tiempo entre ejecuciones (en segundos)
$intervaloEjecucion = 10; // 10 segundos (ajústalo según tus necesidades)

// Obtener la fecha y hora actual
$currentDateTime = new DateTime();
$currentDateTime->setTimezone(new DateTimeZone('America/Chicago')); // Cambia a tu zona horaria deseada
$today = $currentDateTime->format('Y-m-d');

// Validar si existen registros de tipo 2 y 3 en el día actual
$stmtCheckType2And3 = sqlsrv_query($conn, "SELECT COUNT(*) as count FROM rendimiento WHERE id_tipo_ingreso IN (2, 3) AND CONVERT(DATE, fecha_registro) = ?", array($today));
$rowCount = sqlsrv_fetch_array($stmtCheckType2And3, SQLSRV_FETCH_ASSOC);
if ($rowCount['count'] == 0) {
    echo "No existen registros de tipo 2 y 3 para el día de hoy. Cerrando el script.\n";
    sqlsrv_close($conn);
    exit;
}
sqlsrv_free_stmt($stmtCheckType2And3);

// Bucle para la ejecución continua en segundo plano
while (true) {
    // Eliminar registros antiguos de la tabla boton_actividades
    $stmtDeleteOldRecords = sqlsrv_query($conn, "DELETE FROM boton_actividades WHERE fecha < CURRENT_DATE");

    // Obtener la hora del último registro con id_tipo_ingreso = 3 para el día actual
    $stmtSelectLastType3 = sqlsrv_query($conn, "SELECT TOP 1 hora_registro FROM rendimiento WHERE id_tipo_ingreso = 3 AND CONVERT(DATE, fecha_registro) = ? ORDER BY fecha_registro DESC, hora_registro DESC", array($today));
    $lastStartTimeType3 = null;
    if ($stmtSelectLastType3 !== false) {
        $row = sqlsrv_fetch_array($stmtSelectLastType3, SQLSRV_FETCH_ASSOC);
        if ($row !== null) {
            $lastStartTimeType3 = $row['hora_registro'];
        }
        sqlsrv_free_stmt($stmtSelectLastType3);
    }

    // Si existe un registro de id_tipo_ingreso = 3 para el día actual y la hora actual es mayor o igual a la hora del último registro
    if (!empty($lastStartTimeType3) && $currentDateTime->format('H:i:s') >= $lastStartTimeType3->format('H:i:s')) {
        // Obtener la hora del último registro con id_tipo_ingreso = 2 para el día actual
        $stmtSelectLastType2 = sqlsrv_query($conn, "SELECT TOP 1 hora_registro FROM rendimiento WHERE id_tipo_ingreso = 2 AND CONVERT(DATE, fecha_registro) = ? ORDER BY fecha_registro DESC, hora_registro DESC", array($today));
        $lastStartTimeType2 = null;
        if ($stmtSelectLastType2 !== false) {
            $row = sqlsrv_fetch_array($stmtSelectLastType2, SQLSRV_FETCH_ASSOC);
            if ($row !== null) {
                $lastStartTimeType2 = $row['hora_registro'];
            }
            sqlsrv_free_stmt($stmtSelectLastType2);
        }

        // Insertar nuevo registro de id_tipo_ingreso = 2 con una hora de diferencia al último registro
        if (!empty($lastStartTimeType2)) {
            $nextHourType2 = (new DateTime($lastStartTimeType2->format('Y-m-d H:i:s')))->add(new DateInterval('PT1H2S'))->format('H:i:s');
            $stmtInsertType2 = sqlsrv_query($conn, "INSERT INTO rendimiento (cantidad_vendida, fecha_registro, id_tipo_ingreso, hora_registro) VALUES (1, ?, 2, ?)", array($today, $nextHourType2));
        }

        // Insertar nuevo registro de id_tipo_ingreso = 3 con una hora de diferencia al último registro
        $nextHourType3 = (new DateTime($lastStartTimeType3->format('Y-m-d H:i:s')))->add(new DateInterval('PT1H2S'))->format('H:i:s');
        $stmtInsertType3 = sqlsrv_query($conn, "INSERT INTO rendimiento (cantidad_vendida, fecha_registro, id_tipo_ingreso, hora_registro) VALUES (1, ?, 3, ?)", array($today, $nextHourType3));
    }

    // Dormir durante el intervalo definido
    sleep($intervaloEjecucion);
}

// Este código debería ejecutarse solo si se detiene el bucle (por ejemplo, si se cierra el script)
sqlsrv_close($conn);
?>
