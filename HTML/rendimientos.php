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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<style>
  body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
	height: 100vh;
  background-color: #f2f2f2;
  overflow: auto; 

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

h1 {
  text-align: center;
  margin-top: 20px;
}

.container {
  display: block;
  margin-top: 100px; /* Ajusta el espacio desde la parte superior */
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  align-items: center;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}




label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"] {
  width: calc(100% - 16px);
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}


input[type="text"],
select,
input[type="date"] {
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  flex: 1;
}
/* Estilos para el contenedor de la tabla */
.table-container {
  max-width: 1150px;
  margin: 0 auto;
  margin-top: 40px; /* Ajusta el espacio desde la parte superior */
  padding: 20px; /* Agregar espacio interno al contenedor */
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Estilos para la tabla de rendimientos */
#rendimientos-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#rendimientos-table th,
#rendimientos-table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}

#rendimientos-table th {
  background-color: #f2f2f2;
}

#rendimientos-table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

/*Return Buttom*/
.return-container {
  position: absolute;
  top: 20px;
  left: 30px;
}

.return-button {
  display:block;
  flex-direction:column;
  align-items: center;
  justify-content: center;
  background-color: rgb(156, 60, 116); /* Color de fondo semi-transparente */
  padding: 20px;
  border-radius: 10px;
  font-size: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none; /* Eliminar subrayado */
  color: rgb(255, 255, 255); 
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

/*Return Buttom*/
.return-container {
  position: absolute;
  top: 10px;
  left: 30px;
}

.return-button {
  display:block;
  flex-direction:column;
  align-items: center;
  justify-content: center;
  background-color: rgb(255, 255, 255); /* Color de fondo semi-transparente */
  padding: 20px;
  border-radius: 10px;
  font-size: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none; /* Eliminar subrayado */
  color: rgb(51, 56, 210); 
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

.return-button i {
  font-size: 30px; /* Reducir tamaño del icono */
  margin-bottom: 10px;
}

.return-button:hover {
  background-color: rgba(107, 136, 131, 0.7); /* Color de fondo semi-transparente al hacer hover */
  transform: scale(1.05); /* Aumentar tamaño al hacer hover */
  box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
}

.return-button:hover span {
  backdrop-filter: none;
  filter: none;
}


a {
  text-decoration: none; /* Elimina el subrayado */
  color: inherit; /* Hereda el color del texto para mantener el estilo original */
}
 #exportar-btn {
  margin-top: 15px;
    padding: 8px 16px;
    font-size: 16px;
    background-color: #538dc6;
    color: #fff;
    border: 1px solid #938c97;
    border-radius: 8px;
    cursor: pointer;
  }

  #exportar-btn:hover {
    background-color: #66ae8c;
  }

  /*estilos switch boton*/
  .switch-container {
    display: flex;
    align-items: center;
    margin-top: 20px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4d7ca3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #58adf3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

#mode-text {
    margin-left: 10px;
}

/*Manual submit*/
#manual-submit {
  display: block;
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

#manual-submit:hover {
  background-color: #0056b3;
}
/* Estilos para dispositivos móviles */
@media (max-width: 768px) {
  .table-container {
    display: none; /* Ocultar la tabla en pantallas pequeñas */
  }
  .container {
    margin: 100px 10px 0px 10px;
  }

  .logo {
    display: none;
  }
  .form-container {
    width: 100%;
    padding: 20px 10px; /* Ajusta el padding del contenedor del formulario */
  }

  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-group label {
    margin-bottom: 5px;
  }

  .form-group input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
  }

  .delete-container {
    top: 5px;
    right: 5px;
  }

  .delete-button {
    font-size: 20px;
  }

  .switch-container {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .switch {
    margin-right: 10px;
  }

  .manual-submit {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
  }

  .manual-submit:hover {
    background-color: #0056b3;
  }
  .return-container {
  left: 10px;
}
}
 /* Estilos para el contenedor del formulario y el botón de eliminar */
 .form-container {
  position: relative;
}

.delete-container {
  position: absolute;
  top: 1%;
  right: 10px;
}

.delete-button {
  background: none;
  border: none;
  cursor: pointer;
  color: #dc3545;
  font-size: 15px;
}

.delete-button:hover {
  color: #c82333;
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
#search-producto {
  width: 100px; /* Ajusta el tamaño del input */
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
}

.form-group > div {
  display: flex;
  align-items: center;
}

#nombre-producto {
  margin-left: 10px;
}

#codigo-producto-help {
  margin-top: 5px;
}

</style>
</head>
<body>
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
          <input type="text" id="search-cedula" name="search-cedula" minlength="10" maxlength="10" autofocus>
          <span id="cedula-help" style="color: red;"></span>
        </div>  
        <div class="form-group">
  <label for="search-producto">Código Producto:</label>
  <div style="display: flex; align-items: center;">
    <input type="text" id="search-producto" name="search-producto" maxlength="5" style="width: 100px;">
    <span id="nombre-producto" style="color: green; margin-left: 10px;"></span>
  </div>
  <span id="codigo-producto-help" style="color: red;"></span>
</div>

        <div class="">
          <label for="insert-cantidad">Cantidad Producto:</label><br>
          <input type="number" id="insert-cantidad" name="insert-cantidad" min="1" max="99" value="1">
        </div>
        <button type="submit" class="manual-submit" id="manual-submit" style="display: none;">Guardar</button>
      </form>
      <div class="delete-container">
        <a href="./eliminar_rendimientos.php" class="delete-button">
          <i class="fas fa-trash"></i>
        </a>
      </div>
    </div>
    <div class="switch-container">
      <label class="switch">
        <input type="checkbox" id="mode-switch">
        <span class="slider"></span>
      </label>
      <span id="mode-text">Modo Manual</span>
    </div>
  </div>

  <div class="table-container">
    <h2>Tabla de Rendimientos</h2>
    <table id="rendimientos-table"
          data-height="600"
          data-toggle="trabajadores-table"
          data-toolbar=".toolbar"
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
  <script src="../SCRIPTS/bootstrap-table.js"></script>
  <script src="../SCRIPTS/bootstrap-table-es-MX.min.js"></script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('insert-form');
  const cedulaInput = document.getElementById('search-cedula');
  const productoInput = document.getElementById('search-producto');
  const cantidadInput = document.getElementById('insert-cantidad');
  const switchCheckbox = document.getElementById("mode-switch");
  const modeText = document.getElementById("mode-text");
  const manualSubmitButton = document.getElementById("manual-submit");

  let modoAutomatico = localStorage.getItem('modoAutomatico') === 'true';
  switchCheckbox.checked = modoAutomatico;

  cedulaInput.addEventListener('input', validarCedula);
  productoInput.addEventListener('input', validarCodigoProducto);

  cantidadInput.addEventListener('input', function() {
    if (!switchCheckbox.checked) {
      let valor = parseInt(cantidadInput.value.trim());
      if (isNaN(valor) || valor <= 0) {
        cantidadInput.value = '';
      } else {
        cantidadInput.value = Math.min(valor, 99);
      }
    }
  });

  manualSubmitButton.addEventListener('click', function(event) {
    event.preventDefault();
    if (cedulaInput.value.trim() !== '' && productoInput.value.trim() !== '' && cantidadInput.value.trim() !== '') {
      form.submit();
    } else {
      if (cantidadInput.value.trim() === '') {
        Swal.fire({
          icon: 'error',
          title: 'Campo Vacío',
          text: 'Por favor, ingresa la cantidad del producto.',
          confirmButtonText: 'OK'
        });
      }
    }
  });

  switchCheckbox.addEventListener('change', function() {
    form.removeAttribute('data-submitted');
    modoAutomatico = switchCheckbox.checked;
    if (switchCheckbox.checked) {
      modeText.innerText = "Modo Automático";
      cantidadInput.value = 1;
      cantidadInput.setAttribute('disabled', 'disabled');
      manualSubmitButton.style.display = "none";
      // Llamar a la función para manejar el submit en modo automático
      handleAutoSubmit();
    } else {
      modeText.innerText = "Modo Manual";
      cantidadInput.removeAttribute('disabled');
      manualSubmitButton.style.display = "block";
    }
    localStorage.setItem('modoAutomatico', switchCheckbox.checked);
  });

  function handleAutoSubmit() {
    // Obtener los datos del formulario
    const formData = new FormData(form);

    // Realizar la solicitud AJAX
    fetch(form.action, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          title: 'Inserción Exitosa',
          text: 'Los datos se han insertado correctamente.',
          icon: 'success',
          showConfirmButton: false,
        });

        setTimeout(() => {
          Swal.close();
          window.location.href = 'rendimientos.php';
        }, 1000);
      } else {
        Swal.fire({
          title: 'Error en la Inserción',
          text: 'Hubo un problema al insertar los datos.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    })
    .catch(error => {
      Swal.fire({
        title: 'Error',
        text: 'Hubo un problema al enviar los datos.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    });
  }

  // Manejar el submit en modo automático
  form.addEventListener('submit', function(event) {
    if (switchCheckbox.checked) {
      event.preventDefault(); // Evitar el comportamiento por defecto
      handleAutoSubmit();
    }
  });

  obtenerDatos();
  const exportarBtn = document.getElementById('exportar-btn');
  exportarBtn.addEventListener('click', function () {
    exportarExcel('table-body');
  });

  window.onload = function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../PHP/NoConsultas/SegundoPlano.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200)
        console.log("El archivo PHP se ejecutó en segundo plano");
    }
    xhr.send();
  }
});


function validarCedula() {
  return new Promise((resolve, reject) => {
    const cedulaInput = document.getElementById('search-cedula');
    const cedulaHelp = document.getElementById('cedula-help');
    const cedulaValue = cedulaInput.value;

    if (cedulaValue.length === 10) {
      $.ajax({
        url: '../PHP/NoConsultas/verificar_cedula.php',
        method: 'POST',
        data: { cedula: cedulaValue },
        success: function(response) {
          if (response.trim() === 'existe') {
            cedulaHelp.textContent = '';
            if (document.getElementById("mode-switch").checked) {
              document.getElementById("search-producto").focus();
            }
            resolve(true);
          } else {
            cedulaHelp.textContent = 'No encontrado, Ingresa Uno diferente o crea un registro este número.';
            cedulaHelp.style.color = 'red';
            resolve(false);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error en la solicitud AJAX (cedula):', status, error);
          resolve(false);
        }
      });
    } else {
      cedulaHelp.textContent = '';
      resolve(false);
    }
  });
}

function validarCodigoProducto() {
  return new Promise((resolve, reject) => {
    const codigoProductoInput = document.getElementById('search-producto');
    const codigoProductoHelp = document.getElementById('codigo-producto-help');
    const nombreProductoSpan = document.getElementById('nombre-producto');
    const codigoProductoValue = codigoProductoInput.value;

    if (codigoProductoValue.length === 5) {
      $.ajax({
        url: '../PHP/NoConsultas/verificar_codigo_producto.php',
        method: 'POST',
        data: { codigoProducto: codigoProductoValue },
        success: function(response) {
          if (response === 'existe') {
            codigoProductoHelp.textContent = '';
            // Hacer una segunda solicitud para obtener el nombre del producto
            obtenerNombreProducto(codigoProductoValue).then(nombre => {
              nombreProductoSpan.textContent = nombre;
              if (document.getElementById("mode-switch").checked) {
                submitFormManually(); // Enviar el formulario automáticamente
              }
              resolve(true);
            }).catch(() => {
              nombreProductoSpan.textContent = '';
              resolve(false);
            });
          } else {
            codigoProductoHelp.textContent = 'No encontrado, ingresa otro o registra uno nuevo.';
            nombreProductoSpan.textContent = '';
            resolve(false);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error en la solicitud AJAX (producto):', status, error);
          resolve(false);
        }
      });
    } else {
      codigoProductoHelp.textContent = '';
      nombreProductoSpan.textContent = '';
      resolve(false);
    }
  });
}

function obtenerNombreProducto(codigoProducto) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: '../PHP/NoConsultas/obtener_nombre_producto.php',
      method: 'POST',
      data: { codigoProducto: codigoProducto },
      success: function(response) {
        const data = JSON.parse(response);
        if (data.existe) {
          resolve(data.nombre);
        } else {
          reject();
        }
      },
      error: function(xhr, status, error) {
        console.error('Error en la solicitud AJAX (nombre producto):', status, error);
        reject();
      }
    });
  });
}

function submitFormManually() {
  document.getElementById('insert-form').submit();
}

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
    
    // Asignar color de fondo si está presente en los datos (asumiendo rendimiento.color_code existe)
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

  </script>
</body>
</html>
