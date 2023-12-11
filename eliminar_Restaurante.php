<?php
 require_once 'db.php';


function obtenerRestaurantes() {
    global $conn;
    $sql = "SELECT id, nombre FROM restaurantes";
    $result = $conn->query($sql);
    $restaurantes = array();

    while ($row = $result->fetch_assoc()) {
        $restaurantes[] = $row;
    }

    return $restaurantes;
}
 $idRestauranteBorrar = $_POST["id_restaurante_borrar"];

    // Consulta SQL para borrar el restaurante
    $sqlDeleteEspecialidad = "DELETE FROM especialidades WHERE id_restaurante = $idRestauranteBorrar";
    $conn->query($sqlDeleteEspecialidad);
    $sqlDeleteRestaurante = "DELETE FROM restaurantes WHERE id = $idRestauranteBorrar";

    if ($conn->query($sqlDeleteRestaurante) === TRUE) {
        echo "Restaurante borrado con éxito.";
        header("refresh:2;url=editar_restaurantes.php");
        exit();
    } else {
        echo "Error al borrar el restaurante: " . $conn->error;
    }


$conn->close();
?>