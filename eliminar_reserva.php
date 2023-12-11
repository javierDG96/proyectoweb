<?php

require_once 'db.php';

if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    // Consulta SQL para eliminar la reserva
    $sql = "DELETE FROM reservas WHERE id = $idReserva";
    if ($conn->query($sql) === TRUE) {
        echo "Reserva eliminada correctamente.";
        header("refresh:2;url=ver_reservas.php");
    } else {
        echo "Error al eliminar la reserva: " . $conn->error;
    }

    
    $conn->close();

} else {
    echo "ID de reserva no proporcionado.";
}
?>
