<?php
require_once('db.php');
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Consulta para obtener todos los usuarios
$stmt = $conn->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Mostrar la lista de usuarios -->
