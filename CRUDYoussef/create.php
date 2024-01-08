<?php
require_once('db.php');

// Operación de inserción (Registro)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] === 'registrar') {
        $username = $_POST['username'];
        $password = $_POST['password']; // Nuevo campo de contraseña

        try {
            $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
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
    <input type="submit" value="Registrar Usuario">
</form>

</body>
</html>
