
<?php
session_start();
?>

<?php

include 'conexion.php';

$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
 
$sql = "SELECT * FROM $tbl_name WHERE correo = '$username'";


$result = $conexion->query($sql);


if ($result->num_rows > 0) {     }
	
 
  $row = $result->fetch_array(MYSQLI_ASSOC);
 // if (password_verify($password, $row['password'])) { 
if ($password==$row['contrasenia']) { 

 
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (20 * 60);

    echo "Bienvenido! " . $_SESSION['username'];
    echo "<br><br><a href=panel-control.php>Panel de Control</a>"; 
    header('Location: panel-control.php');//redirecciona a la pagina del usuario

 } else { 
   echo "Username o Password estan incorrectos.";


   echo "<br><a href='index.html'>Volver a Intentarlo</a>";
 }
 mysqli_close($conexion); 
 ?>
