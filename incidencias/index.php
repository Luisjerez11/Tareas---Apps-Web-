
<?php

session_start();
require_once "conexion.php";

# Si el usuario ya inició sesión
if (isset($_SESSION['id_usuario'])) {
    header("Location: listar.php");
    exit;
}

# Definición de variables
$nombre = "";
$clave = "";
$error = "";

# Verificar si el formulario fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    # Recibir los parámetros del formulario
    $nombre = $_POST['nombre'] ?? '';
    $clave = $_POST['clave'] ?? '';

    # Validar los campos
    if (is_string($nombre) && is_string($clave) &&
        trim($nombre) != '' && $clave != '') {

        $nombre = trim($nombre);

        # Buscar el usuario en la BDD MySQL
        $sql = "SELECT * FROM usuario WHERE nombre = :nombre";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([':nombre' => $nombre]);

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        # Verificar usuario y contraseña
        if ($usuario && $clave === $usuario['clave']) {

            # Iniciar la sesión del usuario autenticado
            session_regenerate_id(true);

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];

            # Redireccionar al listado
            header("Location: listar.php");
            exit;

        } else {
            $error = "Usuario o contraseña incorrectos";
        }

    } else {
        $error = "Debe ingresar usuario y contraseña";
    }
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de Tickets</title>
    </head>

    <body>

        <h1>Sistema de Tickets de Incidencias</h1>
        <h2>Acceso al Sistema</h2>

        <form method="POST" action="index.php">
            <fieldset>

                Usuario:<br>
                <input type="text" name="nombre" required>
                <br><br>

                Clave:<br>
                <input type="password" name="clave" required>
                <br><br>

                <input type="submit" value="Ingresar">

            </fieldset>
        </form>

        <p><?php echo htmlspecialchars($error); ?></p>

    </body>
</html>
