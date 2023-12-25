<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE usuarios SET username = :username, email = :email WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
<!-- Formulario para actualizar un usuario -->
