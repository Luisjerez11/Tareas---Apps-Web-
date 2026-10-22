<?php

# Iniciar o recuperar la sesión
session_start();

# Eliminar las variables de sesión
session_unset();

# Destruir la sesión
session_destroy();

# Redireccionar al login
header("Location: index.php");
exit;

?>
