<?php
// Incluyo las credenciales desde el archivo config
include_once './config/config.php';
//Si nos han mandado los datos del formulario....
if (isset($_POST['submit'])) {
	//Login mandado en el formulario
	$login = $_POST['login'];
	//Password mandada en el formulario
	$user_password = $_POST['password'];
	echo "Login es $login y password es $user_password";
	//Conexión con BD
	$conexion = mysqli_connect($host, $user, $password, $db, $port) or die("Fallo conectando");
	//Consulta que devuelve todos los usuarios con ese login
	$query = "SELECT * FROM usuarios WHERE usuario = '$login' ";
	//Hago la consulta y el resultado lo guardo en la variable usuario
	$usuario = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
	//Extraigo la información para obtener directamente los valores en un array asociativo
	$usuario = mysqli_fetch_array($usuario, MYSQLI_ASSOC);
	if (!$usuario) {
		//Si no se encuentra usuario con ese login
		die("Este usuario no existe");
	}
	//Guardo en contraseña encontrada,la contraseña del usuario encontrado en la consulta
	$contraseña_encontrada = $usuario['contrasena'];
	if (sha1($user_password) !== $contraseña_encontrada) {
		/*Si el hash de la contraseña mandada
		y la contraseña contenida en la bd no son iguales...
		*/
		die("contraseña incorrecta");
	}

	// Siempre session_start antes de trabajar con las sesiones
	session_start();
	//Creo una sesión con el rol del usuario
	$_SESSION['rol'] = $usuario['rol'];
	// Lo mando a segura
	header("LOCATION:./autenticado/segura.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="./css/estilo.css">
	<title>ExamenJSPHP</title>
</head>

<body>
	<div class="enunciados">
		1.- Configure convenientemente el fichero config.php para implantar
		la aplicacion web. (0,5p)<br>

		2.- <a href="instalar/instala.php"> Instala la BD </a> </br>

		3.- Cree un formulario en esta página para autenticar al usuario.<br />
		3.1 Campos login, password y boton de envío (0,5p).<br />
		3.2 Configure las funciones javascript necesarias para que el login y el pasword no puedan ser vacios
		y password no contenga a login. Deba crear estas funciones en el fichero ./javascript/script.js e
		incorporelas para utilizarlas en este (1.5p).<br>
		4.- Cree el control de autenticación en este mismo archivo "index.php" (código php), es decir,
		consultar la BD, crear la sesión y sus variables para poder acceder a segura.php (1,5p)
		<br>
		5.- Una vez autenticado cree una página ./autenticado/segura.php que requiera
		sesion con rol de administrador para visualizar la gestión de usuarios. (1p)
		<br> 5.1 un formulario de inserción de usuarios en la BD (2p si inserta)
		<br> 5.2 una tabla donde los muestre (1p), pueda borrarlos (es decir,un enlace que borre la fila)(1p si borra).
		<br>6.- Cree salir.php y un enlace en segura.php llamado salir que cierre la sesión activa y mande a index.php (0.5p)
		<br>7.- Cree la estructura de css en fichero ./css/estilo.css para la clase "enunciados" para se vea con
		fondo.jpg, color de letra rojo, el div formulario del archivo "index.php' con fondo verde y ocupando el 10% d
		e a la derecha de la página (0.5p)

		Una vez acabado, comprima la carpeta en formato zip, sunombre.zip y siga las indicaciones del profesor para entregarlo.


	</div>
	<div class="formulario">

		<form id="formulario" method="POST">
			<label for="login">Nombre de usuario</label>
			<input id="login" name="login" type="text">
			<label for="password">Contraseña</label>
			<input id="password" type="password" name="password">
			<input type="submit" name="submit" value="Enviar">
		</form>

	</div>
	<script src="./javascript/javascript.js"></script>
</body>

</html>