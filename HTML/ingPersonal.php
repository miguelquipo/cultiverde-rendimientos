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
  <title>CV - Ingreso de Personal</title>
  <link rel="icon" href="../A-IMG/logo_prueba.png">
  <link rel="stylesheet" href="../CSS/stylesIngTrab.css">
  <!-- Incluye Font Awesome -->
  <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="../CSS/bootstrap-table.min.css">
  <link rel="stylesheet" href="../CSS/bootstrap.min.css">
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
  </div>

  <main>
    <div class="container">
      <h1>Cultiverde Personal</h1>
      <form id="personal-form" action="../PHP/insercionTrab.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
        <div class="form-group">
          <label for="nombre">Nombre:</label><br>
          <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
        </div>
        <div class="form-group">
          <label for="apellido">Apellido:</label><br>
          <input type="text" id="apellido" name="apellido" placeholder="Ingrese su apellido" required>
        </div>
        <div class="form-group">
          <label for="cedula">Cédula:</label><br>
          <input type="text" id="cedula" name="cedula" minlength="10" maxlength="10" placeholder="Ingrese su número de cédula" required>
          <small id="cedulaHelp" style="color: red;"></small>
        </div>
        <div class="form-group">
          <!-- Utiliza el label para activar el campo de entrada de archivos al hacer clic en el icono -->
          <label for="imagen" class="label-file">
            <i class="fas fa-upload"></i> Seleccionar Imagen
          </label>
          <input type="file" id="imagen" name="imagen" accept="image/*">
        </div>
      
        <button type="submit">Guardar</button>
      </form>
    </div>
  </main>

  <div class="table-container">
    <h2>Personal</h2>
    <table id="trabajadores-table"
    data-height="600"
    data-toggle="trabajadores-table"
    data-toolbar=".toolbar"
    class="table table-striped table-sm">
      <thead>
        <tr>
          <th>ID</th>
          <th data-searchable="true">Nombre</th>
          <th data-searchable="true">Apellido</th>
          <th data-searchable="true">Cédula</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="table-body">
        <!-- Aquí se llenará la tabla con los datos -->
    </tbody>
    </table>
    <div id="exportar-personal-container">
      <button id="exportar-personal-btn">Exportar a Excel</button>
  </div>
  </div>

  <script src="../SCRIPTS/jquery-3.7.1.min.js"></script>
  <script src="../SCRIPTS/bootstrap.bundle.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table.min.js"></script>
  <script src="../SCRIPTS/bootstrap-table.js"></script>
  <script src="../SCRIPTS/bootstrap-table-es-MX.min.js"></script>
  <script>
  function validarFormulario() {
    var cedulaInput = document.getElementById('cedula');
    var cedulaHelp = document.getElementById('cedulaHelp');
    var cedulaValue = cedulaInput.value;

    if (cedulaValue.length !== 10 || isNaN(cedulaValue)) {
      cedulaHelp.textContent = 'La cédula debe tener 10 dígitos numéricos.';
      return false;
    } else {
      cedulaHelp.textContent = '';
      return true;
    }
  }
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Obtener datos iniciales
    obtenerDatosPersonal();

    // Agregar evento al botón de exportación
    const exportarPersonalBtn = document.getElementById('exportar-personal-btn');
    exportarPersonalBtn.addEventListener('click', function () {
        exportarExcel('table-body');
    });

});

function obtenerDatosPersonal() {
    let url = '../PHP/obtener_personal.php';
    fetch(url)
        .then(response => response.json())
        .then(data => {
            mostrarDatosPersonalEnTabla(data);
            inicializarTabla();
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
        });
}

function mostrarDatosPersonalEnTabla(data) {
      const tableBody = document.getElementById('table-body');

      // Limpiamos cualquier contenido previo en la tabla
      tableBody.innerHTML = '';

      // Iteramos sobre los datos y creamos las filas de la tabla
      data.forEach(trabajador => {
        const row = document.createElement('tr');
        row.innerHTML = `
        <td>${trabajador.id_trabajador}</td>
            <td id="nombre-${trabajador.id_trabajador}">${trabajador.nombre}</td>
            <td id="apellido-${trabajador.id_trabajador}">${trabajador.apellido}</td>
            <td id="cedula-${trabajador.id_trabajador}">${trabajador.cedula}</td>
            <td>
                <div class="container-fluid btn-group" role="group">
                    <button class="btn btn-success" onclick="redirigirFormulario('${trabajador.id_trabajador}')">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </button>
              <button class="btn btn-primary" onclick="cambiarEstadoVisibilidad('${trabajador.id_trabajador}')">
                <i class="fa-regular fa-eye" id="icon-${trabajador.id_trabajador}"></i>
              </button>
            </div>
          </td>
        `;
        tableBody.appendChild(row);
      });
    }

    function cambiarEstadoVisibilidad(id_trabajador) {
      // Realiza una solicitud POST al servidor para cambiar el estado de visibilidad del trabajador
      fetch('../PHP/NoConsultas/actualizar_estado_visibilidad.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_trabajador: id_trabajador })
      })
      .then(response => {
        if (response.ok) {
          // Cambia el icono del ojo
          const icon = document.getElementById(`icon-${id_trabajador}`);
          icon.classList.toggle('fa-eye');
          icon.classList.toggle('fa-eye-slash');
        } else {
          throw new Error('No se pudo actualizar el estado de visibilidad del trabajador.');
        }
      })
      .catch(error => {
        console.error('Error al cambiar el estado de visibilidad:', error);
        // Muestra un mensaje de error al usuario
      });
    }


function redirigirFormulario(id_trabajador) {
    // Obtener los datos del trabajador
    const nombre = document.getElementById(`nombre-${id_trabajador}`).innerText;
    const apellido = document.getElementById(`apellido-${id_trabajador}`).innerText;
    const cedula = document.getElementById(`cedula-${id_trabajador}`).innerText;

    // Establecer los valores en los campos del formulario
    document.getElementById('nombre').value = nombre;
    document.getElementById('apellido').value = apellido;
    document.getElementById('cedula').value = cedula;

    // Mostrar el formulario modal
    $('#personal-form-modal').modal('show');

    // Evitar la actualización automática de la página
    return false;
}




function toggleIcon(button) {
    var icon = button.querySelector('.fa-regular');
    // Verifica si la clase actual del icono es fa-eye
    if (icon.classList.contains('fa-eye')) {
        // Si lo es, cambia la clase a fa-eye-slash
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        // Si no, cambia la clase a fa-eye
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function inicializarTabla() {
    $('#trabajadores-table').bootstrapTable({
        search: true, // Habilitar la función de búsqueda
        columns: [{
            field: 'id_producto',
            title: 'ID'
        }, {
            field: 'nombre',
            title: 'Nombre'
        }, {
            field: 'apellido',
            title: 'Apellido'
        }, {
            field: 'cedula',
            title: 'Cédula'
        }]
    });
}
// Función para exportar la tabla a Excel
function exportarExcel(tableId) {
    const ws = XLSX.utils.table_to_sheet(document.getElementById(tableId));
    // Guardar el archivo
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Personal');
    XLSX.writeFile(wb, 'DatosPersonal.xlsx');
}
</script>

</body>
</html>
