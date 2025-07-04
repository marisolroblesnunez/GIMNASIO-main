<?php
// index.php
// Página principal del gimnasio

require_once 'CONFIG/database.php';
require_once 'DATA/claseDB.php';

$clases = obtenerClases($pdo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gimnasio Fuerza Total</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <header>
        <h1>Bienvenido a Fuerza Total</h1>
        <nav>
            <a href="clases.php">Clases</a> |
            <a href="inscribirse.php">Inscribirse</a> |
            <a href="contacto.php">Contacto</a> |
            <a href="testimonios.php">Testimonios</a>
        </nav>
    </header>

    <section>
        <h2>Conoce nuestras clases destacadas</h2>
        <?php foreach (array_slice($clases, 0, 3) as $clase): ?>
            <div class="clase">
                <h3><?= htmlspecialchars($clase['nombre']) ?></h3>
                <p><?= htmlspecialchars($clase['descripcion']) ?></p>
                <p><strong>Día:</strong> <?= $clase['dia_semana'] ?> - <?= substr($clase['hora'], 0, 5) ?></p>
            </div>
        <?php endforeach; ?>
    </section>

    <footer>
        <p>&copy; <?= date("Y") ?> Gimnasio Fuerza Total</p>
    </footer>
</body>
</html>
