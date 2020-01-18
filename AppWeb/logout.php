
<?php

session_start();
unset ($SESSION['username']);
//se elimina la sesion
session_destroy();
//se redirecciona al usuario a la pagina principal de login
header('Location: index.html');

?>
