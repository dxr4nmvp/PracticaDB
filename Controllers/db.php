<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "sistema_educativo";

$dbconnect = new mysqli($server, $user, $password, $db);

if ($dbconnect->connect_error) {
    die("Error al conectarse con la base de datos" . $dbconnect->connect_error);
}
else {
    echo "Base de datos actual: $db";
}

?>