<?php
include '../PHP/Usuarios/check_access.php';

// Asegura que solo los usuarios con role_id 2 (editor) o 1 (admin) puedan acceder
checkAccess([1, 4]);

// Código para mostrar la página
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendimientos Automático</title>

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
    <link rel="stylesheet" href="../CSS/stykesRendi.css">
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
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
    display: none; /* Inicialmente oculto */
    animation: parpadeo 1s infinite; /* Efecto de parpadeo */
}

.alerta-icon {
    font-size: 1.5em;
    margin-right: 10px;
}

.alerta-mensaje {
    font-size: 1em;
}

@keyframes parpadeo {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
        #infoDiv {
            position: absolute;
            top: 3%;
            left: 25%;
            padding: 10px;
            text-align: center;
            font-size: 2cap;
            z-index: 1000;
            opacity: 0.7;
            font-weight: bold;
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

        #pin-button {
            background-color: transparent;
            border: none;
            color: grey;
            cursor: pointer;
        }

        #pin-button.locked {
            color: red;
            /* Cambia el color cuando está bloqueado */
        }

        #pin-button.unlocked {
            color: green;
            /* Cambia el color cuando está desbloqueado */
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
        <h1>Rendimientos Automático</h1>
        <div class="form-container">
            <form id="insert-form" method="post" action="../PHP/rendimientos_auto.php">
                <div class="form-group">
                    <label for="search-cedula">Número de Cédula:</label>
                    <input type="text" id="search-cedula" name="search-cedula" minlength="10" maxlength="10" autofocus>
                    <span id="cedula-help" style="color: red;"></span>
                </div>
                <div class="form-group">
                    <label for="search-producto">Código Producto:</label>
                    <div style="display: flex; align-items: center;">
                        <input type="text" id="search-producto" name="search-producto" maxlength="5"
                            style="width: 100px;">
                        <button id="pin-button" type="button" style="margin-left: 10px;">
                            <i class="fas fa-thumbtack"></i>
                        </button>
                        <span id="nombre-producto" style="color: green; margin-left: 10px;"></span>
                    </div>
                    <span id="codigo-producto-help" style="color: red;"></span>
                </div>


                <div class="">
                    <label for="insert-cantidad">Cantidad Producto:</label><br>
                    <input type="number" id="insert-cantidad" name="insert-cantidad" value="1" readonly>
                </div>

            </form>
            <div class="delete-container">
                <a href="./rendimientos.php" class="icon-button" data-toggle="tooltip" data-placement="top"
                    title="Cambiar a modo manual">
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
document.addEventListener('DOMContentLoaded', function () {
    console.log('Inicio del script');

    // Función para actualizar el estado de la alerta
    function actualizarAlerta() {
        fetch('../PHP/obtener_estado_alerta.php')
            .then(response => response.text()) // Obtén la respuesta como texto
            .then(text => {
                console.log('Respuesta del servidor (texto):', text);

                try {
                    const data = JSON.parse(text); // Intenta parsear el texto como JSON
                    console.log('Datos recibidos del servidor:', data);

                    if (data.error) {
                        console.error('Error en la respuesta del servidor:', data.error);
                        return;
                    }

                    const esMenorDe5Minutos = data.esMenorDe5Minutos;
                    console.log('esMenorDe5Minutos:', esMenorDe5Minutos);

                    const alertaDiv = document.getElementById('alertaDiv');
                    console.log('alertaDiv:', alertaDiv);

                    if (alertaDiv) {
                        if (esMenorDe5Minutos) {
                            alertaDiv.style.display = 'block';
                            console.log('AlertaDiv mostrado');

                            // Ocultar alerta después de 5 minutos si no se actualiza
                            setTimeout(() => {
                                alertaDiv.style.display = 'none';
                                console.log('AlertaDiv oculto después de 5 minutos');
                            }, 2 * 60 * 1000); // 5 minutos en milisegundos
                        } else {
                            alertaDiv.style.display = 'none';
                            console.log('AlertaDiv oculto');
                        }
                    } else {
                        console.error('No se pudo encontrar alertaDiv');
                    }
                } catch (e) {
                    console.error('Error al parsear la respuesta JSON:', e);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud Fetch:', error);
            });
    }

    // Actualiza la alerta cuando la página se carga
    actualizarAlerta();

    // Actualiza la alerta cada minuto
    setInterval(actualizarAlerta, 60000); // 60 segundos en milisegundos
});
</script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obtener los parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        const error = urlParams.get('error');

        // Mostrar una alerta basada en el parámetro 'success'
        if (success === 'true') {
            Swal.fire({
                icon: 'success',
                title: 'Registro Exitoso',
                text: 'Los datos se han registrado correctamente.',
                timer: 1000, // Duración de 1 segundo
                showConfirmButton: false
            });
        } else if (success === 'false') {
            let errorMessage = '';

            // Mostrar mensaje de error basado en el tipo de error
            switch (error) {
                case 'consulta_trabajador':
                    errorMessage = 'Error al consultar el trabajador.';
                    break;
                case 'no_trabajador':
                    errorMessage = 'No se encontró el trabajador con esa cédula.';
                    break;
                case 'consulta_rango':
                    errorMessage = 'Error al consultar el rango de horas.';
                    break;
                case 'no_registro':
                    errorMessage = 'No hay registros de inicio o fin.';
                    break;
                case 'insert_fallido':
                    errorMessage = 'Error al insertar los datos en la base de datos.';
                    break;
                default:
                    errorMessage = 'Hubo un error desconocido.';
            }

            Swal.fire({
                icon: 'error',
                title: 'Error en el Registro',
                text: errorMessage,
                confirmButtonText: 'OK'
            });
        }
    });
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('insert-form');
            const cedulaInput = document.getElementById('search-cedula');
            const productoInput = document.getElementById('search-producto');
            const cantidadInput = document.getElementById('insert-cantidad');

            cedulaInput.addEventListener('input', validarCedula);
            productoInput.addEventListener('input', validarCodigoProducto);

            cantidadInput.addEventListener('input', function () {
                let valor = parseInt(cantidadInput.value.trim());
                if (isNaN(valor) || valor <= 0) {
                    cantidadInput.value = '';
                } else {
                    cantidadInput.value = Math.min(valor, 99); // Limitar máximo a 99
                }
            });

            form.addEventListener('input', function () {
                if (cedulaInput.value.trim() !== '' && productoInput.value.trim() !== '' && cantidadInput.value.trim() !== '') {
                    form.submit();
                }
            });

            obtenerDatos();

            const exportarBtn = document.getElementById('exportar-btn');
            exportarBtn.addEventListener('click', function () {
                exportarExcel();
            });
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
                        success: function (response) {
                            if (response.trim() === 'existe') {
                                cedulaHelp.textContent = '';
                                document.getElementById("search-producto").focus();
                                resolve(true);
                            } else {
                                cedulaHelp.textContent = 'No encontrado, Ingresa Uno diferente o crea un registro este número.';
                                cedulaHelp.style.color = 'red';
                                resolve(false);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error en la solicitud AJAX (cedula):', status, error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error en la Validación de Cédula',
                                text: 'Hubo un problema al validar la cédula.',
                                confirmButtonText: 'OK'
                            });
                            resolve(false);
                        }
                    });
                } else {
                    cedulaHelp.textContent = '';
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
                    success: function (response) {
                        try {
                            const data = JSON.parse(response);
                            const nombreProducto = data.nombre || '';
                            resolve(nombreProducto);
                        } catch (error) {
                            console.error('Error al procesar la respuesta JSON:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error en la Obtención del Nombre del Producto',
                                text: 'Hubo un problema al procesar la respuesta del servidor.',
                                confirmButtonText: 'OK'
                            });
                            resolve('');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la solicitud AJAX (nombre producto):', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al Obtener el Nombre del Producto',
                            text: 'Hubo un problema al obtener el nombre del producto.',
                            confirmButtonText: 'OK'
                        });
                        resolve('');
                    }
                });
            });
        }

        async function validarCodigoProducto() {
            const productoInput = document.getElementById('search-producto');
            const codigoProductoHelp = document.getElementById('codigo-producto-help');
            const nombreProductoSpan = document.getElementById('nombre-producto');
            const codigoProductoValue = productoInput.value;

            if (codigoProductoValue.length > 0) {
                const nombreProducto = await obtenerNombreProducto(codigoProductoValue);
                if (nombreProducto) {
                    codigoProductoHelp.textContent = '';
                    nombreProductoSpan.textContent = nombreProducto;
                    document.getElementById("insert-cantidad").focus();
                    return true;
                } else {
                    codigoProductoHelp.textContent = 'El código de producto no es válido.';
                    nombreProductoSpan.textContent = '';
                    return false;
                }
            } else {
                codigoProductoHelp.textContent = '';
                nombreProductoSpan.textContent = '';
                return false;
            }
        }

        function exportarExcel() {
            const ws = XLSX.utils.table_to_sheet(document.getElementById('rendimientos-table'));
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Rendimientos');
            XLSX.writeFile(wb, 'RendimientosHora.xlsx');
        }
    </script>
    <!--ObtenerDatos-->
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            // Obtener datos iniciales
            await obtenerDatos();

            // Actualizar los datos cada segundo
            setInterval(async function () {
                await obtenerDatos();
            }, 1000); // 1000 milisegundos = 1 segundo
        });

        async function obtenerDatos() {
            try {
                let url = '../PHP/obtener_rendimientos.php';
                const response = await fetch(url);
                const data = await response.json();
                mostrarDatosEnTabla(data);
            } catch (error) {
                console.error('Error al obtener los datos:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al Obtener Datos',
                    text: 'Hubo un problema al obtener los datos de rendimientos.',
                    confirmButtonText: 'OK'
                });
            }
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

                // Asignar color de fondo si está presente en los datos
                if (rendimiento.color_code) {
                    row.style.backgroundColor = rendimiento.color_code;
                }

                tableBody.appendChild(row);
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
                    infoDiv.innerHTML = `Rango Actual: ${data.hora_inicio}-${data.hora_fin}`;
                }
            }

        };
    </script>
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const productoInput = document.getElementById('search-producto');
    const pinButton = document.getElementById('pin-button');

    // Verificar si hay un valor de producto bloqueado en el localStorage
    if (localStorage.getItem('productoBloqueado')) {
        productoInput.value = localStorage.getItem('productoBloqueado');
        pinButton.classList.add('locked');
    } else {
        pinButton.classList.add('unlocked');
    }

    // Manejar el clic en el botón de pin
    pinButton.addEventListener('click', function () {
        if (pinButton.classList.contains('locked')) {
            // Desbloquear el código de producto
            localStorage.removeItem('productoBloqueado');
            pinButton.classList.remove('locked');
            pinButton.classList.add('unlocked');
        } else {
            // Bloquear el código de producto
            localStorage.setItem('productoBloqueado', productoInput.value);
            pinButton.classList.remove('unlocked');
            pinButton.classList.add('locked');
        }
    });

    // Actualizar el valor del producto cuando se cambie
    productoInput.addEventListener('input', function () {
        if (pinButton.classList.contains('locked')) {
            // Si el código está bloqueado, actualizar el valor en el localStorage
            localStorage.setItem('productoBloqueado', productoInput.value);
        }
    });
});

    </script>
</body>

</html>