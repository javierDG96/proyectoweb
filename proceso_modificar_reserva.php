<?php
require_once 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $idReserva = $_POST['id'];
    $nombre = $_POST['nombre'];
    $idRestaurante = $_POST['id_restaurante'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Consulta SQL para actualizar la reserva
    $sqlActualizarReserva = "UPDATE reservas SET nombre='$nombre', id_restaurante=$idRestaurante, fecha='$fecha', hora='$hora' WHERE id=$idReserva";

    if ($conn->query($sqlActualizarReserva) === TRUE) {
                header('Location: ver_reservas.php');
        exit();
    } else {
        // Error en la actualización
        echo 'Error al actualizar la reserva: ' . $conn->error;
    }
} else {
    // Acceso incorrecto al script
    echo 'Acceso incorrecto';
}


$conn->close();
?>
