<?php
include 'db.php';

if (isset($_POST['product-name'], $_POST['product-rendimiento-hora'], $_POST['cliente'], $_POST['valor-en-tallos'])) {
    $productName = $_POST['product-name'];
    $productRendimientoHora = $_POST['product-rendimiento-hora'];
    $cliente = $_POST['cliente'];
    $valorEnTallos = $_POST['valor-en-tallos'];
    $productId = $_POST['product-id'];

    if (empty($productId)) {
        // Insertar un nuevo producto
        $sql_insert = "INSERT INTO productos (nombre_producto, rendimiento_producto_hora, cliente, valor_en_tallos) VALUES (?, ?, ?, ?)";
        $params_insert = array($productName, $productRendimientoHora, $cliente, $valorEnTallos);
        $stmt_insert = sqlsrv_query($conn, $sql_insert, $params_insert);

        if ($stmt_insert === false) {
            echo 'Hubo un error al ingresar el Producto';
            exit();
        } else {
            echo 'Se ha ingresado correctamente';
            header("Location: ../HTML/ingProductos1.php"); // Redirigir con mensaje de éxito
            exit();
        }
    } else {
        // Actualizar producto existente
        $sql_update = "UPDATE productos SET nombre_producto = ?, rendimiento_producto_hora = ?, cliente = ?, valor_en_tallos = ? WHERE id_producto = ?";
        $params_update = array($productName, $productRendimientoHora, $cliente, $valorEnTallos, $productId);
        $stmt_update = sqlsrv_query($conn, $sql_update, $params_update);

        if ($stmt_update === false) {
            echo 'Hubo un error al actualizar el Producto';
            exit();
        } else {
            echo 'Se ha actualizado correctamente';
            header("Location: ../HTML/ingProductos1.php"); // Redirigir con mensaje de éxito
            exit();
        }
    }

    // Liberar recursos
    if ($stmt_insert) {
        sqlsrv_free_stmt($stmt_insert);
    } elseif ($stmt_update) {
        sqlsrv_free_stmt($stmt_update);
    }
}

sqlsrv_close($conn); // Cerrar la conexión a la base de datos
?>
