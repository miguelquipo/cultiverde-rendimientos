<?php
include './PHP/Usuarios/check_access.php';

// Asegura que solo los usuarios con role_id 2 (editor) o 1 (admin) puedan acceder
checkAccess([1, 2, 3]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cultiverde - Menu</title><!--
    <link rel="stylesheet" href="./CSS/stylesPMenu.css">-->
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

        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    display: flex;
    flex-direction: column; /* Asegura una disposición vertical */
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* Usa al menos el 100% de la altura de la pantalla */
    overflow: auto; /* Permite scroll si es necesario */
}

.logo {
		position: absolute;
		top: 20px;
		right: 100px;
		width: 150px; /* Ajusta el ancho según tu logo */
		height: auto; /* Para mantener la proporción */
		}
	  .logo-fixed {
	  position: fixed;
	  top: 10px; /* Ajusta la posición fija según tus necesidades */
	  right: 10px; /* Ajusta la posición fija según tus necesidades */
	  transition: top 0.3s ease; /* Agrega una transición suave para el efecto */
	  }
/* Estilo general */
.menu {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Espaciado entre elementos */
    justify-content: center;
    /* Alinea horizontalmente en pantallas grandes */
    max-width: 1500px; /* Limita el ancho máximo del contenedor */
    margin: 0 auto;
}

    /* Estilo de las tarjetas */
.menu-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 150px; /* Ancho para pantallas grandes */
    height: 150px; /* Altura fija */
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
    text-decoration: none;
}


    .menu-item .icono {
        font-size: 48px;
        color: #555;
        margin-bottom: 10px;
        transition: color 0.3s;
    }

    .menu-item:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .menu-item:hover .icono {
        animation: bounce 0.5s infinite alternate;
    }

    @keyframes bounce {
        from {
            transform: translateY(0);
        }
        to {
            transform: translateY(-10px);
        }
    }

    .menu-item span {
        font-size: 16px;
        color: #333;
    }

    /* Colores específicos */
    .productos:hover {
        background-color:#ED6263;
    }
    .productos:hover .icono {
        color: #ffffff;
    }

    .personas:hover {
        background-color: #42a5f5;
    }
    .personas:hover .icono {
        color: #ffffff;
    }

    .rendimientos:hover {
        background-color: #66bb6a;
    }
    .rendimientos:hover .icono {
        color: #ffffff;
    }

    .fechas:hover {
        background-color: #ffa726;
    }
    .fechas:hover .icono {
        color: #ffffff;
    }

    .desempeno:hover {
        background-color:#BFD641;
    }
    .desempeno:hover .icono {
        color: #ffffff;
    }
/* Adaptación para pantallas pequeñas */
@media only screen and (max-width: 1000px) {
    .menu {
        gap: 15px;
    }

    .menu-item {
        width: 45%; /* Dos columnas en pantallas pequeñas */
        height: auto; /* Ajuste automático */
        margin-bottom: 15px;
    }
    .logo{
		display: none;
	}
}
.version-tag {
	position:absolute;
	bottom: 20px;
	right: 20px;
	color: #303625;
	font-size: 20px;
  }
    </style>
</head>

<body>
    <img src="./A-IMG/logo_prueba.png" alt="Logo de la empresa" class="logo">
    <button class="logout-button" onclick="window.location.href='/cultiverde-rendimientos/PHP/Usuarios/logout.php';">
        <i class="fas fa-door-open"></i>
    </button>

    <div class="menu">
        <a href="./HTML/ingProductos1.php" class="menu-item productos">
            <i class="fas fa-box icono"></i>
            <span>Productos</span>
        </a>
        <a href="./HTML/ingPersonal.php" class="menu-item personas">
            <i class="fas fa-users icono"></i>
            <span>Personas</span>
        </a>
        <a href="./HTML/rendimientos.php" class="menu-item rendimientos">
            <i class="fas fa-file icono"></i>
            <span>Rendimientos</span>
        </a>
        <a href="./HTML/rendimietosFechas.php" class="menu-item fechas">
            <i class="far fa-calendar-alt icono"></i>
            <span>Fechas Rendimiento</span>
        </a>
        <a href="./HTML/DesempeñoHora.php" class="menu-item desempeno">
            <i class="fas fa-medal icono"></i>
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
        <p>Versión 2.31</p>
    </footer>

</body>

</html>