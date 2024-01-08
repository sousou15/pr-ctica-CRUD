<?php
require_once('db.php');

// Verificar si se envió el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $newUsername = $_POST['new_username'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $newEmail = $_POST['new_email'];
    $newEdad = $_POST['new_edad']; // Nuevo campo de edad
    $newDireccion = $_POST['new_direccion'];

    try {
        // Actualizar la información del usuario en la base de datos
        $stmt = $conn->prepare("UPDATE usuarios SET username = :new_username, password = :new_password, email = :new_email, edad = :new_edad, direccion = :new_direccion WHERE id = :id");
        $stmt->bindParam(':new_username', $newUsername);
        $stmt->bindParam(':new_password', $newPassword);
        $stmt->bindParam(':new_email', $newEmail);
        $stmt->bindParam(':new_edad', $newEdad);
        $stmt->bindParam(':new_direccion', $newDireccion);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Error al actualizar usuario: " . $e->getMessage());
    }
}

// Obtener el ID del usuario a actualizar
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener información del usuario para mostrar en el formulario de actualización
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirigir si no se proporcionó un ID válido
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h2 {
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

        a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Actualizar Usuario</h2>

<!-- Formulario para actualizar el usuario -->
<form method="post" action="update.php">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <label for="new_username">Nuevo Nombre de Usuario:</label>
    <input type="text" name="new_username" value="<?= $usuario['username'] ?>" required>
    <label for="new_password">Nueva Contraseña:</label>
    <input type="text" name="new_password" value="<?= $usuario['password'] ?>" required>
    <label for="new_email">Nuevo Email:</label>
    <input type="text" name="new_email" value="<?= $usuario['email'] ?>" required>
    <label for="new_edad">Nueva Edad:</label>
    <input type="text" name="new_edad" value="<?= $usuario['edad'] ?>" required>
    <label for="new_direccion">Nueva Dirección:</label>
    <input type="text" name="new_direccion" value="<?= $usuario['direccion'] ?>" required>
    <br>
    <input type="submit" value="Actualizar Usuario">
</form>

<!-- Enlace para volver a la lista de usuarios -->
<a href="index.php">Volver a la Lista de Usuarios</a>

</body>
</html>
