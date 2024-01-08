<?php
require_once('db.php');

// Verificar si se envió el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $newUsername = $_POST['new_username']; // Nuevo nombre de usuario

    try {
        // Actualizar el nombre de usuario en la base de datos
        $stmt = $conn->prepare("UPDATE usuarios SET username = :new_username WHERE id = :id");
        $stmt->bindParam(':new_username', $newUsername);
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
</head>
<body>

<h2>Actualizar Usuario</h2>

<!-- Formulario para actualizar el usuario -->
<form method="post" action="update.php">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <label for="new_username">Nuevo Nombre de Usuario:</label>
    <input type="text" name="new_username" value="<?= $usuario['username'] ?>" required>
    <br>
    <input type="submit" value="Actualizar Usuario">
</form>

<!-- Enlace para volver a la lista de usuarios -->
<a href="index.php">Volver a la Lista de Usuarios</a>

</body>
</html>
