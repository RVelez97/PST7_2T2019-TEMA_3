<?php
include "conexion.php";
 $valor = $_POST['eliminar'];
echo $valor;


 $conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

 if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

$no="no";
$actualizar="update $productos set mostrar = '$no' where codigo='$valor'";
$resultadoAct=$conexion->query($actualizar);
header("Location: panel-control.php");


?>
