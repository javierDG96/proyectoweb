<?php
require_once 'db.php';
// Verificar si se recibió el ID del usuario a borrar
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
    $sqlEliminarIncidencias = "DELETE FROM incidencias WHERE id_usuario = $idUsuario";
    $conn->query($sqlEliminarIncidencias);
    $sqlEliminarOpiniones = "DELETE FROM opiniones WHERE id_usuario = $idUsuario";
    $conn->query($sqlEliminarOpiniones);
    $sqlEliminarReservas = "DELETE FROM reservas WHERE id_usuario = $idUsuario";
    $conn->query($sqlEliminarReservas);

   
    $sqlDeleteUsuario = "DELETE FROM usuarios WHERE id = $idUsuario";

    // Ejecutar la consulta
    if ($conn->query($sqlDeleteUsuario) === TRUE) {
        // Mensaje de éxito
        echo "Borrado exitoso. Redirigiendo...";

        // Redirigir al listado de usuarios después de 2 segundos
        header("refresh:2;url=lista_usuarios.php");
        exit();
    } else {
        echo "Error al borrar el usuario: " . $conn->error;
    }
} else {
    echo "ID de usuario no proporcionado.";
}

$conn->close();
?>
