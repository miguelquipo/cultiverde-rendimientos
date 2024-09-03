<?php
$serverName = "localhost\\SQLEXPRESS";
$uid = "sa";
$pwd = "faber33";
$databaseName = "dbrendimientos31-07-2024";
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

$query = "SELECT is_running FROM script_status WHERE script_name = 'SegundoPlano'";
$result = sqlsrv_query($conn, $query);

if ($result !== false && $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if ($row['is_running']) {
        echo json_encode(['status' => 'running']);
    } else {
        echo json_encode(['status' => 'stopped']);
    }
} else {
    echo json_encode(['status' => 'error']);
}

sqlsrv_close($conn);
?>
