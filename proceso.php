<?php
session_start();
require_once 'db.php'; 

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $opinion = $_POST["opinion"];

    // Consulta SQL para insertar la opinión en la base de datos
    $sqlInsertOpinion = "INSERT INTO opiniones (nombre, opinion) VALUES ('$nombre', '$opinion')";

    // Ejecutar la consulta
    if ($conn->query($sqlInsertOpinion) === TRUE) {
        echo "Opinión enviada con éxito.";
        header('Location: opiniones.php');
    } else {
        echo "Error al enviar la opinión: " . $conn->error;
    }
} else {
    echo "Acceso no autorizado.";
}


$conn->close();
?>
