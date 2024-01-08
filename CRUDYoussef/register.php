<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se enviaron datos del formulario
    if (isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['edad'], $_POST['direccion'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $edad = $_POST['edad'];
        $direccion = $_POST['direccion'];

        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Datos de conexión a la base de datos (ajusta estos valores según tu configuración)
        $hostname = "localhost";
        $dbname = "bd_login";
        $dbuser = "root";
        $dbpass = "";

        try {
            // Conexión a la base de datos usando PDO
            $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $dbuser, $dbpass);

            // Consulta para verificar si el usuario ya existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                // El usuario ya existe, puedes manejar este caso según tus necesidades
                echo "El usuario ya existe. Por favor, elige otro nombre de usuario.";
            } else {
                // El usuario no existe, procede con el registro
                $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, email, edad, direccion) VALUES (:username, :password, :email, :edad, :direccion)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':edad', $edad);
                $stmt->bindParam(':direccion', $direccion);

                $stmt->execute();

                // Inicia la sesión y redirige al usuario a la página principal
                $_SESSION['user'] = $username;
                header("Location: index.php");
                exit();
            }
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 10px;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Registro</h1>
    <form method="post" action="">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <label for="email">Email:</label>
        <input type="text" name="email" required>
        <br>
        <label for="edad">Edad:</label>
        <input type="text" name="edad" required>
        <br>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>
        <br>
        <input type="submit" value="Registrarse">
    </form>
    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
</body>
</html>
