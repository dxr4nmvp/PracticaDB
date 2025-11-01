<?php
session_start();

// Verificar si viene de un login exitoso
if (isset($_SESSION["login_success"]) && isset($_SESSION["user"])) {
    $usuario = $_SESSION["user"];
    $mensaje = "✅ ¡Bienvenido de nuevo, {$usuario}!";
    $tipo = "success";
    unset($_SESSION["login_success"]); // Limpiar   la bandera
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Exitoso</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(-45deg, #007bff, #00bcd4, #00c6ff, #007bff);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .alert {
            background: white;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            text-align: center;
            animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        .success {
            border-left: 5px solid #28a745;
        }

        .countdown {
            margin-top: 15px;
            font-size: 0.9em;
            color: #666;
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .wave-emoji {
            font-size: 1.5em;
            display: inline-block;
            animation: wave 2s infinite;
        }

        @keyframes wave {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
    </style>
    <script>
        window.onload = function() {
            let seconds = 5;
            const countdownElement = document.getElementById('countdown');
            
            const interval = setInterval(function() {
                seconds--;
                countdownElement.textContent = `Redirigiendo al inicio en ${seconds} segundos...`;
                
                if (seconds <= 0) {
                    clearInterval(interval);
                    window.location.href = '../index.php';
                }
            }, 1000);
        }
    </script>
</head>
<body>
    <div class="alert <?php echo $tipo; ?>">
        <span class="wave-emoji">👋</span>
        <h2><?php echo $mensaje; ?></h2>
        <div class="countdown" id="countdown">Redirigiendo al inicio en 5 segundos...</div>
    </div>
</body>
</html>