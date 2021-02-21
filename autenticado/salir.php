<?php
// Siempre session_start antes de trabajar con las sesiones
session_start();
//Destruyo la sesión para cerrar sesión
session_destroy();
//Lo mando a la página principal
header("LOCATION: ../index.php");
