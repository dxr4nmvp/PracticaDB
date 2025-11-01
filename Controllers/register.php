
<?php
session_start();
include "../Models/db.php";

// Inicializar la variable mensaje
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = 'estudiante';

    if (empty($username)) { $mensaje = "<div class='error'>El usuario no puede estar vacio.</div>";  }
    elseif (strlen($username) > 15) { $mensaje = "<div class='error'>El usuario no puede tener más de 15 caracteres.</div>"; }
    elseif (strlen($username) < 3) { $mensaje = "<div class='error'>El usuario no puede ser tan corto.</div>"; }
    elseif (empty($password)) {$mensaje = "<div class='error'>La contraseña no puede estar vacia.</div>"; }
    elseif (strlen($password) > 15) { $mensaje = "<div class='error'>La contraseña puede tener mas de 15 carácteres.</div>"; }
    elseif (strlen($password) < 5) { $mensaje = "<div class='error'>La contraseña no puede ser tan corta.</div>"; } else {

        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $sqlCheck = "SELECT * FROM Usuarios WHERE username = ?";
        $stmtCheck = $dbconnect->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $username);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $mensaje =  "<div class='error'>Este usuario ya existe.<div>";
        } else {
            $_SESSION["new_user"] = $username;
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuarios (username, password, role) VALUES (?, ?, ?)";
    $stmt = $dbconnect->prepare($sql);
    $stmt->bind_param("sss", $username, $passwordHash, $role);
    
    if ($stmt->execute()) {
        $mensaje = "<div class='success'>Usuario registrado con exito.<div>";
        header("Location: afteregister.php");
        exit();
    } else {
        $mensaje = "<div class='error'>Error al registrar intenta de nuevo.</div>";
    }
    $stmt->close();
}
$stmtCheck->close();
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
            max-width: 500px;
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
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 5px solid #28a745;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            animation: slideInBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 5px solid #dc3545;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            animation: shakeSlideIn 0.6s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        @keyframes slideInBounce {
            0% {
                opacity: 0;
                transform: translateY(-30px) scale(0.8);
            }
            50% {
                transform: translateY(5px) scale(1.05);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes shakeSlideIn {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }
            25% {
                transform: translateX(10px);
            }
            50% {
                transform: translateX(-5px);
            }
            75% {
                transform: translateX(5px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .success::before,
        .error::before {
            font-size: 1.2em;
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