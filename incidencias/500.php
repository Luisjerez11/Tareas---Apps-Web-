
<?php

session_start();

# Verificar si el usuario inició sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

# Establecer código HTTP 500
http_response_code(500);

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Error 500</title>
    </head>

    <body>

        <h1>Error 500 - Internal Server Error</h1>

        <h3>
            Bienvenido <?php echo htmlspecialchars($_SESSION['nombre']); ?>
        </h3>

        <p>Ocurrió un problema con la base de datos.</p>

        <p>
            <a href="cerrar_sesion.php">
                Cerrar Sesion y regresar al Login
            </a>
        </p>

    </body>
</html>
