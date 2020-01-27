


<?php
session_start();


include 'conexion.php';

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
  <h1>Bienvenido <?php echo  $_SESSION['username'];

$usuario=$_SESSION['username'];?></h1>
 
  <a href=logout.php><button type="button" class="btn btn-success"> Cerrar Sesion</button></a>
</div>

<div>
<?php
$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

$consulta="SELECT * FROM $tbl_name WHERE correo = '$usuario'";
$resultado=$conexion->query($consulta);

$filas=$resultado->fetch_array(MYSQLI_ASSOC);
$maquinas=$filas['maquinas'];
//se obtienen todos los codigos de las maquinas que pertenecen al usuario que incio la sesion
$listadoCods=explode(",",$maquinas);
//si el usuario tiene maquinas se procede a mostrar la info

if($maquinas!=null){

for($i=0;$i<count($listadoCods);$i++){

//otra consulta para colocar la info de los productos
$consultaProd="select * from productos where codMaquina = '$listadoCods[$i]'";


$resultadoProd=$conexion->query($consultaProd);


$flag=$resultadoProd;


if($resultadoProd->fetch_row()!=null){
echo "<div>
<h1>Maquina $listadoCods[$i]</h1>
<table>
<tr><td>Codigo</td><td>Producto</td><td>Precio</td><td>Estado</td><td></td></tr>
</table>
</div>";
mysqli_data_seek($resultadoProd,0);
while($filasProd=$resultadoProd->fetch_row()){
$cod=$filasProd[0];
$nom=$filasProd[2];
$pre=$filasProd[6];
$est=$filasProd[7];
if($filasProd[8]=="si"){
if($est=="cad"){
$ref="location.href='borrarProd.php'";
$s1="eliminar";
$s2="borrarProd.php";
$s3="post";
$s4="submit";
echo "<div><table>
<tr><td>$cod</td><td>$nom</td><td>$ $pre</td><td>$est</td><td>
<form  action='$s2' method='$s3'>
<button type= '$s4' onclick='$ref' name='$s1' value='$cod'>Eliminar</button></form>

</td></tr>";
}else{
echo "<div><table>
<tr><td>$cod</td><td>$nom</td><td>$ $pre</td><td>$est</td><td></td></tr>";
}
}
}
?>
</table></div>
<?php



}else{

echo "<div>
<h1>Maquina $listadoCods[$i]</h1>
<table>
<h3>Esta maquina no posee productos en venta! </h3>
</table>
</div>";
}
}
}
//se muestra que aun no hay maquinas registradas
else{
echo "<div>
<h1>Aun no tiene maquinas registradas</h1>
</div>";
}



?>
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


