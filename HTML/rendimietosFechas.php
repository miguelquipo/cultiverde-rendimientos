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
    <title>CV - Rendimientos</title>
    <link rel="stylesheet" href="../CSS/stylesRendiFecha.css">
    <link rel="icon" href="../A-IMG/logo_prueba.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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
<body>

    <img src="../A-IMG/logo_prueba.png" alt="Logo de la empresa" class="logo">
    <button class="logout-button" onclick="window.location.href='/cultiverde-rendimientos/PHP/Usuarios/logout.php';">
        <i class="fas fa-door-open"></i>
    </button>
    <div class="return-container">
      <a href="../index.php" class="return-button"> <!-- Enlace a la página anterior -->
        <i class="fas fa-arrow-left"></i>        
      </a>
    </div>
    <!-- Agregar campos de fecha -->
<div class="container">
  <h1>Rendimientos por Fecha</h1>
  <form id="date-filter-form">
      <label for="start-date">Fecha de inicio:</label>
      <input type="date" id="start-date" name="start-date">
      
      <label for="end-date">Fecha de fin:</label>
      <input type="date" id="end-date" name="end-date">
      
      <button type="submit" id="filter-btn">Filtrar</button>
  </form>
</div>


    <div class="table-container">
        <h2>Tabla de Rendimientos</h2>
        <table id="rendimientos-table" class="rendimientos-table">
            <thead class="thead-dark">
                <tr>
                    <th>ID Prod.</th>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Nombre Trab.</th>
                    <th>Apellido Trab.</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Los datos se llenarán aquí con JavaScript -->
            </tbody>
        </table>
        <button id="exportar-btn">Exportar a Excel</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <!--Buscar e imprimer datos de la base-->
      <script>
      document.addEventListener('DOMContentLoaded', function () {
        obtenerDatos();
      
        // Agregar evento al botón de exportación
        const exportarBtn = document.getElementById('exportar-btn');
        exportarBtn.addEventListener('click', function () {
          exportarExcel();
        });
      });
      
      function obtenerDatos() {
        fetch('../PHP/obtener_rendimientos.php')
          .then(response => response.json())
          .then(data => {
            mostrarDatosEnTabla(data);
          })
          .catch(error => {
            console.error('Error al obtener los datos:', error);
          });
      }
      
      function mostrarDatosEnTabla(data) {
        const tableBody = document.getElementById('table-body');
      
        // Limpiamos cualquier contenido previo en la tabla
        tableBody.innerHTML = '';
      
        // Iteramos sobre los datos y creamos las filas de la tabla
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
          tableBody.appendChild(row);
        });
      }
      // Función para exportar la tabla a Excel
  function exportarExcel() {
    const ws = XLSX.utils.table_to_sheet(document.getElementById('rendimientos-table'));
    // Guardar el archivo
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Rendimientos');
    XLSX.writeFile(wb, 'RendimientosFecha.xlsx');
  }
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
  obtenerDatos();

  const form = document.getElementById('date-filter-form');
  form.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita que se recargue la página al enviar el formulario
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;

    // Envía las fechas al archivo PHP para filtrar los datos
    fetch(`../PHP/filtro_fechaRendi.php?start_date=${startDate}&end_date=${endDate}`)
      .then(response => response.json())
      .then(data => {
        mostrarDatosEnTabla(data);
      })
      .catch(error => {
        console.error('Error al obtener los datos filtrados:', error);
      });
  });
});

    </script>
    
</body>
</html>
