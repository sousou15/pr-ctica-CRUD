<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO usuarios (username, email) VALUES (:username, :email)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
<!-- Formulario para crear un usuario -->
