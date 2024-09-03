<?php
// Realiza la conexión a la base de datos
include 'db.php';

// Verifica si se ha enviado una solicitud POST y si los campos del formulario están definidos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search-cedula']) && isset($_POST['search-producto']) && isset($_POST['insert-cantidad'])) {
    // Obtén los valores de los campos del formulario
    $cedula = $_POST['search-cedula'];
    $codigoProducto = $_POST['search-producto'];
    $cantidadVeces = intval($_POST['insert-cantidad']);

    // Función para buscar el ID del trabajador por la cédula
    $sql = "SELECT id_trabajador FROM trabajadores WHERE cedula = ?";
    $params = array($cedula);
    $stmtTrabajador = sqlsrv_query($conn, $sql, $params);
    if ($stmtTrabajador === false) {
        error_log("Error en la consulta de trabajador: " . print_r(sqlsrv_errors(), true));
        header("Location: ../HTML/rendimientos_auto.php?success=false&error=consulta_trabajador");
        exit();
    }
    $resultTrabajador = sqlsrv_fetch_array($stmtTrabajador);

    if ($resultTrabajador) {
        $idTrabajador = $resultTrabajador['id_trabajador'];
    } else {
        // Manejar el caso en que el trabajador no exista en la base de datos
        error_log("No se encontró el trabajador con cédula: " . $cedula);
        header("Location: ../HTML/rendimientos_auto.php?success=false&error=no_trabajador");
        exit();
    }

    // Obtener el último rango de horas registrado (inicio y fin) en la fecha actual
    $sql = "SELECT MAX(CASE WHEN id_tipo_ingreso = 2 THEN hora_registro END) AS hora_inicio,
                   MAX(CASE WHEN id_tipo_ingreso = 3 THEN hora_registro END) AS hora_fin
            FROM rendimiento
            WHERE CAST(fecha_registro AS DATE) = CAST(GETDATE() AS DATE)";
    $stmtUltimoRango = sqlsrv_query($conn, $sql);
    if ($stmtUltimoRango === false) {
        error_log("Error en la consulta del último rango de horas: " . print_r(sqlsrv_errors(), true));
        header("Location: ../HTML/rendimientos_auto.php?success=false&error=consulta_rango");
        exit();
    }
    $rowUltimoRango = sqlsrv_fetch_array($stmtUltimoRango);

    $ultimaHoraRegistroInicio = null;
    $ultimaHoraRegistroFin = null;

    if ($rowUltimoRango) {
        $ultimaHoraRegistroInicio = isset($rowUltimoRango['hora_inicio']) ? new DateTime($rowUltimoRango['hora_inicio']->format('Y-m-d H:i:s')) : null;
        $ultimaHoraRegistroFin = isset($rowUltimoRango['hora_fin']) ? new DateTime($rowUltimoRango['hora_fin']->format('Y-m-d H:i:s')) : null;
    }

    // Si no hay registros de inicio o fin, redirigir con un mensaje de error
    if ($ultimaHoraRegistroInicio === null || $ultimaHoraRegistroFin === null) {
        header("Location: ../HTML/rendimientos_auto.php?success=false&error=no_registro");
        exit();
    }

    // Obtener la fecha y hora actual una vez para usar en todos los registros
    $insertDateTime = new DateTime("now", new DateTimeZone("America/Chicago"));
    $formattedDateTime = $insertDateTime->format('Y-m-d H:i:s');

    // Insertar los registros en la tabla rendimiento
    for ($i = 0; $i < $cantidadVeces; $i++) {
        $sql = "INSERT INTO rendimiento (cantidad_vendida, fecha_registro, id_producto, id_trabajador, hora_registro, id_tipo_ingreso)
                VALUES (1, ?, ?, ?, ?, 1)";
        $params = array($formattedDateTime, $codigoProducto, $idTrabajador, $formattedDateTime);
        $stmtInsert = sqlsrv_query($conn, $sql, $params);

        // Verificar si la inserción fue exitosa
        if ($stmtInsert === false) {
            error_log("Error en la inserción de rendimiento: " . print_r(sqlsrv_errors(), true));
            header("Location: ../HTML/rendimientos_auto.php?success=false&error=insert_fallido");
            exit();
        }
    }

    // Redirigir al usuario con un mensaje de éxito solo si la inserción fue exitosa
    header("Location: ../HTML/rendimientos_auto.php?success=true");
    exit();
}

// Cerrar conexión
sqlsrv_close($conn);
?>
