<?php
session_start();
require_once 'db.php'; 

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $idRestaurante = $_POST["id_restaurante"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $nombre = $_POST["nombre"];

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

            // Consulta SQL para insertar la reserva en la base de datos
            $sqlInsertReserva = "INSERT INTO reservas (id_usuario, nombre, id_restaurante, fecha, hora) VALUES ('$idUsuario', '$nombre', '$idRestaurante', '$fecha', '$hora')";

            // Ejecutar la consulta
            if ($conn->query($sqlInsertReserva) === TRUE) {
                echo "Reserva realizada con éxito.";
                header('Location: reservas.php');
            } else {
                echo "Error al realizar la reserva: " . $conn->error;
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
