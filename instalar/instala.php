<?php
/*
 *   Fichero para la implantación de la base de datos.
 * 
 */
include_once '../config/config.php';
echo "Conectando:";
$conex=mysqli_connect($host,$user,$password,NULL,$port)or die("Fallo en la conexión");
$consulta="drop database IF EXISTS `$db`;";
mysqli_query($conex,$consulta) or die("fallo al borrar la base de datos".mysqli_error($conex));
$consulta="CREATE DATABASE `$db`;";
echo "OK.<BR> Creando BD: <BR>";
mysqli_query($conex,$consulta) or die("fallo al crear la base de datos".mysqli_error($conex));
mysqli_select_db($conex,$db);
$consulta=<<<EOF
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario` varchar(30) NOT NULL,
  `contrasena` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `rol` set('administrador','registrado') NOT NULL,
   PRIMARY KEY (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
EOF;
echo "OK.<br>Creando tabla usuarios:";
mysqli_query($conex,$consulta) or die("fallo al crear la tabla usuarios.");
echo "Con la siguiente estructura <br>";
$consulta="show FIELDS FROM usuarios";
$respuesta=mysqli_query($conex,$consulta) or die("fallo al mostrar la tabla usuarios.");
while ($fila=mysqli_fetch_array($respuesta,MYSQLI_ASSOC)){
	foreach($fila as $key => $value){
		echo "$value  "; 
	}
	echo "<br>";
}

echo "OK.<br> Insertando en tabla  usuario admin 1234 usando el hashing PASWORD() de mysql:";
$consulta = "INSERT INTO `usuarios`  VALUES ('admin', SHA1('1234'),'nombredeAdmin','ApellidosDeAdmin', 'administrador');";

mysqli_query($conex,$consulta) or die("falló al insertar admin.".mysqli_error($conex));
echo "OK.<BR>";
echo "<p>Guarde o recuerde esta información para poder continuar con la realización del ejercicio </p>";
mysqli_close($conex);
