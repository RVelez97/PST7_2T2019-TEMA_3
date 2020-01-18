
<?php
//incluimos el archivo donde se encuentran los datos de nuestra db
 include 'conexion.php';
 
 $form_pass = $_POST['password'];
$form_correo=$_POST['email'];
 $form_name = $_POST['name'];
$form_adress=$_POST['adress'];
 
 $conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

 if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

//se intenta buscar si ya existe un usuario registrado con ese correo
 $buscarUsuario = "SELECT * FROM $tbl_name
 WHERE correo = '$_POST[email]' ";

 $result = $conexion->query($buscarUsuario);
//se hace el conteo de las filas donde aparece
 $count = mysqli_num_rows($result);
//si ya esta registrado se muestra un mensaje que advierte la situacion
 if ($count == 1) {
 echo "<br />". "Un usuario ya se encuentra registrado con este correo!" . "<br />";

 echo "<a href='index.html'>Por favor registrese con un correo diferente</a>";
 }
 else{
//se divide el nombre y apellido para obtener la primera parte del codigo
$nombres=explode(" ",$_POST['name']);
$inicioCodigo=substr($nombres[0],0,1).substr($nombres[1],0,1).'%';
//primeras iniciales
$cod_inic=substr($nombres[0],0,1).substr($nombres[1],0,1);

//se buscaran cuantos codigos  incian con las mismas iniciales
$consulta2="select *from usuarios where codigo like '$inicioCodigo' "; 
$resultado2=$conexion->query($consulta2);
$count2=mysqli_num_rows($resultado2)+1;
$codigo=$cod_inic. sprintf("%03d",$count2);



$cargar = "INSERT INTO usuarios (codigo,nombre, correo,contrasenia,direccion,maquinas) VALUES        ('$codigo','$form_name','$form_correo','$form_pass','$form_adress','')";
 if ($conexion->query($cargar) === TRUE) {
 header('Location: index.html');
  
 }

 else {
 echo "Error: " . $cargar . "<br>" . $conn->error;
   }
 }
 mysqli_close($conexion);
?>
