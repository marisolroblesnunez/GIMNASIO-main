<?php
// contacto.php
// Formulario de contacto para consultas, dudas o reclamos

require_once 'CONFIG/database.php';
require_once 'DATA/contactoDB.php';

$mensaje = '';

// Procesamos el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $texto = trim($_POST['mensaje']);

    if ($nombre && $email && $texto) {
        if (guardarMensajeContacto($pdo, $nombre, $email, $texto)) {
            $mensaje = "Mensaje enviado correctamente. Gracias por contactarnos.";
        } else {
            $mensaje = "Error al enviar el mensaje. Intenta nuevamente.";
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto - Gimnasio</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <h1>Contáctanos</h1>

    <?php if ($mensaje): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>

    <form method="post" action="contacto.php">
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label for="email">Correo electrónico:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="mensaje">Mensaje:</label><br>
        <textarea name="mensaje" rows="5" required></textarea><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
