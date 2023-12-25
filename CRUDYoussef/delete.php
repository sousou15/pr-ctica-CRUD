<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
<!-- No necesitas un formulario para eliminar, puedes hacerlo a través de un enlace o botón -->
