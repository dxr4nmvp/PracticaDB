
<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "sistema_educativo";

$dbconnect = new mysqli($server, $user, $password, $db);

if ($dbconnect->connect_error) {
    die("<div style='
        background-color: #f8d7da; 
        color: #721c24; 
        padding: 10px; 
        border-radius: 5px; 
        position: fixed; 
        bottom: 10px; 
        right: 10px; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        z-index: 1000;
        '>Error de conexión: " . $dbconnect->connect_error . "</div>");
} else {
    echo "<div style='
        background-color: #d4edda; 
        color: #155724; 
        padding: 10px; 
        border-radius: 5px; 
        position: fixed; 
        bottom: 10px; 
        right: 10px; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        z-index: 1000;
        opacity: 0.9;
        font-size: 14px;
        '>✓ Conectado a: $db</div>";
}
?>