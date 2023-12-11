<?php
session_start();
require_once 'db.php';

if ($_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Función para obtener la lista de restaurantes
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

    // Función para obtener la lista de platos de un restaurante
function obtenerPlatosRestaurante($idRestaurante) {

    $servername = "web.c6ivyf6dwj1q.us-east-1.rds.amazonaws.com";
    $username = "admin";
    $password = "admin1234";
    $database = "mi_restaurante";
    $port = 3306; // Puerto por defecto para MySQL

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }






    $sql = "SELECT id, nombre FROM platos WHERE id_restaurante = $idRestaurante";

    $result = $conn->query($sql);
    if (!$result) {
        die("Error en la consulta: " . $conn->error . " SQL: " . $sql);
    }

    $platos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $platos[] = $row;
        }
    }

    return $platos;
}





// Verificar si se ha enviado el formulario de inserción
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertar'])) {
    $idRestauranteInsertar = $_POST["id_restaurante_insertar"];
    $nombrePlato = $_POST["nombre_plato"];
    

    // Consulta SQL para insertar el plato
    $sqlInsertPlato = "INSERT INTO platos (id_restaurante, nombre) VALUES ($idRestauranteInsertar, '$nombrePlato')";

    if ($conn->query($sqlInsertPlato) === TRUE) {
        echo "Plato insertado con éxito.";
    } else {
        echo "Error al insertar el plato: " . $conn->error;
    }
}


// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $idPlatoEditar = $_POST["id_plato_editar"];
    $nuevoNombrePlato = $_POST["nuevo_nombre_plato"];

    // Consulta SQL para actualizar el nombre del plato
    $sqlUpdatePlato = "UPDATE platos SET nombre = '$nuevoNombrePlato' WHERE id = $idPlatoEditar";

    if ($conn->query($sqlUpdatePlato) === TRUE) {
        echo "Nombre del plato actualizado con éxito.";
    } else {
        echo "Error al actualizar el nombre del plato: " . $conn->error;
    }
}

// Verificar si se ha enviado el formulario de borrado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar'])) {
    $idPlatoBorrar = $_POST["id_plato_borrar"];

    // Consulta SQL para borrar el plato
    $sqlDeletePlato = "DELETE FROM platos WHERE id = $idPlatoBorrar";

    if ($conn->query($sqlDeletePlato) === TRUE) {
        echo "Plato eliminado con éxito.";
    } else {
        echo "Error al eliminar el plato: " . $conn->error;
    }
}

$restaurantes = obtenerRestaurantes();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Editar Platos</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <a class="navbar-brand" href="index.php">Mis Restaurantes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="restaurantes.php">Restaurantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="opiniones.php">Opiniones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="incidencias.php">Incidencias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservas.php">Reservas</a>
                </li>
                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administrar Restaurantes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="editar_restaurantes.php">CRUD Restaurantes</a>
                            <a class="dropdown-item" href="editar_platos.php">CRUD Platos</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h1 class="bienvenida">Editar Platos</h1>
            </div>
            <div class="card-body">
                <!-- Formulario de Inserción -->
                <form method="POST">
                    <div class="form-group">
                        <label for="id_restaurante_insertar">Selecciona un Restaurante:</label>
                        <select class="form-control" id="id_restaurante_insertar" name="id_restaurante_insertar">
                            <?php
                            foreach ($restaurantes as $restaurante) {
                                echo "<option value='{$restaurante['id']}'>{$restaurante['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre_plato">Nombre del Plato:</label>
                        <input type="text" class="form-control" id="nombre_plato" name="nombre_plato" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="insertar">Añadir Plato</button>
                </form>

                <?php foreach ($restaurantes as $restaurante): ?>
                    <h2><?php echo $restaurante['nombre']; ?></h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Plato</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener la lista de platos para el restaurante actual
                            $platosRestaurante = obtenerPlatosRestaurante($restaurante['id'], $conn);


                            foreach ($platosRestaurante as $plato): ?>
                                <tr>
                                    <td><?php echo $plato['id']; ?></td>
                                    <td><?php echo $plato['nombre']; ?></td>
                                    <td>
                                        <!-- Formulario para editar el nombre del plato -->
                                        <form method="POST" style="display: inline-block;">
                                            <input type="hidden" name="id_plato_editar" value="<?php echo $plato['id']; ?>">
                                            <input type="text" name="nuevo_nombre_plato" placeholder="Nuevo Nombre" value="<?php echo $plato['nombre']; ?>" required>
                                            <button type="submit" class="btn btn-primary" name="editar">Editar</button>
                                        </form>

                                        <!-- Formulario para borrar el plato -->
                                        <form method="POST" style="display: inline-block;">
                                            <input type="hidden" name="id_plato_borrar" value="<?php echo $plato['id']; ?>">
                                            <button type="submit" class="btn btn-danger" name="borrar">Borrar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
