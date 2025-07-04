<?php
// CONFIG/database.php
// Configuración de la conexión a la base de datos MySQL

$host = 'localhost';
$dbname = 'gimnasio';
$username = 'root'; // cambia esto si usas otro usuario
$password = '';     // cambia esto si tienes contraseña

try {
    // PDO permite usar una conexión segura y moderna a MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
