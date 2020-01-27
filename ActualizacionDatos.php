<?php
//este script se ejecutara por medio de cron
//este script actualizara la informacion de la base de datos 
include "AppWeb/conexion.php";
$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
$consulta= "select*from $productos";
$resultado=$conexion->query($consulta);
mysqli_data_seek($resultado,0);
while($filas=$resultado->fetch_row()){
$f=date_create($filas[4])->format('Y-m-d');
$fecha=strtotime($f);
$fa=date_create(date('Y-m-d',time()))->format('Y-m-d');
$fechaActual=strtotime($fa);
$cod=$filas[0];
$difDias=date_create($filas[4])->diff(date_create(date('Y-m-d')));
$precio=floatval($filas[6]);
$estado=$filas[7];

if(($difDias->days)<=7 and ($estado!= "mod") and ($fechaActual<$fecha)){
echo$f."Ultima semana\n";
$precio=$precio*0.5;
$estado="mod";
$actualizar="update $productos set precFInal= '$precio', estado= '$estado' where codigo='$cod'";
$resultadoAct=$conexion->query($actualizar);

}
else if(($fechaActual>$fecha)  and ($estado!= "mod")){
echo $f."Caduco\n";
$precio=$precio*0;
$estado="cad";
$actualizar="update $productos set precFInal= '$precio', estado= '$estado' where codigo='$cod'";
$resultadoAct=$conexion->query($actualizar);

}
else{
echo $f."Aun apto\n";
}
}

?>
