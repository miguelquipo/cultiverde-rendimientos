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
  <link rel="stylesheet" href="../CSS/stylesView.css">
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
  .video-with-animation {
    /* Hace que los bordes del video sean redondos */
    border-radius: 5%;
  }
  .logout-button {
    position: fixed;
    bottom: 70px; /* Ajusta la distancia desde la parte inferior */
    right: 20px;  /* Ajusta la distancia desde la parte derecha */
    background-color: #f0f0f0;
    border: none;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    font-size: 24px;
    color: #333;
    z-index: 9999; /* Asegúrate de que el botón esté sobre otros elementos */
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
    <div id="porcentajeDiv">
      <!-- Porcentaje hora Actual -->
      <p id="porcentajeValor" style="display: inline; margin: 0; cursor: pointer; font-size: 25px;" title="Hora Actual"></p>
      <!-- Guion separador -->
      <span>-</span><br>
      <span>Penul. Hora:</span>
      <!-- Porcentaje hora Antepenúltimo -->
      <p id="porcentajeValorPenultimo" style="display: inline; margin: 0; color: green; cursor: pointer; font-size: 25px"
        title="Penultima Hora"></p>
      <!-- Guion separador -->
      <span>-</span><br>
      <span>Ante. Hora:</span>
      <!-- Porcentaje hora Penúltimo -->
      <p id="porcentajeValorAntepenultimo" style="display: inline; margin: 0; color: red; cursor: pointer; font-size: 25px"
        title="Antepenultima Hora"></p>
    </div>
    <button id="startStopButton" class="start-stop-button" onclick="toggleStartStop()">INICIAR</button>

    <div class="content">
      <div class="level-container desempeno">
        <div class="table-responsive">
          <table id="desempeno-table">
            <thead>
              <tr>
                <p class="desempeno" style="color: #05a602; font-weight: bold; font-size: 40px;">DESEMPEÑO</p>
              </tr>
              <tr>
                <!-- <th data-field="Img" data-sortable="true">Img</th>
            <th data-field="ID" data-sortable="true">Id</th>
            <th data-field="Producto" data-sortable="true">Prod</th>
            <th data-field="Porcentaje" data-sortable="true">Porcentaje</th>-->
              </tr>
            </thead>
            <tbody id="desempeno-body"></tbody>
          </table>
        </div>
      </div>

      <div class="level-container bueno">
        <div class="table-responsive">
          <table id="bueno-table">
            <thead>
              <tr>
                <p class="bueno" style="color: rgb(51, 56, 210); font-weight: bold; font-size: 40px;">BUENO</p>
              </tr>
              <tr>
                <!-- <th data-field="Img" data-sortable="true">Img</th>
            <th data-field="ID" data-sortable="true">Id</th>
            <th data-field="Producto" data-sortable="true">Prod</th>
            <th data-field="Porcentaje" data-sortable="true">Porcentaje</th>-->
              </tr>
            </thead>
            <tbody id="bueno-body"></tbody>
          </table>
        </div>
      </div>

      <div class="level-container observacion">
        <div class="table-responsive">
          <table id="observacion-table">
            <thead>
              <tr>
                <p class="observacion" style="color: #ff2600; font-weight: bold; font-size: 40px;">OBSERVACIÓN</p>
              </tr>
              <tr>
                <!-- <th data-field="Img" data-sortable="true">Img</th>
            <th data-field="ID" data-sortable="true">Id</th>
            <th data-field="Producto" data-sortable="true">Prod</th>
            <th data-field="Porcentaje" data-sortable="true">Porcentaje</th>-->
              </tr>
            </thead>
            <tbody id="observacion-body"></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="settings-container">
      <div class="settings-icon" onmouseover="showSettingsDropdown()" onmouseout="hideSettingsDropdown()">
        <i class="fas fa-cog"></i>
        <div class="settings-dropdown" onmouseover="showSettingsDropdown()" onmouseout="hideSettingsDropdown()">

          <div class="night-mode-switch">
            <label class="switch">
              <input type="checkbox" id="nightModeSwitch" onchange="toggleNightMode()">
              <span class="slider"></span>
            </label>
            <span for="nightModeSwitch">Modo Nocturno</span>
          </div><br>

          <span id="autoSlideStatus">Hora de visualizacion:</span>
          <div class="duration-container">
            <select id="selectRangoHora" class="form-select" onchange="seleccionarOpcion()">
              <!-- Las opciones se generarán dinámicamente aquí -->
            </select>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div>
      <p>Copyright &copy; CULTIVERDE 2024 Derechos reservados</p>
    </div>
  </footer>



  <!-- Mostrar desempeño-->
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      // Obtener datos iniciales
      await obtenerDatosDesempeno();

      // Actualizar los datos cada cierto intervalo (por ejemplo, cada 5 minutos)
      setInterval(async function () {
        await obtenerDatosDesempeno();
      }, 1000); //1000 milisegundos = 1 segundo
    });

    async function obtenerDatosDesempeno() {
      try {
        let url = '../PHP/view_desempeno_hora.php';
        const response = await fetch(url);
        const data = await response.json();
        mostrarDatosDesempeno(data);
      } catch (error) {
        console.error('Error al obtener los datos de bueno:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    function mostrarDatosDesempeno(data) {

      const desempenoBody = document.getElementById('desempeno-body');

      // Limpiamos cualquier contenido previo en el cuerpo de la tabla
      desempenoBody.innerHTML = '';

      // Iteramos sobre los datos y creamos las filas de la tabla
      data.forEach(trabajador => {
        const row = document.createElement('tr');
        row.innerHTML = `
       <td><img src="${trabajador.imgen ? `../A-IMG/imgUsers/${trabajador.imgen}` : '../A-IMG/user.png'}" class="user"></td>
        <td style="font-size:25px;font-weight: bold;">${trabajador.nombre_apellido_alias}</td>
        <td style="font-size:25px;">${trabajador.producto_nombre}</td>
        <td><div style="font-weight: bold;color: White;background-color: #05a602; font-size:35px; border-radius: 10px;">${trabajador.porcentaje_ingresos_por_hora}%</div></td>
    `;
        desempenoBody.appendChild(row);
      });
    }
  </script>
  <!-- Mostrar bueno-->
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      // Obtener datos iniciales
      await obtenerDatosBueno();

      // Actualizar los datos cada cierto intervalo (por ejemplo, cada 5 minutos)
      setInterval(async function () {
        await obtenerDatosBueno();
      }, 1000); //1000 milisegundos = 1 segundo
    });

    async function obtenerDatosBueno() {
      try {
        let url = '../PHP/view_bueno_hora.php';
        const response = await fetch(url);
        const data = await response.json();
        mostrarDatosBueno(data);
      } catch (error) {
        console.error('Error al obtener los datos de bueno:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    function mostrarDatosBueno(data) {

      const buenoBody = document.getElementById('bueno-body');

      // Limpiamos cualquier contenido previo en el cuerpo de la tabla
      buenoBody.innerHTML = '';

      // Iteramos sobre los datos y creamos las filas de la tabla
      data.forEach(trabajador => {
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><img src="${trabajador.imgen ? `../A-IMG/imgUsers/${trabajador.imgen}` : '../A-IMG/user.png'}" class="user"></td>
        <td style="font-size:25px;font-weight: bold;">${trabajador.nombre_apellido_alias}</td>
        <td style="font-size:25px;">${trabajador.producto_nombre}</td>
        <td><div style="background-color: rgb(51, 56, 210); font-weight: bold;color: White;font-size:35px;border-radius: 10px;">${trabajador.porcentaje_ingresos_por_hora}%</div></td>
    `;
        buenoBody.appendChild(row);
      });
    }

  </script>
  <!-- Mostrar observacion-->
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      // Obtener datos iniciales
      await obtenerDatosObservacion();

      // Actualizar los datos cada cierto intervalo (por ejemplo, cada 5 minutos)
      setInterval(async function () {
        await obtenerDatosObservacion();
      }, 1000); // 1000 milisegundos = 1 segundo
    });

    async function obtenerDatosObservacion() {
      try {
        let url = '../PHP/view_observacion_hora.php';
        const response = await fetch(url);
        const data = await response.json();
        mostrarDatosObservacion(data);
      } catch (error) {
        console.error('Error al obtener los datos de observación:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    function mostrarDatosObservacion(data) {

      const observacionBody = document.getElementById('observacion-body');

      // Limpiamos cualquier contenido previo en el cuerpo de la tabla
      observacionBody.innerHTML = '';

      // Iteramos sobre los datos y creamos las filas de la tabla
      data.forEach(trabajador => {
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><img src="${trabajador.imgen ? `../A-IMG/imgUsers/${trabajador.imgen}` : '../A-IMG/user.png'}" class="user"></td>
        <td style="font-size:25px;font-weight: bold;">${trabajador.nombre_apellido_alias}</td>
        <td style="font-size:25px;">${trabajador.producto_nombre}</td>
        <td><div style="background-color: #ff2600;font-weight: bold;font-size:35px; color: White;border-radius: 10px;">${trabajador.porcentaje_ingresos_por_hora}%</div></td>
    `;
        observacionBody.appendChild(row);
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

      /*// Agregar evento de clic al elemento del reloj
      clockElement.addEventListener('click', function () {
        // Redirigir a otro index.html (cambia la URL según tus necesidades)
        window.location.href = 'DesempeñoHora.html';
      });*/

      // Actualizar el reloj cada segundo
      setInterval(function () {
        // Obtener la hora actual usando moment.js
        const currentTime = moment().format('HH:mm:ss');

        // Mostrar la hora actual en el elemento del reloj
        clockElement.textContent = currentTime;
      }, 1000); // Actualizar cada segundo
    });
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
    

  <!--Obtener rango hora-->
  <script>
    window.onload = function () {
      obtenerDatosRango(); // Ejecutar la función al cargar la página

      // Función para obtener los datos de rango cada cierto intervalo
      setInterval(async function () {
        await obtenerDatosRango();
      }, 1000); // Actualizar cada 5 segundos

      // Función para obtener los datos de rango desde el servidor
      async function obtenerDatosRango() {
        try {
          let url = '../PHP/view_rango.php'; // Reemplazar con la ruta correcta al script PHP
          const response = await fetch(url);
          const data = await response.json();
          mostrarDatosRango(data);
        } catch (error) {
          console.error('Error al obtener los datos de rango:', error);
          // Mostrar un mensaje de error al usuario si es necesario
        }
      }

      // Función para mostrar los datos de rango en el elemento infoDiv
      function mostrarDatosRango(data) {
        const infoDiv = document.getElementById('infoDiv');
        if (infoDiv) {
          infoDiv.innerHTML = `Rango: <br>${data.hora_inicio}-${data.hora_fin}`;
        }
      }

    };
  </script>
  <!--Porcentaje hora Atual-->
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      // Obtener datos iniciales
      await obtenerPorcentajeIngresos();

      // Actualizar los datos cada cierto intervalo (por ejemplo, cada 5 segundos)
      setInterval(async function () {
        await obtenerPorcentajeIngresos();
      }, 1000); // 5000 milisegundos = 5 segundos
    });

    async function obtenerPorcentajeIngresos() {
      try {
        let url = '../PHP/view_porcentaje_hora.php'; // Reemplaza con la ruta correcta de tu script PHP
        const response = await fetch(url);
        const data = await response.json();
        mostrarPorcentaje(data);
      } catch (error) {
        console.error('Error al obtener el porcentaje de ingresos:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    function mostrarPorcentaje(data) {
      const porcentajeValor = document.getElementById('porcentajeValor');

      // Verifica si el porcentaje está presente en los datos
      if ('porcentaje_ingresos_por_hora' in data) {
        porcentajeValor.innerHTML = `Ultima Hora: ${data.porcentaje_ingresos_por_hora}%`;
      } else {
        porcentajeValor.textContent = 'Error al obtener el porcentaje';
      }
    }
  </script>
  <!--Porcentaje hora Antepenultimo-->
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      // Obtener datos iniciales
      await obtenerPorcentajeIngresosAntepenultimo();

      // Actualizar los datos cada cierto intervalo (por ejemplo, cada 5 segundos)
      setInterval(async function () {
        await obtenerPorcentajeIngresosAntepenultimo();
      }, 1000); // 5000 milisegundos = 5 segundos
    });

    async function obtenerPorcentajeIngresosAntepenultimo() {
      try {
        let url = '../PHP/VIEWS/Antepenultimo/view_porcentaje_antepenultimo.php'; // Reemplaza con la ruta correcta de tu script PHP
        const response = await fetch(url);
        const data = await response.json();
        mostrarPorcentajeAntepenultimo(data);
      } catch (error) {
        console.error('Error al obtener el porcentaje de ingresos:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    function mostrarPorcentajeAntepenultimo(data) {
      const porcentajeValor = document.getElementById('porcentajeValorAntepenultimo');

      // Verifica si el porcentaje está presente en los datos
      if ('porcentaje_ingresos_por_hora' in data) {
        porcentajeValor.innerHTML = `${data.porcentaje_ingresos_por_hora}%`;
      } else {
        porcentajeValor.textContent = 'Error al obtener el porcentaje';
      }
    }
  </script>
  <!--Porcentaje hora penultimo-->
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      // Obtener datos iniciales
      await obtenerPorcentajeIngresosPenultimo();

      // Actualizar los datos cada cierto intervalo (por ejemplo, cada 5 segundos)
      setInterval(async function () {
        await obtenerPorcentajeIngresosPenultimo();
      }, 1000); // 5000 milisegundos = 5 segundos
    });

    async function obtenerPorcentajeIngresosPenultimo() {
      try {
        let url = '../PHP/VIEWS/Penultimo/view_porcentaje_penultimo.php'; // Reemplaza con la ruta correcta de tu script PHP
        const response = await fetch(url);
        const data = await response.json();
        mostrarPorcentajePenultimo(data);
      } catch (error) {
        console.error('Error al obtener el porcentaje de ingresos:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    function mostrarPorcentajePenultimo(data) {
      const porcentajeValor = document.getElementById('porcentajeValorPenultimo');

      // Verifica si el porcentaje está presente en los datos
      if ('porcentaje_ingresos_por_hora' in data) {
        porcentajeValor.innerHTML = `${data.porcentaje_ingresos_por_hora}%`;
      } else {
        porcentajeValor.textContent = 'Error al obtener el porcentaje';
      }
    }
  </script>
  <!--Rangos-->
  <script>
    // Función para obtener el porcentaje de ingresos según la opción seleccionada
    async function obtenerPorcentajeIngresos() {
      try {
        let url;
        var selectedOption = document.getElementById('selectRangoHora').value;

        if (selectedOption === 'Penúltimo') {
          url = '../PHP/VIEWS/Penultimo/view_porcentaje_penultimo.php';
        } else if (selectedOption === 'Antepenúltimo') {
          url = '../PHP/VIEWS/Antepenultimo/view_porcentaje_antepenultimo.php';
        } else {
          url = '../PHP/view_porcentaje_hora.php';
        }

        const response = await fetch(url);
        const data = await response.json();
        mostrarPorcentaje(data);
      } catch (error) {
        console.error('Error al obtener el porcentaje de ingresos:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    // Función para obtener los datos de desempeño según la opción seleccionada
    async function obtenerDatosDesempeno() {
      try {
        let url;
        var selectedOption = document.getElementById('selectRangoHora').value;

        if (selectedOption === 'Penúltimo') {
          url = '../PHP/VIEWS/Penultimo/view_desempeno_penultimo.php';
        } else if (selectedOption === 'Antepenúltimo') {
          url = '../PHP/VIEWS/Antepenultimo/view_desempeno_antepenultimo.php';
        } else {
          url = '../PHP/view_desempeno_hora.php';
        }

        const response = await fetch(url);
        const data = await response.json();
        mostrarDatosDesempeno(data);
      } catch (error) {
        console.error('Error al obtener los datos de desempeño:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    // Función para obtener los datos de bueno según la opción seleccionada
    async function obtenerDatosBueno() {
      try {
        let url;
        var selectedOption = document.getElementById('selectRangoHora').value;

        if (selectedOption === 'Penúltimo') {
          url = '../PHP/VIEWS/Penultimo/view_bueno_penultimo.php';
        } else if (selectedOption === 'Antepenúltimo') {
          url = '../PHP/VIEWS/Antepenultimo/view_bueno_antepenultimo.php';
        } else {
          url = '../PHP/view_bueno_hora.php';
        }

        const response = await fetch(url);
        const data = await response.json();
        mostrarDatosBueno(data);
      } catch (error) {
        console.error('Error al obtener los datos de bueno:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    // Función para obtener los datos de observación según la opción seleccionada
    async function obtenerDatosObservacion() {
      try {
        let url;
        var selectedOption = document.getElementById('selectRangoHora').value;

        if (selectedOption === 'Penúltimo') {
          url = '../PHP/VIEWS/Penultimo/view_observacion_penultimo.php';
        } else if (selectedOption === 'Antepenúltimo') {
          url = '../PHP/VIEWS/Antepenultimo/view_observacion_antepenultimo.php';
        } else {
          url = '../PHP/view_observacion_hora.php';
        }

        const response = await fetch(url);
        const data = await response.json();
        mostrarDatosObservacion(data);
      } catch (error) {
        console.error('Error al obtener los datos de observación:', error);
        // Puedes mostrar un mensaje de error al usuario aquí
      }
    }

    function seleccionarOpcion() {
      var select = document.getElementById("selectRangoHora");
      var selectedOption = select.options[select.selectedIndex].value;

      // Llamar a las funciones correspondientes según la opción seleccionada
      if (selectedOption === 'Penúltimo' || selectedOption === 'Antepenúltimo') {
        obtenerPorcentajeIngresos();
        obtenerDatosDesempeno();
        obtenerDatosBueno();
        obtenerDatosObservacion();
      } else {
        obtenerPorcentajeIngresos();
        obtenerDatosDesempeno();
        obtenerDatosBueno();
        obtenerDatosObservacion();
      }
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