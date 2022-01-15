<?php
//Credenciales de la Base de Datos
define('DB_USUARIO', 'b1b5a012518fa2');
define('DB_PASSWORD', '57d4febf');
define('DB_HOST', 'us-cdbr-east-05.cleardb.net');
define('DB_NOMBRE', 'heroku_17195f454ac627a');

$con = new mysqli(DB_HOST, DB_USUARIO, DB_PASSWORD, DB_NOMBRE /*, puerto(opcional)*/);

// echo $con->ping(); //Sirve para probar la conexion a la BD, si es 1 se conecto correctamente
