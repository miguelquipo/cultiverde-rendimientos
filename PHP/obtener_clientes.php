<?php
include 'db.php';

$sql = "SELECT DISTINCT cliente FROM productos WHERE cliente IS NOT NULL AND cliente <> ''";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$clientes = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $clientes[] = $row['cliente'];
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

echo json_encode($clientes);
?>
