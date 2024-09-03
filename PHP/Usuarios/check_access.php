<?php
function checkAccess($required_roles) {
    session_start();
    
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: /cultiverde-rendimientos/HTML/unauthorized.php');
        exit();
    }

    if (!in_array($_SESSION['role_id'], $required_roles)) {
        header('Location: /cultiverde-rendimientos/HTML/unauthorized.php');
        exit();
    }
}
?>
