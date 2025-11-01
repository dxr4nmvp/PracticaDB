[1mdiff --git a/Models/db.php b/Models/db.php[m
[1mindex 8ffc02c..15a9327 100644[m
[1m--- a/Models/db.php[m
[1m+++ b/Models/db.php[m
[36m@@ -1,3 +1,4 @@[m
[32m+[m
 <?php[m
 $server = "localhost";[m
 $user = "root";[m
[36m@@ -7,10 +8,32 @@[m [m$db = "sistema_educativo";[m
 $dbconnect = new mysqli($server, $user, $password, $db);[m
 [m
 if ($dbconnect->connect_error) {[m
[31m-    die("Error al conectarse con la base de datos" . $dbconnect->connect_error);[m
[31m-}[m
[31m-else {[m
[31m-    echo "Base de datos actual: $db";[m
[32m+[m[32m    die("<div style='[m
[32m+[m[32m        background-color: #f8d7da;[m[41m [m
[32m+[m[32m        color: #721c24;[m[41m [m
[32m+[m[32m        padding: 10px;[m[41m [m
[32m+[m[32m        border-radius: 5px;[m[41m [m
[32m+[m[32m        position: fixed;[m[41m [m
[32m+[m[32m        bottom: 10px;[m[41m [m
[32m+[m[32m        right: 10px;[m[41m [m
[32m+[m[32m        box-shadow: 0 2px 4px rgba(0,0,0,0.1);[m
[32m+[m[32m        font-family: Arial, sans-serif;[m
[32m+[m[32m        z-index: 1000;[m
[32m+[m[32m        '>Error de conexión: " . $dbconnect->connect_error . "</div>");[m
[32m+[m[32m} else {[m
[32m+[m[32m    echo "<div style='[m
[32m+[m[32m        background-color: #d4edda;[m[41m [m
[32m+[m[32m        color: #155724;[m[41m [m
[32m+[m[32m        padding: 10px;[m[41m [m
[32m+[m[32m        border-radius: 5px;[m[41m [m
[32m+[m[32m        position: fixed;[m[41m [m
[32m+[m[32m        bottom: 10px;[m[41m [m
[32m+[m[32m        right: 10px;[m[41m [m
[32m+[m[32m        box-shadow: 0 2px 4px rgba(0,0,0,0.1);[m
[32m+[m[32m        font-family: Arial, sans-serif;[m
[32m+[m[32m        z-index: 1000;[m
[32m+[m[32m        opacity: 0.9;[m
[32m+[m[32m        font-size: 14px;[m
[32m+[m[32m        '>✓ Conectado a: $db</div>";[m
 }[m
[31m-[m
 ?>[m
\ No newline at end of file[m
[1mdiff --git a/index.php b/index.php[m
[1mindex 8356e53..6791931 100644[m
[1m--- a/index.php[m
[1m+++ b/index.php[m
[36m@@ -120,11 +120,17 @@[m
 [m
         <div class="options">[m
             <div class="card">[m
[31m-                <h3>Agregar Estudiante</h3>[m
[32m+[m[32m                <h3>➕ Agregar Estudiante</h3>[m
                 <p>Registra un nuevo estudiante con su nombre, matrícula y carrera.</p>[m
                 <a href="Controllers/addStudent.php">Ir</a>[m
             </div>[m
 [m
[32m+[m[32m             <div class="card">[m
[32m+[m[32m                <h3>👤 Registro</h3>[m
[32m+[m[32m                <p>Crea una cuenta nueva para acceder al sistema.</p>[m
[32m+[m[32m                <a href="Controllers/registerStudent.php">Registrarse</a>[m
[32m+[m[32m            </div>[m
[32m+[m
             <div class="card">[m
                 <h3>📋 Ver Estudiantes</h3>[m
                 <p>Consulta la lista de estudiantes registrados en la base de datos.</p>[m
