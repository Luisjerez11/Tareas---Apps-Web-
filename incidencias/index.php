
<?php

session_start();
require_once "conexion.php";

# Si el usuario ya inició sesión
if (isset($_SESSION['id_usuario'])) {
    header("Location: listar.php");
    exit;
}

# Definición de variables
$nombre = $_COOKIE['c_nombre'] ?? '';
$clave = "";
$error = "";
$recordarme = isset($_COOKIE['c_nombre']);

# Verificar si el formulario fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    # Recibir los parámetros del formulario
    $nombre = $_POST['nombre'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $recordarme = isset($_POST['chkRecordarme']);

    # Validar los campos
    if (is_string($nombre) && is_string($clave) &&
        trim($nombre) != '' && $clave != '') {

        $nombre = trim($nombre);

        # Buscar el usuario en MySQL
        $sql = "SELECT * FROM usuario WHERE nombre = :nombre";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([':nombre' => $nombre]);

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        # Verificar usuario y contraseña
        if ($usuario && $clave === $usuario['clave']) {

            # Comprobar si marcó Recordar mi usuario
            if ($recordarme) {

                # Guardar el nombre durante 30 días
                setcookie('c_nombre', $nombre, [
                    'expires' => time() + 30 * 24 * 60 * 60,
                    'path' => '/',
                    'httponly' => true,
                    'secure' => !empty($_SERVER['HTTPS']),
                    'samesite' => 'Lax'
                ]);

            } else {

                # Eliminar la cookie si no marcó recordar
                setcookie('c_nombre', '', [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'httponly' => true,
                    'secure' => !empty($_SERVER['HTTPS']),
                    'samesite' => 'Lax'
                ]);
            }

            # Crear sesión del usuario autenticado
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
                <input type="text" name="nombre"
                    value="<?php
                        echo htmlspecialchars(
                            is_string($nombre) ? $nombre : ''
                        );
                    ?>" required>
                <br><br>

                Clave:<br>
                <input type="password" name="clave" required>
                <br><br>

                <input type="checkbox" name="chkRecordarme"
                    <?php
                    if ($recordarme) {
                        echo "checked";
                    }
                    ?>>
                Recordar mi usuario

                <br><br>

                <input type="submit" value="Ingresar">

            </fieldset>
        </form>

        <p><?php echo htmlspecialchars($error); ?></p>

    </body>
</html>
