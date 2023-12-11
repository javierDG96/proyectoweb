 <?php
 require_once 'db.php';
 $idRestauranteModificar = $_POST["id_restaurante_modificar"];
 $nuevoNombreRestaurante = $_POST["nuevo_nombre_restaurante"];
   

    // Consulta SQL para actualizar el restaurante
    $sqlUpdateRestaurante = "UPDATE restaurantes SET nombre = '$nuevoNombreRestaurante' WHERE id = $idRestauranteModificar";

    if ($conn->query($sqlUpdateRestaurante) === TRUE) {
        echo "Restaurante actualizado con éxito.";
         header("refresh:2;url=editar_restaurantes.php");
        exit();
    } else {
        echo "Error al actualizar el restaurante: " . $conn->error;
    }
 ?>