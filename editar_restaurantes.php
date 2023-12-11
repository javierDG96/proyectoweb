<?php
session_start();
require_once 'db.php';
?>
<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreRestauranteNuevo = $_POST["nombre_restaurante"];
    $idEspecialidadRestaurante = $_POST["especialidad_restaurante"];

    

    // Consulta SQL para insertar el nuevo restaurante
    $sqlInsertRestaurante = "INSERT INTO restaurantes (nombre) VALUES ('$nombreRestauranteNuevo')";

    if ($conn->query($sqlInsertRestaurante) === TRUE) {
        // Obtener el ID del restaurante recién insertado
        $idRestauranteNuevo = $conn->insert_id;

        // Insertar la relación en la tabla especialidades
        $sqlInsertRelacion = "INSERT INTO especialidades (id_restaurante, nombre) VALUES ($idRestauranteNuevo, '$idEspecialidadRestaurante')";


    } else {
        echo "Error al añadir el restaurante: " . $conn->error;
    }
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Editar Restaurante</title>
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
                <li class="nav-item ">
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
                <h1 class="bienvenida">Editar Restaurante</h1>
            </div>
            <div class="card-body">
                <!-- Formulario de Inserción -->
                <form method="POST">
                    <div class="form-group">
                        <label for="nombre_restaurante">Nombre del Restaurante:</label>
                        <input type="text" class="form-control" id="nombre_restaurante" name="nombre_restaurante" required>
                    </div>

                    <div class="form-group">
                        <label for="categoria_restaurante">Categoría:</label>
                        <?php
                        $servername = "web.c6ivyf6dwj1q.us-east-1.rds.amazonaws.com";
                        $username = "admin";
                        $password = "admin1234";
                        $database = "mi_restaurante";
                        $port = 3306; // Puerto por defecto para MySQL

                        // Crear conexión
                        $conn = new mysqli($servername, $username, $password, $database, $port);


                        if ($conn->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        }
                
                        
                        $sqlEspecialidades = "SELECT id, nombre FROM especialidades";
                        $resultEspecialidades = $conn->query($sqlEspecialidades);


                        if ($resultEspecialidades->num_rows > 0) {
                            echo '<select class="form-control" id="especialidad_restaurante" name="especialidad_restaurante">';
                            


                            while ($rowEspecialidad = $resultEspecialidades->fetch_assoc()) {
                                $idEspecialidad = $rowEspecialidad['id'];
                                $nombreEspecialidad = $rowEspecialidad['nombre'];

                                echo "<option value='$nombreEspecialidad'>$nombreEspecialidad</option>";
                            }

                            echo '</select>';
                            
                        } else {
                            echo '<p>No hay especialidades disponibles.</p>';
                        }
                        ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Añadir Restaurante</button>
                        </form>
                        </div>
                        </div>
                        </div>

                        <div class="container mt-4">
                        <div class="card">
                        <div class="card-header">
                        <h1 class="bienvenida">Modificar o Borrar Restaurantes</h1>
                        </div>
                        <div class="card-body">
                        <!-- Formulario de Modificación -->
                        <form method="POST" action="modificarRestaurante.php">
                        <div class="form-group">
                        <label for="id_restaurante_modificar">Seleccionar Restaurante:</label>
                        <?php $restaurantes = obtenerRestaurantes();  ?>
                        <select class="form-control" id="id_restaurante_modificar" name="id_restaurante_modificar" required>
                        <?php foreach ($restaurantes as $restaurante): ?>
                            <option value="<?php echo $restaurante['id']; ?>"><?php echo $restaurante['nombre']; ?></option>
                        <?php endforeach; ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="nuevo_nombre_restaurante">Nuevo Nombre del Restaurante:</label>
                        <input type="text" class="form-control" id="nuevo_nombre_restaurante" name="nuevo_nombre_restaurante" required>
                        </div>

                        <button type="submit" class="btn btn-primary" name="modificar">Modificar Restaurante</button>
                        </form>

                        <!-- Formulario de Borrado -->
                        <form method="POST" action="eliminar_Restaurante.php">
                        <div class="form-group">
                        <label for="id_restaurante_borrar">Seleccionar Restaurante:</label>
                        <?php $restaurantes = obtenerRestaurantes();  ?>
                        <select class="form-control" id="id_restaurante_borrar" name="id_restaurante_borrar" required>
                        <?php foreach ($restaurantes as $restaurante): ?>
                            <option value="<?php echo $restaurante['id']; ?>"><?php echo $restaurante['nombre']; ?></option>
                        <?php endforeach; ?>
                        </select>
                        </div>

                        <button type="submit" class="btn btn-danger" name="borrar">Borrar Restaurante</button>
                        </form>
                        </div>
                        </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                        </body>
                        </html>
