<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../A-IMG/logo_prueba.png">
    <title>Access Denied</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-name-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px; /* Separation between the logo-name group and the message */
        }

        .logo {
            width: 150px;
            animation: rotate 5s linear infinite;
            margin-right: 20px; /* Separation between logo and name */
        }

        .name {
            width: 300px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .message {
            font-size: 24px;
            color: #333;
        }

        .login-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #4CAF50; /* Light green */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #388E3C; /* Darker green */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-name-container">
            <img src="../A-IMG/rotate_flor.png" alt="Logo" class="logo">
            <img src="../A-IMG/nombre.png" alt="Nombre" class="name">
        </div>
        <div class="message">La página a la que estás intentando acceder no está disponible para ti en este momento.</div>
        <a href="../PHP/Usuarios/login.php" class="login-button">Iniciar sesión</a>
    </div>
</body>
</html>
