
<?php
include "../Models/db.php";

// Inicializar la variable mensaje
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuarios (username, password) VALUES (?, ?)";
    $stmt = $dbconnect->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        $mensaje = "<div class='success'>Usuario registrado con éxito.</div>";
    } else {
        $mensaje = "<div class='error'>Un error ha ocurrido</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(-45deg, #007bff, #00bcd4, #00c6ff, #007bff);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background: #fff;
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            padding: 40px;
            text-align: center;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #007bff;
            margin-bottom: 25px;
            font-size: 2em;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
            outline: none;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 15px;
        }

        button:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        a {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 0.9em;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .nav-links {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 Registro</h2>
        
        <?php if ($mensaje): ?>
            <?php echo $mensaje; ?>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>

        <div class="nav-links">
            <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
            <a href="../index.php">Volver al inicio</a>
        </div>
    </div>
</body>
</html>