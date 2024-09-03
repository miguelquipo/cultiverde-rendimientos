<?php
include '../PHP/Usuarios/check_access.php';

// Asegura que solo los usuarios con role_id 2 (editor) o 1 (admin) puedan acceder
checkAccess([1, 2]);

// Código para mostrar la página
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eliminar Rendimientos por Formulario</title>
  <link rel="stylesheet" href="../CSS/stykesRendi.css">
  <link rel="icon" href="../A-IMG/logo_prueba.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Incluye SweetAlert desde CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
    <a href="./rendimientos.php" class="return-button">
      <i class="fas fa-arrow-left"></i>        
    </a>
  </div>

  <div class="container">
    <h1>Eliminar Rendimientos por Formulario</h1>
    <form id="eliminar-form" action="../PHP/eliminar_rendimientos.php" method="post">
      <div class="form-group">
        <label for="numero-cedula">Número de Cédula:</label>
        <input type="text" id="numero-cedula" name="numero-cedula" minlength="10" maxlength="10" required>
      </div>
      <div class="form-group">
        <label for="id-producto">ID Producto:</label>
        <input type="text" id="id-producto" name="id-producto" required>
      </div>
      <div class="form-group">
        <label for="cantidad">Cantidad a Eliminar:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required>
      </div>
      <button type="submit" class="btn btn-danger">Eliminar Rendimientos</button>
    </form>
  </div>

  <script src="../SCRIPTS/jquery-3.7.1.min.js"></script>
  <script src="../SCRIPTS/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('eliminar-form');

      form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío por defecto del formulario
        const idProducto = document.getElementById('id-producto').value.trim();
        const numeroCedula = document.getElementById('numero-cedula').value.trim();
        const cantidad = document.getElementById('cantidad').value.trim();

        if (idProducto !== '' && numeroCedula !== '' && cantidad !== '') {
          confirmarEliminacion(idProducto, numeroCedula, cantidad);
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor completa todos los campos.',
            confirmButtonText: 'OK'
          });
        }
      });

      function confirmarEliminacion(idProducto, numeroCedula, cantidad) {
        Swal.fire({
          title: 'Eliminar Rendimientos',
          text: `¿Estás seguro de eliminar los últimos ${cantidad} rendimientos del producto con ID ${idProducto} para el trabajador con número de cédula ${numeroCedula}?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit(); // Enviar el formulario si se confirma la eliminación
          }
        });
      }
    });
  </script>
</body>
</html>
