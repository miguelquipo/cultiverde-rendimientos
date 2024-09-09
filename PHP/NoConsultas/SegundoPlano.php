<?php
// Conexión a SQL Server
function conectarBaseDeDatos() {
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
        die("Conexión fallida: " . print_r(sqlsrv_errors(), true));
    }
    return $conn;
}

// Define el intervalo de tiempo entre ejecuciones (en segundos)
$intervaloEjecucion = 10; // Ajustar según sea necesario

// Obtener la fecha y hora actual
date_default_timezone_set('America/Chicago'); // Cambia a tu zona horaria

// Bucle para la ejecución continua en segundo plano
while (true) {
    // Conectar a la base de datos al inicio de cada ciclo
    $conn = conectarBaseDeDatos();

    // Validar si existen registros de tipo 2 y 3 en el día actual
    $stmtCheckType2And3 = sqlsrv_query($conn, "SELECT COUNT(*) as count FROM rendimiento WHERE id_tipo_ingreso IN (2, 3) AND CONVERT(DATE, fecha_registro) = ?", array(date('Y-m-d')));
    if ($stmtCheckType2And3 === false) {
        echo "Error en la consulta: " . print_r(sqlsrv_errors(), true);
        sqlsrv_close($conn);
        exit;
    }
    $rowCount = sqlsrv_fetch_array($stmtCheckType2And3, SQLSRV_FETCH_ASSOC);
    if ($rowCount['count'] == 0) {
        echo "No existen registros de tipo 2 y 3 para el día de hoy. Cerrando el script.\n";
        sqlsrv_free_stmt($stmtCheckType2And3);
        sqlsrv_close($conn);
        break; // Salir del bucle si no hay registros
    }
    sqlsrv_free_stmt($stmtCheckType2And3);

    // Eliminar registros antiguos de la tabla boton_actividades
    $stmtDeleteOldRecords = sqlsrv_query($conn, "DELETE FROM boton_actividades WHERE fecha < CAST(GETDATE() AS DATE)");
    if ($stmtDeleteOldRecords === false) {
        echo "Error al eliminar registros antiguos: " . print_r(sqlsrv_errors(), true);
    } else {
        sqlsrv_free_stmt($stmtDeleteOldRecords);
    }

    // Obtener la hora del último registro de tipo 3
    $stmtSelectLastType3 = sqlsrv_query($conn, "SELECT TOP 1 hora_registro FROM rendimiento WHERE id_tipo_ingreso = 3 AND CONVERT(DATE, fecha_registro) = ? ORDER BY fecha_registro DESC, hora_registro DESC", array(date('Y-m-d')));
    if ($stmtSelectLastType3 === false) {
        echo "Error en la consulta de tipo 3: " . print_r(sqlsrv_errors(), true);
        sqlsrv_close($conn);
        continue;
    }
    $lastStartTimeType3 = null;
    if ($row = sqlsrv_fetch_array($stmtSelectLastType3, SQLSRV_FETCH_ASSOC)) {
        $lastStartTimeType3 = new DateTime($row['hora_registro']->format('H:i:s'));
    }
    sqlsrv_free_stmt($stmtSelectLastType3);

    if ($lastStartTimeType3 !== null) {
        // Obtener la hora actual
        $currentDateTime = new DateTime();
        $currentHour = $currentDateTime->format('H:i:s');

        // Compara la hora actual con la última hora de tipo 3
        if ($currentHour > $lastStartTimeType3->format('H:i:s')) {
            // Obtener la hora del último registro de tipo 2
            $stmtSelectLastType2 = sqlsrv_query($conn, "SELECT TOP 1 hora_registro FROM rendimiento WHERE id_tipo_ingreso = 2 AND CONVERT(DATE, fecha_registro) = ? ORDER BY fecha_registro DESC, hora_registro DESC", array(date('Y-m-d')));
            if ($stmtSelectLastType2 === false) {
                echo "Error en la consulta de tipo 2: " . print_r(sqlsrv_errors(), true);
                sqlsrv_close($conn);
                continue;
            }
            $lastStartTimeType2 = null;
            if ($row = sqlsrv_fetch_array($stmtSelectLastType2, SQLSRV_FETCH_ASSOC)) {
                $lastStartTimeType2 = new DateTime($row['hora_registro']->format('H:i:s'));
            }
            sqlsrv_free_stmt($stmtSelectLastType2);

            if ($lastStartTimeType2 !== null) {
                // Genera el próximo rango para tipo 2
                $nextHourType2 = (clone $lastStartTimeType2)->add(new DateInterval('PT1H'))->format('H:i:s');
                $stmtInsertType2 = sqlsrv_query($conn, "INSERT INTO rendimiento (cantidad_vendida, fecha_registro, id_tipo_ingreso, hora_registro) VALUES (1, ?, 2, ?)", array(date('Y-m-d'), $nextHourType2));
                if ($stmtInsertType2 === false) {
                    echo "Error al insertar tipo 2: " . print_r(sqlsrv_errors(), true);
                } else {
                    sqlsrv_free_stmt($stmtInsertType2);
                }
            }

            // Genera el próximo rango para tipo 3
            $nextHourType3 = (clone $lastStartTimeType3)->add(new DateInterval('PT1H'))->format('H:i:s');
            $stmtInsertType3 = sqlsrv_query($conn, "INSERT INTO rendimiento (cantidad_vendida, fecha_registro, id_tipo_ingreso, hora_registro) VALUES (1, ?, 3, ?)", array(date('Y-m-d'), $nextHourType3));
            if ($stmtInsertType3 === false) {
                echo "Error al insertar tipo 3: " . print_r(sqlsrv_errors(), true);
            } else {
                sqlsrv_free_stmt($stmtInsertType3);
            }
        }
    }

    sqlsrv_close($conn); // Cerrar la conexión antes de dormir

    // Dormir durante el intervalo definido
    sleep($intervaloEjecucion);
}
?>
