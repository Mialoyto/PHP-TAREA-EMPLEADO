<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "senatidb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establece el modo de error de PDO en excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa $dbname"; 
}
catch(PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>
