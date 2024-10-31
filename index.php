<?php
include './PHP/Usuarios/check_access.php';

// Asegura que solo los usuarios con role_id 2 (editor) o 1 (admin) puedan acceder
checkAccess([1, 2, 3]);

// Código para mostrar la página
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cultiverde - Menu</title>
    <link rel="stylesheet" href="./CSS/stylesPMenu.css">
    <link rel="icon" href="./A-IMG/logo_prueba.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="./SCRIPTS/fullscreen.js"></script>
    <style>
        .logout-button {
            position: fixed;
            bottom: 70px;
            right: 20px;
            background-color: #f0f0f0;
            border: none;
            border-radius: 50%;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            font-size: 24px;
            color: #333;
            z-index: 9999;
        }

        .logout-button i {
            margin: 0;
        }

        .logout-button:hover {
            background-color: #ddd;
        }

        .logout-button:hover::after {
            content: "Cerrar sesión";
            position: absolute;
            bottom: 40px;
            right: 0;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <img src="./A-IMG/logo_prueba.png" alt="Logo de la empresa" class="logo">
    <button class="logout-button" onclick="window.location.href='/cultiverde-rendimientos/PHP/Usuarios/logout.php';">
        <i class="fas fa-door-open"></i>
    </button>
    <div class="menu">
        <div class="bottom-row">
            <a href="./HTML/ingProductos1.php" class="menu-item">
                <i class="fas fa-box"></i>
                <span>Productos</span>
            </a>
            <a href="./HTML/ingPersonal.php" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Personas</span>
            </a>
            <a href="./HTML/rendimientos.php" class="menu-item" id="rendimientosLink">
                <i class="fas fa-file"></i>
                <span>Rendimientos</span>
            </a>
            <a href="./HTML/rendimietosFechas.php" class="menu-item">
                <i class="far fa-calendar-alt"></i>
                <span>Fechas Rendimiento</span>
            </a>
            <a href="./HTML/DesempeñoHora.php" class="menu-item">
                <i class="fas fa-medal"></i>
                <span>Desempeño</span>
            </a>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Consulta el estado de inicio desde el script PHP
                fetch('./PHP/validar_inicio.php') // Asegúrate de que la ruta sea correcta
                    .then(response => response.json())
                    .then(data => {
                        if (data.iniciado) {
                            // Si se ha iniciado, mantiene la ruta original
                            console.log('Actividades iniciadas. Manteniendo ruta.');
                        } else {
                            // Si no se ha iniciado, redirige a la página de espera
                            const rendimientosLink = document.getElementById('rendimientosLink');
                            if (rendimientosLink) {
                                rendimientosLink.href = './PAGES/WhaitingPage.php';
                            }
                            console.log('No se han iniciado las actividades. Redirigiendo.');
                        }
                    })
                    .catch(error => {
                        console.error('Error al verificar el estado de inicio:', error);
                    });
            });
        </script>
    </div>
    <footer class="version-tag">
        <p>Versión 2.2.9</p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Recupera el estado de pantalla completa desde localStorage
            const isFullscreen = JSON.parse(localStorage.getItem('isFullscreen')) || false;

            // Aplica el estado de pantalla completa al cargar la página
            if (isFullscreen) {
                enterFullscreen();
            }
        });

        // Función para cambiar el estado de pantalla completa (puede estar en un archivo compartido)
        function enterFullscreen() {
            document.documentElement.requestFullscreen();
        }

        // Función para salir del modo pantalla completa (puede estar en un archivo compartido)
        function exitFullscreen() {
            document.exitFullscreen();
        }
    </script>
    
</body>
</html>
