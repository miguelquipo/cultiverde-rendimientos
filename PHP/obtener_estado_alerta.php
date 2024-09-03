<?php
// Establecer la zona horaria
date_default_timezone_set('America/Chicago');

// Conectar a la base de datos
$serverName = "localhost\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "dbrendimientos",
    "Uid" => "sa",
    "PWD" => "faber33",
    "TrustServerCertificate" => true,
    "Encrypt" => false
);
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    echo json_encode(array('error' => sqlsrv_errors()));
    exit();
}

// Función para obtener la última hora de inicio
function obtenerUltimaHoraInicio($conn) {
    $query = "SELECT TOP 1 hora FROM boton_actividades WHERE fecha = CONVERT(date, GETDATE()) AND accion = 'INICIO' ORDER BY id DESC";
    $stmt = sqlsrv_query($conn, $query);

    if ($stmt === false) {
        echo json_encode(array('error' => sqlsrv_errors()));
        exit();
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($row) {
        $hora = $row['hora'];
        return $hora instanceof DateTime ? $hora : new DateTime($hora, new DateTimeZone('America/Chicago'));
    }
    return null;
}

$horaInicio = obtenerUltimaHoraInicio($conn);
$horaActual = new DateTime('now', new DateTimeZone('America/Chicago'));

$response = array(
    'mostrarAlerta' => false,
    'horaInicio' => $horaInicio ? $horaInicio->format('H:i:s') : null,
    'horaActual' => $horaActual->format('H:i:s'),
);

if ($horaInicio !== null) {
    // Convertir horaInicio a DateTime para hacer la diferencia
    $horaInicioDateTime = new DateTime($response['horaInicio'], new DateTimeZone('America/Chicago'));
    $diferenciaMinutos = $horaActual->diff($horaInicioDateTime)->i;
    $response['diferenciaMinutos'] = $diferenciaMinutos;
    $response['esMenorDe5Minutos'] = $diferenciaMinutos < 2;
    $response['mostrarAlerta'] = $diferenciaMinutos < 2;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
