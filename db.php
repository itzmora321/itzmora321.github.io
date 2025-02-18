<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "juguetes_sonrisas"; // Asegúrate de que este sea el nombre correcto de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conectado exitosamente";  // Esto te ayudará a verificar que la conexión es correcta.
?>

