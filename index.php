<?php
session_start(); // Agregar al inicio del archivo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Sistema Educativo</title>
    <style>
        /* ----- ESTILO GENERAL ----- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #007bff, #00bcd4);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            background: #ffffffff;
            width: 90%;
            max-width: 1250px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            padding: 40px;
            text-align: center;
            position: relative;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: #007bff;
            font-size: 2.2em;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .card {
            background: #f9f9f9;
            border-radius: 12px;
            padding: 20px;
            width: 240px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            background: #eef7ff;
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }

        .card h3 {
            color: #007bff;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 0.95em;
            color: #444;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 14px;
            border-radius: 5px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        .card a:hover {
            background: #0056b3;
        }

        footer {
            margin-top: 25px;
            color: #666;
            font-size: 0.9em;
        }

        /* Animación suave del fondo */
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #007bff, #00bcd4, #00c6ff, #007bff);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
        }

        .user-welcome {
    background: linear-gradient(to right, #e3f2fd, #bbdefb);
    padding: 12px 20px;
    border-radius: 50px;
    margin: 15px auto;
    max-width: fit-content;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 3px 10px rgba(0,123,255,0.1);
    animation: bounceIn 0.8s ease;
}

.user-welcome p {
    margin: 0;
    color: #1565c0;
    font-size: 1.1em;
}

.user-welcome .user-icon {
    font-size: 1.4em;
    animation: wave 2s infinite;
    display: inline-block;
}

@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
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
</head>
<body>
    <div class="container">
        <h1>🎓 Sistema Educativo</h1>
        
        <?php if(isset($_SESSION["user"])): ?>
            <div class="user-welcome">
                <span class="user-icon">👋</span>
                <p>¡Hola, <strong><?php echo htmlspecialchars($_SESSION["user"]); ?></strong>!</p>
            </div>
        <?php endif; ?>

        <p>Bienvenido al panel principal. Aquí puedes gestionar estudiantes, ver registros y administrar tu base de datos fácilmente.</p>

        <div class="options">
            <div class="card">
                <h3>➕ Agregar Estudiante</h3>
                <p>Registra un nuevo estudiante con su nombre, matrícula y carrera.</p>
                <a href="Controllers/addStudent.php">Ir</a>
            </div>

             <div class="card">
                <h3>👤 Registro</h3>
                <p>Crea una cuenta nueva para acceder al sistema.</p>
                <a href="Controllers/register.php">Registrarse</a>
            </div>

            <div class="card">
                <h3>🔑 Iniciar Sesión</h3>
                <p>Accede a tu cuenta para desbloquear ciertos privilegios.</p>
                <a href="Controllers/login.php">Iniciar Sesión</a>
            </div>
            
            <div class="card">
                <h3>🔑 Cerrar Sesión</h3>
                <p>Cierra tu sesión de forma segura.</p>
                <a href="Controllers/logout.php">Cerrar Sesión</a>
            </div>

            <div class="card">
                <h3>📋 Ver Estudiantes</h3>
                <p>Consulta la lista de estudiantes registrados en la base de datos.</p>
                <a href="Views/StudentsViews.php">Ver</a>
            </div>

            <div class="card">
                <h3>📝 Editar / Eliminar</h3>
                <p>Modifica o borra estudiantes existentes fácilmente.</p>
                <a href="Views/StudentsViews.php">Gestionar</a>
            </div>

            <div class="card">
                <h3>ℹ️ Acerca del Proyecto</h3>
                <p>Proyecto educativo desarrollado en PHP y MySQL. En base al material RA2.1 CE2.1.3 Selección de Motores de Base de Datos</p>
                <a href="#info">Más Info</a>
            </div>
        </div>

        <footer>
            © <?php echo date("Y"); ?> Sistema Educativo - Editado y desarrollado por <strong>Cristopher Duran</strong>
        </footer>
    </div>
</body>
</html>
