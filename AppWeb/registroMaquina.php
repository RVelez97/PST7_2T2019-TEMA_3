<?php
session_start();
?>
<?php

include 'conexion.php';
$conexion = new mysqli("$host_db", "$user_db", "$pass_db", "$db_name");

if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}


$lat=$_POST['lat'];
$lng=$_POST['lng'];
$usuario=$_SESSION['username'];

$consulta1 = "select * from $tbl_name where correo = '$usuario'";


$resultado=$conexion->query($consulta1);
$filas=$resultado->fetch_array(MYSQLI_ASSOC);

//se consigue el codigo del propietario
$codPropietario=$filas['codigo'];
$codComp=$codPropietario.'%';
//se buscaran cuantos codigos  incian con el mismo del propietario
$consulta2="select *from $tblMaq where codigo like '$codComp'";
$resultado2=$conexion->query($consulta2);
$count2=$resultado2->num_rows +1 ;



$codigo=$codPropietario. sprintf("%03d",$count2);

//se busca si el propietario tiene maquinas registradas, estas se separaran por medio de comas
$consulta3="select * from $tbl_name where correo = '$usuario'";
$resultado3=$conexion->query($consulta3);
$filas2=$resultado3->fetch_array(MYSQLI_ASSOC);
//si no hay maquinas solo se anade el codigo
if($filas2['maquinas']==""){
$codigosMaquinas=$codigo;
}else{//caso contrario se va anadiendo con una coma previo al codigo
$codigosMaquinas=$filas2['maquinas'].","."$codigo";
}
echo $codigosMaquinas;
//se cargan todos los campos en la tabla

$cargar = "insert into $tblMaq values ('$codigo','$codPropietario',$lat,$lng)";
$actualizarCodMaquinas="update $tbl_name set maquinas='$codigosMaquinas' where correo ='$usuario'";
 if (($conexion->query($cargar) and $conexion->query($actualizarCodMaquinas) ) === TRUE) {
 header('Location: avisoRegExitosoMaquina.html');
  
 }

 else {
 echo "Error: " . $cargar . "<br>" . $conn->error;
 echo "Error: " . $actualizarCodMaquinas . "<br>" . $conn->error;
   }
 
 mysqli_close($conexion);


?>
