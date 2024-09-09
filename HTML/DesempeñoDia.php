<?php
include '../PHP/Usuarios/check_access.php';
// Asegura que solo los usuarios con role_id 2 (editor) o 1 (admin) puedan acceder
checkAccess([1, 2, 3]);
// Código para mostrar la página
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV - Rendimientos</title>
  <link rel="stylesheet" href="../CSS/stylesViewDia.css">
  <link rel="icon" href="../A-IMG/logo_prueba.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <link rel="stylesheet" href="../CSS/bootstrap-table.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
  

  </style>
</head>
<body>
<div id="infoDiv"></div>
  <img src="../A-IMG/logo_prueba.png" alt="Logo de la empresa" class="logo">
  <button class="logout-button" onclick="window.location.href='/cultiverde-rendimientos/PHP/Usuarios/logout.php';">
    <i class="fas fa-door-open"></i>
  </button>
  <div class="return-container">
    <a href="../index.php" class="return-button">
      <i class="fas fa-arrow-left"></i>
    </a>
  </div>
  <section class="py-0 px-0">
    <button id="startStopButton" class="start-stop-button" onclick="toggleStartStop()">INICIAR</button>
    <div class="content">
      <div class="settings-container">
        <div class="settings-icon" onmouseover="showSettingsDropdown()" onmouseout="hideSettingsDropdown()">
          <i class="fas fa-cog"></i>
          <div class="settings-dropdown" onmouseover="showSettingsDropdown()" onmouseout="hideSettingsDropdown()">
            <div class="night-mode-switch">
              <label class="switch">
                <input type="checkbox" id="nightModeSwitch" onchange="toggleNightMode()">
                <span class="slider"></span>
              </label>
              <span>Modo Nocturno</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contenedor adicional para manejar el espaciado -->
    <div class="outer-container">
      <!-- Tabla de Desempeño -->
      <div class="table-container">
        <table class="table">
          <thead>            
          <div style="text-align: center;">
  <h2 style="color: #05a602; font-weight: bold; font-size: 40px;">Porcentaje General <br></h2>
</div><br>
          </thead>
          <tbody id="desempeno-body">
            <!-- Las filas se agregarán dinámicamente aquí -->
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <script>
  window.onload = function () {
    // Ejecutar las funciones necesarias cuando la página cargue
    obtenerDatosRango();
    obtenerDatosDesempeno();
    redirigirTrasCincoMinutos();
    mostrarReloj();

    setInterval(async function () {
  await obtenerDatosRango();
}, 1000); // Actualiza cada 5 segundos

setInterval(async function () {
  await obtenerDatosDesempeno();
}, 1000); // Actualiza cada 5 segundos


    // Función para obtener los datos de rango desde el servidor
    async function obtenerDatosRango() {
      try {
        let url = '../PHP/view_cantidad_rendogs.php';
        const response = await fetch(url);
        const data = await response.json();
        mostrarDatosRango(data);
      } catch (error) {
        console.error('Error al obtener los datos de rango:', error);
      }
    }

    // Función para mostrar los datos de rango
    function mostrarDatosRango(data) {
      const infoDiv = document.getElementById('infoDiv');
      if (infoDiv) {
        infoDiv.innerHTML = `Horas Transcurridas: <br>${data.total_rangos} de 7`;
      }
    }

    async function obtenerDatosDesempeno() {
  try {
    let url = '../PHP/obtener_PorcentajeDia.php';
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error('Error en la red');
    }
    const data = await response.json();
    mostrarDatosDesempeno(data);
  } catch (error) {
    console.error('Error al obtener los datos:', error);
  }
}


    function mostrarDatosDesempeno(data) {
  const desempenoBody = document.getElementById('desempeno-body');
  desempenoBody.innerHTML = '';

  console.log('Datos de desempeño:', data); // Agrega esta línea para depurar

  data.forEach(trabajador => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><img src="${trabajador.imagen ? `../A-IMG/imgUsers/${trabajador.imagen}` : '../A-IMG/user.png'}" class="user"></td>
      <td style="font-size:20px;font-weight: bold;">${trabajador.nombre_completo}</td>
      <td><div style="background-color: ${trabajador.color}; color: White; font-size:35px; border-radius: 10px; font-weight: bold;">${trabajador.porcentaje_ingresos_por_hora}%</div></td>
    `;
    desempenoBody.appendChild(row);
  });
}


   
    // Función que redirige a otra página después de 5 minutos
    function redirigirTrasCincoMinutos() {
      setTimeout(function () {
        window.location.href = './DesempeñoHora.php'; // Cambiar a la ruta deseada
      }, 600000); // 300000 milisegundos = 5 minutos
    }
  };
</script>
 <!-- Boton iniciar-->
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Recupera el estado del botón desde el archivo PHP
        fetch("../PHP/GetButtonState.php")
            .then(response => response.json())
            .then(data => {
                const isRunning = data;
                const button = document.getElementById('startStopButton');
    
                // Ajusta la apariencia del botón según el estado recuperado
                if (isRunning) {
                    button.textContent = 'FINALIZAR';
                    button.classList.add('finished');
                } else {
                    button.textContent = 'INICIAR';
                    button.classList.remove('finished');
                }
            })
            .catch(error => console.error('Error al recuperar el estado del botón:', error));
    });
    
    function toggleStartStop() {
        const button = document.getElementById('startStopButton');
    
        // Determina el nuevo estado del botón
        const isRunning = button.textContent === 'INICIAR';
    
        // Muestra la alerta apropiada y realiza el cambio de estado
        Swal.fire({
            icon: 'success',
            title: isRunning ? 'Actividades iniciadas' : 'Actividades finalizadas',
            html: `
                <video width="320" height="240" class="video-with-animation" autoplay loop>
                    <source src="../VIDEO/${isRunning ? 'Iniciar.mp4' : 'Finalizar.mp4'}" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
                <p>${isRunning ? 'Ejecuta el complemento y no lo cierre' : 'Cierra la ventana del complemento'}</p>
            `,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            // Envía la solicitud AJAX para actualizar el estado del botón
            fetch("../PHP/InsertBotonActividades.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `accion=${isRunning ? 'INICIO' : 'FIN'}`
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Error al actualizar el estado del botón');
                }
                return response.text();
            }).then(() => {
                // Envía la solicitud AJAX para insertar en la tabla rendimiento
                return fetch("../PHP/InsertInicio.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `isRunning=${isRunning}`
                });
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Error al insertar en la tabla rendimiento');
                }
                return response.text();
            }).then(() => {
                // Actualiza la interfaz del botón
                button.textContent = isRunning ? 'FINALIZAR' : 'INICIAR';
                button.classList.toggle('finished', isRunning);
            }).catch(error => console.error('Error:', error));
        });
    }
    </script>
      <!-- Reloj dinámico con redirección -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Crear el elemento para mostrar el reloj
    const clockElement = document.createElement('div');
    clockElement.id = 'clock';
    clockElement.classList.add('clock');
    // Añadir el elemento al cuerpo del documento
    document.body.appendChild(clockElement);

    // Actualizar el reloj cada segundo
    setInterval(function () {
      // Obtener la hora actual usando moment.js
      const currentTime = moment().format('HH:mm:ss');
      // Mostrar la hora actual en el elemento del reloj
      clockElement.textContent = currentTime;
    }, 1000); // Actualizar cada segundo

    // Añadir evento de clic para redirigir a una página específica
    clockElement.addEventListener('click', function () {
      // Redirigir a la página deseada
      window.location.href = './DesempeñoHora.php'; // Cambia la ruta a la que necesites
    });
  });
</script>
<script src="../SCRIPTS/ScriptView.js"></script>
  <script src="../SCRIPTS/jquery-3.7.1.min.js"></script>
  <script src="../SCRIPTS/bootstrap.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table-es-MX.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


</body>
</html>
