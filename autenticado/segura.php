//Requiere Seguridad con rol de administrador
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Siempre session_start antes de trabajar con las sesiones
session_start();
// Si no tiene sesión(No inición sesión) O el rol de su sesión no es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
	//Lo mando a la página principal
	header("LOCATION:../index.php");
}
require_once '../config/config.php';



#Recibo el submit para crear un nuevo usuario
if (isset($_POST['submit'])) {
	$usuario = $_POST['usuario'];
	$sent_password = sha1($_POST['password']);
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$rol = $_POST['rol'];
	# Lo inserto con sus datos
	$conexion = mysqli_connect($host, $user, $password, $db, $port) or die("error conectando a la bd");
	$query = "INSERT INTO usuarios VALUES ('$usuario','$sent_password','$nombre','$apellidos','$rol') ";
	mysqli_query($conexion, $query) or die(mysqli_error($conexion));
}

if (isset($_GET['usuario'])) {
	#Recibo una petición de tipo GET para borrar un usuario
	$conexion = mysqli_connect($host, $user, $password, $db, $port) or die("error conectando a la bd");
	$usuario_a_borrar = $_GET['usuario'];
	$borrado = "DELETE FROM usuarios WHERE usuario = '$usuario_a_borrar'";
	mysqli_query($conexion, $borrado) or die(mysqli_error($conexion));
	header("LOCATION:./segura.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	<h1>Estas en admin</h1>
	<p>Crea un usuario</p>
	<form method="POST">
		<p>Usuario</p>
		<input type="text" required name="usuario">
		<p>Contraseña</p>
		<input type="password" required name="password">
		<p>Nombre</p>
		<input type="text" required name="nombre">
		<p>Apellidos</p>
		<input type="text" required name="apellidos">
		<p>Rol</p>
		<select name="rol">
			<optgroup>
				<option value="administrador">Administrador</option>
				<option value="registrado">Registrado</option>
			</optgroup>
		</select>
		<input name="submit" type="submit" value="Enviar">
	</form>

	<table>
		<thead>
			<tr>
				<td>Usuario</td>
				<td>Nombre</td>
				<td>Apellidos</td>
				<td>Rol</td>
				<td>Borrar</td>
			</tr>
		</thead>
		<tbody>
			<?php
			require_once '../config/config.php';
			//Recibo todos los usuarios con una consulta
			$conexion = mysqli_connect($host, $user, $password, $db, $port) or die("error conectando a la bd");
			$query2 = "SELECT usuario,nombre,apellidos,rol FROM usuarios";
			$datos = mysqli_query($conexion, $query2);
			$datos = mysqli_fetch_all($datos, MYSQLI_ASSOC);
			foreach ($datos as $value) {
				//Por cada usuario genero una fila
				echo "<tr>";
				foreach ($value as $value2) {
					//Por cada valor del usuario genero un celda con sus propiedades
					echo "<td> $value2 </td>";
				}
				//Mando una petición get para borrar con su nombre de usuario
				echo "<td><a href='?usuario=$value[usuario]'>Borrar</a></td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>

	<a href="./salir.php">Salirte</a>
</body>



</html>