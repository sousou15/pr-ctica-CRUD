<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se enviaron datos del formulario
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Datos de conexión a la base de datos (ajusta estos valores según tu configuración)
        $hostname = "localhost";
        $dbname = "bd_login";
        $dbuser = "root";
        $dbpass = "";

        try {
            // Conexión a la base de datos usando PDO
            $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $dbuser, $dbpass);

            // Consulta para verificar si el usuario ya existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                // El usuario ya existe, puedes manejar este caso según tus necesidades
                echo "El usuario ya existe. Por favor, elige otro nombre de usuario.";
            } else {
                // El usuario no existe, procede con el registro
                $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (:username, :password)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);

                $stmt->execute();

                // Inicia la sesión y redirige al usuario a la página principal
                $_SESSION['user'] = $username;
                header("Location: index.php");
                exit();
            }
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Registro</h1>
    <form method="post" action="">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Registrarse">
    </form>
    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
</body>
</html>
