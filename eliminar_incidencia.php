<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once 'db.php';

if (isset($_GET['id'])) {
    $idIncidenciaEliminar = $_GET['id'];

    // Consulta SQL para eliminar la incidencia
    $sqlDeleteIncidencia = "DELETE FROM incidencias WHERE id = $idIncidenciaEliminar";

    if ($conn->query($sqlDeleteIncidencia) === TRUE) {
        echo "Incidencia eliminada con éxito.";
        header("refresh:2;url=ver_incidencias.php");
        exit();
    } else {
        echo "Error al eliminar la incidencia: " . $conn->error;
    }
} else {
    echo "ID de incidencia no proporcionado.";
}

$conn->close();
?>
