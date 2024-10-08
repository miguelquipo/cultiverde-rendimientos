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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Añade tus estilos personalizados aquí */
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

    <div class="outer-container">
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th colspan="3" style="text-align: center;">
                <h2 style="color: #05a602; font-weight: bold; font-size: 40px;">Porcentaje General</h2>
              </th>
            </tr>
          </thead>
          <tbody id="desempeno-body">
            <!-- Las filas se agregarán dinámicamente aquí -->
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <footer>
    <div>
      <p>Copyright &copy; CULTIVERDE 2024 Derechos reservados</p>
    </div>
  </footer>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Ejecutar las funciones necesarias cuando la página cargue
      obtenerDatosRango();
      obtenerDatosDesempeno();
      redirigirTrasCincoMinutos();
      mostrarReloj();

      // Actualiza los datos de rango y desempeño cada 5 segundos
      setInterval(async function () {
        await obtenerDatosRango();
      }, 5000);

      setInterval(async function () {
        await obtenerDatosDesempeno();
      }, 5000);

      // Función para obtener los datos de rango desde el servidor
      async function obtenerDatosRango() {
        try {
          let url = '../PHP/view_cantidad_rendogs.php';
          const response = await fetch(url);
          if (!response.ok) {
            throw new Error('Error en la red al obtener datos de rango');
          }
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

      // Función para obtener los datos de desempeño desde el servidor
      async function obtenerDatosDesempeno() {
        try {
          let url = '../PHP/obtener_PorcentajeDia.php';
          const response = await fetch(url);
          if (!response.ok) {
            throw new Error('Error en la red al obtener los datos de desempeño');
          }
          const data = await response.json();
          mostrarDatosDesempeno(data);
        } catch (error) {
          console.error('Error al obtener los datos de desempeño:', error);
        }
      }

      // Función para mostrar los datos de desempeño
      function mostrarDatosDesempeno(data) {
        const desempenoBody = document.getElementById('desempeno-body');
        if (desempenoBody) {
          desempenoBody.innerHTML = ''; // Limpiar el contenido actual

          data.forEach(trabajador => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td><img src="${trabajador.imagen ? `../A-IMG/imgUsers/${trabajador.imagen}` : '../A-IMG/user.png'}" class="user"></td>
              <td style="font-size:20px;font-weight: bold;">${trabajador.nombre_completo}</td>
              <td><div style="background-color: ${trabajador.color}; color: White; font-size:35px; border-radius: 10px; font-weight: bold;">${trabajador.porcentaje_ingresos_por_hora}%</div></td>
            `;
            desempenoBody.appendChild(row);
          });
        } else {
          console.error('Elemento de cuerpo de desempeño no encontrado');
        }
      }

      // Función que redirige a otra página después de 5 minutos (300000 ms)
      function redirigirTrasCincoMinutos() {
        setTimeout(function () {
          window.location.href = './DesempeñoHora.php'; // Cambiar a la ruta deseada
        }, 300000); // 5 minutos
      }

      // Función para mostrar el reloj
      function mostrarReloj() {
        const clockElement = document.createElement('div');
        clockElement.id = 'clock';
        clockElement.classList.add('clock');
        document.body.appendChild(clockElement); // Añadir el reloj al DOM

        // Actualizar el reloj cada segundo
        setInterval(function () {
          const currentTime = moment().format('HH:mm:ss'); // Utiliza moment.js para obtener la hora actual
          clockElement.textContent = currentTime; // Mostrar la hora en el div
        }, 1000); // Actualiza cada segundo

        // Evento de clic para redirigir a otra página
        clockElement.addEventListener('click', function () {
          window.location.href = './DesempeñoHora.php'; // Cambiar la ruta según sea necesario
        });
      }
    });

    function toggleStartStop() {
      const button = document.getElementById('startStopButton');
      const isRunning = button.textContent === 'INICIAR'; // Determina el nuevo estado del botón

      // Muestra la alerta apropiada y realiza el cambio de estado
      Swal.fire({
        icon: 'success',
        title: isRunning ? 'Actividades iniciadas' : 'Actividades finalizadas',
        html: `
          <video width="320" height="240" class="video-with-animation" autoplay loop>
            <source src="../VIDEO/${isRunning ? 'Iniciar.mp4' : 'Finalizar.mp4'}" type="video/mp4">
            Tu navegador no soporta el formato de video.
          </video>
        `,
        confirmButtonText: 'Aceptar',
        customClass: {
          popup: 'my-swal-popup'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          button.textContent = isRunning ? 'DETENER' : 'INICIAR';
          button.classList.toggle('running', !isRunning);
          button.classList.toggle('stopped', isRunning);

          // Ejecutar acciones adicionales según el estado del botón
          if (isRunning) {
            // Lógica para cuando el botón está en "INICIAR"
          } else {
            // Lógica para cuando el botón está en "DETENER"
          }
        }
      });
    }

    function showSettingsDropdown() {
      document.querySelector('.settings-dropdown').style.display = 'block';
    }

    function hideSettingsDropdown() {
      document.querySelector('.settings-dropdown').style.display = 'none';
    }

    function toggleNightMode() {
      const isChecked = document.getElementById('nightModeSwitch').checked;
      document.body.classList.toggle('night-mode', isChecked);
    }
  </script>

<script src="../SCRIPTS/ScriptView.js"></script>
  <script src="../SCRIPTS/jquery-3.7.1.min.js"></script>
  <script src="../SCRIPTS/bootstrap.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table-es-MX.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


</body>
</html>
