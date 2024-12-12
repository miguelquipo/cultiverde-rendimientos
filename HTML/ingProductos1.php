<?php
include '../PHP/Usuarios/check_access.php';

// Asegura que solo los usuarios con role_id 2 (editor) o 1 (admin) puedan acceder
checkAccess([1]);

// Código para mostrar la página
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV - Ingreso y Actualización de Productos</title><!--
  <link rel="stylesheet" href="../CSS/stylesInsertPrd.css">-->
  <link rel="icon" href="../A-IMG/logo_prueba.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../CSS/bootstrap-table.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      height: 100vh;
      overflow: auto;
    }

    /* Estilos para el contenedor de la tabla */
    .table-container {
      max-width: 1150px;
      margin: 0 auto;
      margin-top: 40px;
      /* Ajusta el espacio desde la parte superior */
      padding: 20px;
      /* Agregar espacio interno al contenedor */
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para la tabla de rendimientos */
    #productos-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #productos-table th,
    #productos-table td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }

    #productos-table th {
      background-color: #f2f2f2;
    }

    #productos-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }


    /*Return Buttom*/
    .return-container {
      position: absolute;
      top: 10px;
      left: 30px;
    }

    .return-button {
      display: block;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background-color: rgb(255, 255, 255);
      /* Color de fondo semi-transparente */
      padding: 20px;
      border-radius: 10px;
      font-size: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      /* Eliminar subrayado */
      color: rgb(51, 56, 210);
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .return-button i {
      font-size: 30px;
      /* Reducir tamaño del icono */
      margin-bottom: 10px;
    }

    .return-button:hover {
      background-color: rgba(107, 136, 131, 0.7);
      /* Color de fondo semi-transparente al hacer hover */
      transform: scale(1.05);
      /* Aumentar tamaño al hacer hover */
      box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    }

    .return-button:hover span {
      backdrop-filter: none;
      filter: none;
    }

    button {
      padding: 8px 16px;
      font-size: 16px;
      background-color: rgba(54, 113, 103, 0.7);
      border-radius: 8px;
      cursor: pointer;
    }

    button:hover {
      background-color: rgba(107, 136, 131, 0.7);
    }

    .logo {
      position: absolute;
      top: 20px;
      right: 100px;
      width: 150px;
      /* Ajusta el ancho según tu logo */
      height: auto;
      /* Para mantener la proporción */
    }

    h1 {
      text-align: center;
      margin-top: 20px;
    }

    .container {
      margin-top: 100px;
      /* Ajusta el espacio desde la parte superior */
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 20px 20px rgba(0, 0, 0, 0.1);
      max-width: 1150px;
    }

    .logout-button {
      position: fixed;
      bottom: 70px;
      /* Ajusta la distancia desde la parte inferior */
      right: 20px;
      /* Ajusta la distancia desde la parte derecha */
      background-color: #f0f0f0;
      border: none;
      border-radius: 50%;
      padding: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      font-size: 24px;
      color: #333;
      z-index: 9999;
      /* Asegúrate de que el botón esté sobre otros elementos */
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

    @media only screen and (max-width: 1600px) {
      .logo {
        display: none;
      }
    }
  </style>
</head>

<body>
  <img src="../A-IMG/logo_prueba.png" alt="Logo de la empresa" class="logo">
  <button class="logout-button" onclick="window.location.href='/cultiverde-rendimientos/PHP/Usuarios/logout.php';">
    <i class="fas fa-door-open"></i>
  </button>
  <div class="menu">
    <!-- Resto de los botones aquí -->
  </div>
  <div class="return-container">
    <a href="../index.php" class="return-button">
      <i class="fas fa-arrow-left"></i>
    </a>
  </div>

  <div class="container">
    <h1>Ingreso y Actualización de Productos</h1>
    <form id="crud-form" method="post" action="../PHP/ingresoProd.php">
      <input type="hidden" id="product-id" name="product-id" value="">

      <div class="form-group">
        <label for="cliente">Cliente</label>
        <input type="text" id="cliente" name="cliente" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="product-name">Nombre del Producto</label>
        <input type="text" id="product-name" name="product-name" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="product-rendimiento-hora">Rendimiento Hora</label>
        <input type="text" id="product-rendimiento-hora" name="product-rendimiento-hora" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="valor-en-tallos">Valor en Tallos</label>
        <input type="text" id="valor-en-tallos" name="valor-en-tallos" class="form-control" required>
      </div>

      <button type="submit">Guardar Producto</button>
    </form>
  </div>

  <div class="table-container">
    <h2>Cultiverde Productos</h2>
    <table id="productos-table" data-height="600" data-toggle="productos-table" data-toolbar=".toolbar"
      class="table table-striped table-sm">
      <thead>
        <tr>
          <th>ID</th>
          <th data-searchable="true">Cliente</th>
          <th data-searchable="true">Nombre Producto</th>
          <th data-searchable="true">Rendimiento Hora</th>
          <th data-searchable="true">Valor en Tallos</th>
          <th>Acciones</th>
        </tr>
      </thead>

      <tbody id="table-body">
        <!-- Aquí se llenará la tabla con los datos -->
      </tbody>
    </table>
    <button id="exportar-btn">Exportar a Excel</button>
  </div>

  <script src="../SCRIPTS/jquery-3.7.1.min.js"></script>
  <script src="../SCRIPTS/bootstrap.bundle.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table.js"></script>
  <script src="../SCRIPTS/bootstrap-table-es-MX.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script>
    $(document).ready(function () {
      $.ajax({
        url: '../PHP/obtener_clientes.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          $("#cliente").autocomplete({
            source: data
          });
        },
        error: function (xhr, status, error) {
          console.error('Error al obtener los nombres de clientes:', error);
        }
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      obtenerDatos();

      const exportarBtn = document.getElementById('exportar-btn');
      exportarBtn.addEventListener('click', function () {
        exportarExcel('table-body');
      });
    });

    function obtenerDatos() {
      fetch('../PHP/obtener_productos.php')
        .then(response => response.json())
        .then(data => {
          mostrarDatosEnTabla(data);
          inicializarTabla();
        })
        .catch(error => {
          console.error('Error al obtener los datos:', error);
        });
    }

    function mostrarDatosEnTabla(data) {
      const tableBody = document.getElementById('table-body');
      tableBody.innerHTML = '';

      data.forEach(producto => {
        const row = document.createElement('tr');
        row.innerHTML = `
      <td>${producto.id_producto}</td>
      <td id="cliente-${producto.id_producto}">${producto.cliente}</td>
      <td id="nombre-producto-${producto.id_producto}">${producto.nombre_producto}</td>
      <td id="rendimiento-producto-hora-${producto.id_producto}">${producto.rendimiento_producto_hora}</td>
      <td id="valor-en-tallos-${producto.id_producto}">${producto.valor_en_tallos}</td>
      <td>
        <div class="container-fluid btn-group" role="group">
          <button class="btn btn-success" onclick="redirigirFormulario('${producto.id_producto}')">
            <i class="fa-solid fa-arrows-rotate"></i>
          </button>
          <button class="btn btn-danger" onclick="eliminarProducto('${producto.id_producto}')">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </td>
    `;
        tableBody.appendChild(row);
      });
    }

    function redirigirFormulario(id_producto) {
      const cliente = document.getElementById(`cliente-${id_producto}`).innerText;
      const nombre_producto = document.getElementById(`nombre-producto-${id_producto}`).innerText;
      const rendimiento_producto_hora = document.getElementById(`rendimiento-producto-hora-${id_producto}`).innerText;
      const valor_en_tallos = document.getElementById(`valor-en-tallos-${id_producto}`).innerText;

      document.getElementById('product-id').value = id_producto;
      document.getElementById('cliente').value = cliente;
      document.getElementById('product-name').value = nombre_producto;
      document.getElementById('product-rendimiento-hora').value = rendimiento_producto_hora;
      document.getElementById('valor-en-tallos').value = valor_en_tallos;

      $('#crud-form-modal').modal('show');

      return false;
    }

    function inicializarTabla() {
      $('#productos-table').bootstrapTable({
        search: true,
        columns: [{
          field: 'id_producto',
          title: 'ID'
        }, {
          field: 'cliente',
          title: 'Nombre Cliente'
        }, {
          field: 'nombre_producto',
          title: 'Nombre Producto'
        }, {
          field: 'rendimiento_producto_hora',
          title: 'Rendimiento Hora'
        }, {
          field: 'valor_en_tallos',
          title: 'Producto Hora'
        }]
      });
    }

    function exportarExcel() {
      const ws = XLSX.utils.table_to_sheet(document.getElementById('productos-table'));
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Productos');
      XLSX.writeFile(wb, 'Productos.xlsx');
    }

    function eliminarProducto(id_producto) {
      const nombre_producto = document.getElementById(`nombre-producto-${id_producto}`).innerText;

      Swal.fire({
        title: '¿Estás seguro?',
        text: `Estás a punto de eliminar el producto: ${nombre_producto}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`../PHP/eliminar_producto.php?id=${id_producto}`, {
            method: 'GET'
          })
            .then(response => response.text())
            .then(result => {
              if (result === 'success') {
                Swal.fire(
                  'Eliminado!',
                  `El producto ${nombre_producto} ha sido eliminado.`,
                  'success'
                );
                obtenerDatos();
              } else {
                Swal.fire(
                  'Error!',
                  `Hubo un error al eliminar el producto: ${nombre_producto}. ${result}`,
                  'error'
                );
              }
            })
            .catch(error => {
              Swal.fire(
                'Error!',
                `Hubo un error al eliminar el producto: ${nombre_producto}.`,
                'error'
              );
              console.error('Error al eliminar el producto:', error);
            });
        }
      });
    }
  </script>
</body>

</html>