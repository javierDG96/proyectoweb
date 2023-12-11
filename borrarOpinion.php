<?php

require_once 'db.php';


    $idOpinionBorrar = $_POST["id_opinion_borrar"];

    // Consulta SQL para borrar la opinión
    $sqlBorrarOpinion = "DELETE FROM opiniones WHERE id = $idOpinionBorrar";

    if ($conn->query($sqlBorrarOpinion) === TRUE) {
        echo "Opinión borrada con éxito.";
        header("refresh:2;url=opiniones.php");
        exit();
    } else {
        echo "Error al borrar la opinión: " . $conn->error;
    }



$conn->close();
?>
