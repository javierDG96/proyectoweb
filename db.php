<?php
$servername = "web.c6ivyf6dwj1q.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "admin1234";
$database = "mi_restaurante";
$port = 3306; // Puerto por defecto para MySQL

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>