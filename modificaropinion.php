<?php

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idOpinionModificar = $_POST["id_opinion_modificar"];
    $nuevoNombreOpinion = $_POST["nuevo_nombre_opinion"];
    $nuevaDescripcionOpinion = $_POST["nueva_descripcion_opinion"];
    $nuevoRestauranteOpinion = $_POST["nuevo_restaurante_opinion"];

    // Consulta SQL para actualizar la opinión
    $sqlUpdateOpinion = "UPDATE opiniones SET nombre = '$nuevoNombreOpinion', descripcion = '$nuevaDescripcionOpinion', id_restaurante = $nuevoRestauranteOpinion WHERE id = $idOpinionModificar";

    if ($conn->query($sqlUpdateOpinion) === TRUE) {
        echo "Opinión actualizada con éxito.";
        header("refresh:2;url=opiniones.php");
        exit();
    } else {
        echo "Error al actualizar la opinión: " . $conn->error;
    }
}


$conn->close();
?>
