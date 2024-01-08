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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("imagen1.jpg");
            margin: 20px;
        }

        h2 {
            color: #333;
            font-size: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: whitesmoke;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
            border: solid 1px #007bff;
            background-color: whitesmoke;
            border-radius: 10px;
        }

        a:hover {
            color: whitesmoke;
            background-color: #007bff;
        }
    </style>
</head>
<body>

<h2>Lista de Usuarios</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre de Usuario</th>
        <th>Email</th>
        <th>Edad</th>
        <th>Dirección</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id'] ?></td>
            <td><?= $usuario['username'] ?></td>
            <td><?= $usuario['email'] ?></td>
            <td><?= $usuario['edad'] ?></td>
            <td><?= $usuario['direccion'] ?></td>


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
<a href="create.php">Crear Usuario</a><hr>
<!-- Enlace para cerrar sesión -->
<a href="logout.php">Cerrar Sesión</a>
</body>
</html>
