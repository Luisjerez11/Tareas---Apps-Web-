
<?php

session_start();

# Verificar si el usuario inició sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

require_once "conexion.php";

# Verificar si el formulario fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    # Recibir los parámetros
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $prioridad = $_POST['prioridad'] ?? '';

    # Comprobar que sean cadenas de texto
    if (!is_string($nombre) ||
        !is_string($descripcion) ||
        !is_string($prioridad)) {

        header("Location: 400.php");
        exit;
    }

    $nombre = trim($nombre);
    $descripcion = trim($descripcion);

    # Validar campos obligatorios
    if ($nombre == '' || $descripcion == '' || $prioridad == '') {
        header("Location: 400.php");
        exit;
    }

    # Validar caracteres prohibidos del nombre
    if (strpos($nombre, '$') !== false ||
        strpos($nombre, '\\') !== false ||
        strpos($nombre, '=') !== false) {

        header("Location: 400.php");
        exit;
    }

    # Validar caracteres prohibidos de la descripción
    if (strpos($descripcion, '$') !== false ||
        strpos($descripcion, '[') !== false ||
        strpos($descripcion, ']') !== false ||
        strpos($descripcion, '\\') !== false ||
        strpos($descripcion, '=') !== false) {

        header("Location: 400.php");
        exit;
    }

    # Validar longitud del nombre
    if (strlen($nombre) > 150) {
        header("Location: 400.php");
        exit;
    }

    # Validar prioridad
    if (!in_array($prioridad, ['alta', 'media', 'baja'])) {
        header("Location: 400.php");
        exit;
    }

    # Obtener el usuario autenticado
    $id_usuario = $_SESSION['id_usuario'];

    # Guardar la incidencia en MySQL
    try {

        $sql = "INSERT INTO incidencia
                (id_usuario, nombre, descripcion, prioridad)
                VALUES
                (:id_usuario, :nombre, :descripcion, :prioridad)";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ':id_usuario' => $id_usuario,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':prioridad' => $prioridad
        ]);

        # Incidencia registrada correctamente
        header("Location: 201.php");
        exit;

    } catch (PDOException $e) {

        # Error al guardar en la BDD
        header("Location: 500.php");
        exit;
    }
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registrar Incidencia</title>
    </head>

    <body>

        <h1>Sistema de Tickets de Incidencias</h1>

        <h2>Registrar Nueva Incidencia</h2>

        <h3>
            Bienvenido <?php echo htmlspecialchars($_SESSION['nombre']); ?>
        </h3>

        <p>
            <a href="cerrar_sesion.php">Cerrar Sesion</a>
        </p>

        <hr>

        <form method="POST" action="registrar.php">
            <fieldset>

                Nombre:<br>
                <input type="text" name="nombre" maxlength="150" required>
                <br><br>

                Descripción:<br>
                <textarea name="descripcion" rows="5" cols="40" required></textarea>
                <br><br>

                Prioridad:<br>
                <select name="prioridad" required>
                    <option value="">Seleccione una prioridad</option>
                    <option value="alta">Alta</option>
                    <option value="media">Media</option>
                    <option value="baja">Baja</option>
                </select>

                <br><br>

                <input type="submit" value="Registrar Incidencia">

            </fieldset>
        </form>

        <br>

        <a href="listar.php">Regresar al listado</a>

    </body>
</html>
