<?php
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION["user"])) {
    // No hay sesión activa
    $mensaje = "⚠️ No has iniciado sesión para poder cerrarla.";
    $tipo = "warning";
} else {
    // Hay sesión activa, proceder a cerrarla
    $usuario = $_SESSION["user"]; // Guardar el nombre de usuario antes de destruir la sesión
    session_destroy();
    $mensaje = "✅ Has cerrado sesión correctamente. ¡Hasta pronto, {$usuario}!";
    $tipo = "success";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrando Sesión</title>
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
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .success {
            border-left: 5px solid #28a745;
        }

        .warning {
            border-left: 5px solid #ffc107;
        }

        .countdown {
            margin-top: 10px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
    <script>
    window.onload = function() {
        let seconds = 5;
        const countdownElement = document.getElementById('countdown'); // Corregido aquí
        
        const interval = setInterval(function() {
            seconds--;
            countdownElement.textContent = `Redirigiendo en ${seconds} segundos...`;
            
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
        <h2><?php echo $mensaje; ?></h2>
        <div class="countdown" id="countdown">Redirigiendo en 5 segundos...</div>
    </div>
</body>
</html>