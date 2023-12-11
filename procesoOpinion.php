<?php
session_start();
require_once 'db.php'; 

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["opinion"];
    $idRestaurante = $_POST["id_restaurante"];

    // Obtener la información del usuario de la sesión
    if (isset($_SESSION['usuario'])) {
        $nombreUsuario = $_SESSION['usuario']['nombre_usuario'];

        // Consulta SQL para obtener el ID del usuario
        $sqlObtenerIdUsuario = "SELECT id FROM usuarios WHERE usuario = '$nombreUsuario'";
        $resultIdUsuario = $conn->query($sqlObtenerIdUsuario);

        // Verificar si se obtuvo el ID del usuario
        if ($resultIdUsuario->num_rows > 0) {
            $rowIdUsuario = $resultIdUsuario->fetch_assoc();
            $idUsuario = $rowIdUsuario['id'];

            // Consulta SQL para insertar la opinión en la base de datos
            $sqlInsertOpinion = "INSERT INTO opiniones (id_usuario, nombre, descripcion, id_restaurante) VALUES ('$idUsuario', '$nombre', '$descripcion', '$idRestaurante')";

            // Ejecutar la consulta
            if ($conn->query($sqlInsertOpinion) === TRUE) {
                echo "Opinión enviada con éxito.";
                header('Location: opiniones.php');
            } else {
                echo "Error al enviar la opinión: " . $conn->error;
            }
        } else {
            echo "Error al obtener el ID del usuario.";
        }
    } else {
        echo "No hay un usuario autenticado.";
    }
} else {
    echo "Acceso no autorizado.";
}


$conn->close();
?>


