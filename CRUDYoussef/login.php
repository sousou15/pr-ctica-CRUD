<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="cuadro">
        <h1>LOGIN</h1>

        <img src="imagen2.png">
        <form action="Login.php" method="post">
            <label for="Usuario">Usuario:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp  </label>
            <input type="text" id="username" name="username" placeholder="Nombre de usuario..." /><br><br>
            <label for="pwd">Contraseña:</label>
            <input type="password" id="pwd" name="pwd" placeholder="Contraseña de acceso..."><br><br>
            <input class="botonconectar" type="submit" value="Iniciar"><br><br>
            <div id="error-message"></div>
        </form>
        <!-- Enlace para Registrarse -->
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a>.</p>
    </div>

    <script>
        // JavaScript para mostrar mensaje de error en el cuadro de login
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get("error");
        
        if (error) {
            document.getElementById("error-message").textContent = "Usuario o contraseña incorrectos. Por favor, inténtelo de nuevo.";
        }
    </script>
</body>
</html>

<?php
session_start(); // Inicia la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica las credenciales del usuario en la base de datos
    $usuario = $_POST["username"];
    $contraseña = $_POST["pwd"];

    // Datos de conexión a la base de datos (ajusta estos valores según tu configuración)
    $hostname = "localhost";
    $dbname = "bd_login";
    $dbuser = "root";
    $dbpass = "";

    try {
        // Conexión a la base de datos usando PDO
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para verificar las credenciales en una tabla de usuarios
        $stmt = $pdo->prepare("SELECT id, username, password FROM usuarios WHERE username = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        // Verifica si se encontraron resultados
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Verifica la contraseña usando password_verify
            if (password_verify($contraseña, $row['password'])) {
                // Si las credenciales son correctas, establece una cookie para mantener la sesión
                setcookie('nombre_usuario', $usuario, time() + 3600, '/');
                $_SESSION['id'] = $row['id'];

                // Registra el tiempo de inicio de sesión
                $_SESSION['inicio_sesion'] = date('Y-m-d H:i:s');

                header('Location: index.php');
                exit;
            } else {
                // Contraseña incorrecta
                header('Location: login.php?error=1');
                exit;
            }
        } else {
            // Usuario no encontrado
            header('Location: login.php?error=1');
            exit;
        }
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>
