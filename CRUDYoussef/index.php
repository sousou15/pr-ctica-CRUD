<?php
session_start();


if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once('db.php');

// Obtener y mostrar la lista de usuarios
$stmt = $conn->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
</head>
<body>

<h2>Lista de Usuarios</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre de Usuario</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id'] ?></td>
            <td><?= $usuario['username'] ?></td>
            <td>
                <!-- Enlace para eliminar -->
                <a href="delete.php?id=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                <!-- Enlace para actualizar -->
                <a href="update.php?id=<?= $usuario['id'] ?>">Actualizar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Enlace para crear un nuevo usuario -->
<h2>Crear Nuevo Usuario</h2>
<a href="create.php">Crear Usuario</a>
<!-- Enlace para cerrar sesión -->
<a href="logout.php">Cerrar Sesión</a>
</body>
</html>
