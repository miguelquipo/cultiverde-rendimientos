<?php
include '../PHP/Usuarios/check_access.php';

// Asegura que solo los usuarios con role_id 2 (editor) o 1 (admin) puedan acceder
checkAccess([1, 2, 3]);

// Código para mostrar la página
?>

<html>
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - Pagina Espera</title>
    <link rel="icon" href="../A-IMG/logo_prueba.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body{
          padding: 0;
          margin: 0;
          background-color: #fffff;
          text-align: center;
          height:100vh;
          font-family: 'lato';
          font-weight: 100;;
        }
      img{
        position:absolute;
        top:20%;
        left:45%;  
      }
      .wrapper{
          position:absolute;
          top:50%;
          left:50%;
          transform:translate(-50%, -50%);
        }
        .info{
          position:absolute;
          top:75%;
          font-weight: 500;
          font-size:24px;
          width:100%;
          text-align: center;
        }
        .circle{
          display: inline-block;
          width: 15px;
          height: 15px;
          background-color: #330065;
          border-radius: 50%;
          animation: loading 1.5s cubic-bezier(.8, .5, .2, 1.4) infinite;
          transform-origin: bottom center;
          position: relative;
        }
        @keyframes loading{
          0%{
            transform: translateY(0px);
            background-color: #2ce257;
          }
          50%{
            transform: translateY(50px);
            background-color: rgb(81, 79, 158);
          }
          100%{
            transform: translateY(0px);
            background-color: #a2e1b1;
          }
        }
        .circle-1{
          animation-delay: 0.1s;
        }
        .circle-2{
          animation-delay: 0.2s;
        }
        .circle-3{
          animation-delay: 0.3s;
        }
        .circle-4{
          animation-delay: 0.4s;
        }
        .circle-5{
          animation-delay: 0.5s;
        }
        .circle-6{
          animation-delay: 0.6s;
        }
        .circle-7{
          animation-delay: 0.7s;
        }
        .circle-8{
          animation-delay: 0.8s;
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
    </style>
</head>
<body>
  <div class="return-container">
    <a href="../index.php" class="return-button"> <!-- Enlace a la página anterior -->
      <i class="fas fa-arrow-left"></i>
      
    </a>
  </div>

    <img src="../A-IMG/logo_prueba.png" width="150" height="150" />
    <div class="wrapper">
        <span class="circle circle-1"></span>
        <span class="circle circle-2"></span>
        <span class="circle circle-3"></span>
        <span class="circle circle-4"></span>
        <span class="circle circle-5"></span>
        <span class="circle circle-6"></span>
        <span class="circle circle-7"></span>
        <span class="circle circle-8"></span>
    </div>

    <p class="info">Espera a que El administrador Inicie las actividades del dia de hoy</p>
</body>
</html>