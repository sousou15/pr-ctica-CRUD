<?php
require_once('db.php');

// Operación de inserción (Registro)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] === 'registrar') {
        $username = $_POST['username'];
        $password = $_POST['password']; // Nuevo campo de contraseña
        $email = $_POST['email'];
        $edad = $_POST['edad'];
        $direccion = $_POST['direccion'];

        try {
            $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email, edad, direccion) VALUES (:username, :password, :email, :edad, :direccion)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':edad', $edad);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->execute();

            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            die("Error al registrar usuario: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Usuario</title>
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

<h2>Crear Nuevo Usuario</h2>

<!-- Formulario para crear un usuario -->
<form method="post" action="create.php">
    <input type="hidden" name="accion" value="registrar">
    <label for="username">Nombre de Usuario:</label>
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
    <input type="submit" value="Registrar Usuario">
</form>


</body>
</html>
