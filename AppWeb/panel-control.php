


<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

} else {
   echo "Inicia Sesion para acceder a este contenido.<br>";
   echo "<br><a href='login.html'>Login</a>";
   echo "<br><br><a href='index.html'>Registrarme</a>";
   header('Location: index.html');//redirige a la página de login si el usuario quiere ingresar sin iniciar sesion


exit;
}

$now = time();


if($now > $_SESSION['expire']) {
session_destroy();
header('Location: index.html');//redirige a la página de login
echo "Tu sesion ha expirado,
<a href='login.html'>Inicia Sesion</a>";
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Perfil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--eliminacion de los subrayados en los links-->
  <style type="text/css"> 
  a:link 
  { 
  text-decoration:none; 
  } 
  </style>

</head>
<body>

<div class="jumbotron text-center">
  <h1>Bienvenido <?php echo  $_SESSION['username'];?></h1>
 
  <a href=logout.php><button type="button" class="btn btn-success"> Cerrar Sesion</button></a>
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-4">
	<!--boton para aumentar una maquina mas-->
      <button type=button onclick="location.href='formularioRegistroMaquina.html'" >Anadir maquina</button>
    </div>
    
  </div>

</div>

</body>
</html>

