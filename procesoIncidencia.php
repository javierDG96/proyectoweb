<?php
session_start();
require_once 'db.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $descripcion = $_POST["descripcion"];
    $idRestaurante = $_POST["id_restaurante"];

    // Obtener el nombre de usuario de la sesión
    if (isset($_SESSION['usuario'])) {
        $nombreUsuario = $_SESSION['usuario']['nombre_usuario'];

        // Consulta SQL para obtener el ID del usuario
        $sqlObtenerIdUsuario = "SELECT id FROM usuarios WHERE usuario = '$nombreUsuario'";
        $resultIdUsuario = $conn->query($sqlObtenerIdUsuario);

        // Verificar si se obtuvo el ID del usuario
        if ($resultIdUsuario->num_rows > 0) {
            $rowIdUsuario = $resultIdUsuario->fetch_assoc();
            $idUsuario = $rowIdUsuario['id'];

            // Consulta SQL para insertar la incidencia en la base de datos
            $sqlInsertIncidencia = "INSERT INTO incidencias (descripcion, id_usuario, id_restaurante) VALUES ('$descripcion', '$idUsuario', '$idRestaurante')";

            // Ejecutar la consulta
            if ($conn->query($sqlInsertIncidencia) === TRUE) {
                echo "Incidencia reportada con éxito.";
                header("refresh:2;url=incidencias.php");
        exit();
            } else {
                echo "Error al reportar la incidencia: " . $conn->error;
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
