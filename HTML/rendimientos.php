<?php

include '../PHP/Usuarios/check_access.php';
checkAccess([1, 2]);


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rendimientos</title>
  <link rel="icon" href="../A-IMG/logo_prueba.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../CSS/bootstrap-table.min.css">
  <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Incluye SweetAlert desde CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
  <link rel="stylesheet" href="../CSS/stykesRendi.css">

  <style>
    .alerta {
      position: fixed;
      bottom: 10px;
      left: 10px;
      background-color: orange;
      color: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      font-weight: bold;
      display: none;
      /* Inicialmente oculto */
      animation: parpadeo 1s infinite;
      /* Efecto de parpadeo */
    }

    .alerta-icon {
      font-size: 1.5em;
      margin-right: 10px;
    }

    .alerta-mensaje {
      font-size: 1em;
    }

    @keyframes parpadeo {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0.5;
      }

      100% {
        opacity: 1;
      }
    }

    #infoDiv {
      position: absolute;
      top: 3%;
      left: 20%;
      padding: 10px;
      text-align: center;
      font-size: 2cap;
      z-index: 1000;
      /* Asegura que el div esté por encima de otros elementos */
      opacity: 0.7;
      font-weight: bold;
      /* Añade grosor al texto */
    }

    /* Estilos para los íconos de cambio de modo y eliminación */
    .icon-button {
      color: #12ca1b;
      margin-right: 15px;
      font-size: 17px;
      text-decoration: none;
    }

    .icon-button:hover {
      color: #74d681;
    }
  </style>
</head>

<body>
  <div id="alertaDiv" class="alerta">
    <span class="alerta-icon">⚠️</span>
    <span class="alerta-mensaje">No olvidarse de activar la herramienta del escritorio</span>
  </div>


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

  <div class="container">
    <h1>Rendimientos</h1>
    <div class="form-container">
      <form id="insert-form" method="post" action="../PHP/rendimientos.php">
        <div class="form-group">
          <label for="search-cedula">Número de Cédula:</label>
          <div style="display: flex; align-items: center;">
            <input type="text" id="search-cedula" name="search-cedula" minlength="10" maxlength="10" autofocus>
            <span id="nombre-persona" style="color: red; margin-left: 10px;"></span>
          </div>
          <span id="cedula-help" style="color: red;"></span>
        </div>

        <div class="form-group">
          <label for="search-producto">Código Producto:</label>
          <div style="display: flex; align-items: center;">
            <input type="text" id="search-producto" name="search-producto" class="form-control" maxlength="5" style="width: 100px;">
            <span id="nombre-producto" style="color: green; margin-left: 10px;"></span>
          </div>
          <span id="codigo-producto-help" style="color: red;"></span>
        </div>

        <div class="">
          <label for="insert-cantidad">Cantidad Producto:</label><br>
          <input type="number" id="insert-cantidad" name="insert-cantidad" class="form-control" min="1" max="99" value="1">
        </div>
        <button type="submit" class="manual-submit" id="manual-submit">Guardar</button>
      </form>

      <div class="delete-container">
        <a href="./rendimientos_auto.php" class="icon-button" data-toggle="tooltip" data-placement="top"
          title="Cambiar a modo automatico">
          <i class="fas fa-sync-alt"></i>
        </a>
        <a href="./eliminar_rendimientos.php" class="delete-button" data-toggle="tooltip" data-placement="top"
          title="Eliminar rendimientos">
          <i class="fas fa-trash"></i>
        </a>

      </div>

    </div>
  </div>

  <div class="table-container">
    <h2>Tabla de Rendimientos</h2>
    <table id="rendimientos-table" data-height="600" data-toggle="trabajadores-table" data-toolbar=".toolbar"
      class="table table-striped table-sm">
      <thead>
        <tr>
          <th>ID Prod.</th>
          <th>Cantidad</th>
          <th>Producto</th>
          <th>Nombre Trabajador</th>
          <th>Apellido Trabajador</th>
          <th>Fecha</th>
          <th>Hora</th>
        </tr>
      </thead>
      <tbody id="table-body">
        <!-- Aquí se llenará la tabla con los datos -->
      </tbody>
    </table>
    <button id="exportar-btn">Exportar a Excel</button>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
  <script src="../SCRIPTS/jquery-3.7.1.min.js"></script>
  <script src="../SCRIPTS/bootstrap.bundle.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table-es-MX.min.js"></script>
  <script>
  // **1. VARIABLES GLOBALES**
  const cedulaInput = document.getElementById('search-cedula');
  const productoInput = document.getElementById('search-producto');
  const cantidadInput = document.getElementById('insert-cantidad');
  const form = document.getElementById('insert-form');
  const exportarBtn = document.getElementById('exportar-btn');
  const tableBody = document.getElementById('table-body');
  const alertaDiv = document.getElementById('alertaDiv');
  const infoDiv = document.getElementById('infoDiv');

  // **2. FUNCIONES DE LOCALSTORAGE**
  function guardarEnLocalStorage(clave, valor) {
    localStorage.setItem(clave, valor);
  }

  function cargarDesdeLocalStorage(clave) {
    return localStorage.getItem(clave);
  }

  function eliminarDeLocalStorage(clave) {
    localStorage.removeItem(clave);
  }

  // **3. FUNCIONES DE VALIDACIÓN**
  async function validarCedula() {
    const cedulaValue = cedulaInput.value.trim();
    const cedulaHelp = document.getElementById('cedula-help');
    if (cedulaValue.length === 10) {
      try {
        const response = await $.post('../PHP/NoConsultas/verificar_cedula.php', { cedula: cedulaValue });
        if (response.trim() === 'existe') {
          cedulaHelp.textContent = '';
          const nombre = await obtenerNombrePersona(cedulaValue);
          document.getElementById('nombre-persona').textContent = nombre;
         
        } else {
          
        }
      } catch (error) {
        console.error('Error en la validación de la cédula:', error);
        mostrarErrorSwal('Error en la Validación de la Cédula');
        return false;
      }
    } else {
      cedulaHelp.textContent = '';
      return false;
    }
  }

  async function validarCodigoProducto() {
    const codigoProductoValue = productoInput.value.trim();
    const codigoProductoHelp = document.getElementById('codigo-producto-help');
    if (codigoProductoValue.length === 5) {
      try {
        const response = await $.post('../PHP/NoConsultas/verificar_codigo_producto.php', { codigoProducto: codigoProductoValue });
        if (response.trim() === 'existe') {
          codigoProductoHelp.textContent = '';
          const nombre = await obtenerNombreProducto(codigoProductoValue);
          document.getElementById('nombre-producto').textContent = nombre;
         
          return true;
        } else {
          codigoProductoHelp.textContent = 'Producto no encontrado.';
          codigoProductoHelp.style.color = 'red';
          
        }
      } catch (error) {
        console.error('Error en la validación del producto:', error);
        mostrarErrorSwal('Error en la Validación del Producto');
        return false;
      }
    } else {
      codigoProductoHelp.textContent = '';
      return false;
    }
  }

  function manejarValidacionCantidad() {
    let valor = parseInt(cantidadInput.value.trim());
    if (isNaN(valor) || valor <= 0) {
      cantidadInput.value = '';
      Swal.fire({
        icon: 'warning',
        title: 'Cantidad inválida',
        text: 'La cantidad debe ser mayor que 0.',
        confirmButtonText: 'OK',
      });
    } else {
      valor = Math.min(valor, 99); // Limitar máximo a 99
      cantidadInput.value = valor;
      guardarEnLocalStorage('ultimaCantidad', valor); // Guardar en localStorage
    }
  }

  // **4. FUNCIONES DE DATOS REMOTOS**
  async function obtenerNombrePersona(cedula) {
    try {
      const response = await $.post('../PHP/NoConsultas/obtener_nombre_persona.php', { cedula });
      const data = JSON.parse(response);
      return data.nombre || '';
    } catch (error) {
      console.error('Error al obtener el nombre de la persona:', error);
      mostrarErrorSwal('Error en la Obtención del Nombre de la Persona');
      return '';
    }
  }

  async function obtenerNombreProducto(codigoProducto) {
    try {
      const response = await $.post('../PHP/NoConsultas/obtener_nombre_producto.php', { codigoProducto });
      const data = JSON.parse(response);
      return data.nombre || '';
    } catch (error) {
      console.error('Error al obtener el nombre del producto:', error);
      mostrarErrorSwal('Error en la Obtención del Nombre del Producto');
      return '';
    }
  }

  async function obtenerDatos() {
    try {
      const response = await fetch('../PHP/obtener_rendimientos.php');
      const data = await response.json();
      mostrarDatosEnTabla(data);
    } catch (error) {
      console.error('Error al obtener los datos:', error);
      mostrarErrorSwal('Error al Obtener Datos');
    }
  }

  async function obtenerDatosRango() {
    try {
      const response = await fetch('../PHP/view_rango.php');
      const data = await response.json();
      if (infoDiv) {
        infoDiv.innerHTML = `Rango Actual: ${data.hora_inicio}-${data.hora_fin}`;
      }
    } catch (error) {
      console.error('Error al obtener el rango horario:', error);
    }
  }

  // **5. FUNCIONES DE INTERFAZ**
  function mostrarDatosEnTabla(data) {
    tableBody.innerHTML = '';
    data.forEach(rendimiento => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${rendimiento.id_rendimiento}</td>
        <td>${rendimiento.cantidad_vendida}</td>
        <td>${rendimiento.nombre_producto}</td>
        <td>${rendimiento.nombre_trabajador}</td>
        <td>${rendimiento.apellido_trabajador}</td>
        <td>${rendimiento.fecha_registro}</td>
        <td>${rendimiento.hora_registro}</td>
      `;
      if (rendimiento.color_code) {
        row.style.backgroundColor = rendimiento.color_code;
      }
      tableBody.appendChild(row);
    });
  }

  function exportarExcel() {
    const ws = XLSX.utils.table_to_sheet(document.getElementById('rendimientos-table'));
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Rendimientos');
    XLSX.writeFile(wb, 'RendimientosHora.xlsx');
  }

  function mostrarErrorSwal(mensaje) {
    Swal.fire({
      icon: 'error',
      title: mensaje,
      confirmButtonText: 'OK',
    });
  }

  // **6. INICIALIZACIÓN**
  document.addEventListener('DOMContentLoaded', function () {
    // Restaurar cantidad desde localStorage
    const ultimaCantidad = cargarDesdeLocalStorage('ultimaCantidad');
    if (ultimaCantidad !== null) {
      cantidadInput.value = ultimaCantidad;
    }

    // Listeners de validación
    cedulaInput.addEventListener('input', validarCedula);
    productoInput.addEventListener('input', validarCodigoProducto);
    cantidadInput.addEventListener('input', manejarValidacionCantidad);

    // Envío del formulario
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      if (
        cedulaInput.value.trim() &&
        productoInput.value.trim() &&
        cantidadInput.value.trim()
      ) {
        form.submit();
      } else {
        mostrarErrorSwal('Por favor, completa todos los campos antes de guardar.');
      }
    });

    // Exportar a Excel
    exportarBtn.addEventListener('click', exportarExcel);

    // Obtener datos iniciales y configurar intervalos
    obtenerDatos();
    setInterval(obtenerDatos, 1000);
    obtenerDatosRango();
    setInterval(obtenerDatosRango, 1000);

    // Manejar parámetros de URL para mostrar alertas
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    const errorParam = urlParams.get('error');

    if (successParam !== null) {
      if (successParam === 'true') {
        Swal.fire({
          title: 'Inserción Exitosa',
          text: 'Los datos se han insertado correctamente.',
          icon: 'success',
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          window.location.href = 'rendimientos.php';
        });
      } else if (successParam === 'false') {
        let errorMessage = 'Hubo un problema al insertar los datos.';
        if (errorParam === 'consulta_trabajador') {
          errorMessage = 'Error en la consulta del trabajador.';
        } else if (errorParam === 'no_trabajador') {
          errorMessage = 'No se encontró el trabajador.';
        } else if (errorParam === 'consulta_rango') {
          errorMessage = 'Error en la consulta del rango de horas.';
        } else if (errorParam === 'no_registro') {
          errorMessage = 'No se han definido rangos el día de hoy.';
        } else if (errorParam === 'insert_fallido') {
          errorMessage = 'Error al insertar el rendimiento.';
        }
        Swal.fire({
          title: 'Error en la Inserción',
          text: errorMessage,
          icon: 'error',
          confirmButtonText: 'OK',
        }).then(() => {
          window.location.href = 'rendimientos.php';
        });
      }
    }
  });
</script>

</body>

</html>