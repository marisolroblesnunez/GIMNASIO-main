<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="cs/login.css">
</head>
<body>
    <h1>Panel de administración - Iniciar sesión</h1>

    <?php if ($error): ?>
        <p style="color:red;">Usuario o contraseña incorrectos</p>
    <?php endif; ?>

    <form method="post" action="verificar.php">
        <label for="usuario">Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label for="clave">Contraseña:</label><br>
        <input type="password" name="clave" required><br><br>

        <button type="submit">Entrar</button>
    </form>
    <script src="js/login.js"></script>
</body>
</html>
