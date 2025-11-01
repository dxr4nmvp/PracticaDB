<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Conexión a la DB sistema_educativo
include "../Models/db.php";

/* Variables que manejan errores y los mensajes de éxito */
$errores = [];
$exito = "";
$nombre = $apellido = $matricula = $carrera = '';

// Procesar formulario cuando sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $matricula = trim($_POST['matricula'] ?? '');
    $carrera = trim($_POST['carrera'] ?? '');

    // Validaciones
    if ($nombre === '') { $errores[] = "El nombre es obligatorio."; }
    elseif (strlen($nombre) > 50) { $errores[] = "El nombre no puede tener más de 50 caracteres."; }

    if ($apellido === '') { $errores[] = "El apellido es obligatorio."; }
    elseif (strlen($apellido) > 50) { $errores[] = "El apellido no puede tener más de 50 caracteres."; }

    if ($matricula === '') { $errores[] = "La matrícula es obligatoria."; }
    elseif (strlen($matricula) > 7) { $errores[] = "La matrícula no puede tener más de 5 caracteres."; }
    elseif (!preg_match('/^[A-Za-z0-9\-]+$/', $matricula)) { $errores[] = "La matrícula contiene caracteres inválidos."; }

    if ($carrera === '') { $errores[] = "La carrera es obligatoria."; }
    elseif (strlen($carrera) > 50) { $errores[] = "La carrera no puede tener más de 50 caracteres."; }

    if (empty($errores)) {
        $stmt = $dbconnect->prepare(
            "INSERT INTO estudiantes (nombre, apellido, matricula, carrera) VALUES (?, ?, ?, ?)"
        );

        if ($stmt === false) {
            $errores[] = "Error al preparar la consulta: " . $dbconnect->error;
        } else {
            $stmt->bind_param('ssss', $nombre, $apellido, $matricula, $carrera);
            if ($stmt->execute()) {
                $exito = "Estudiante agregado con éxito. ID: " . $stmt->insert_id;
                $nombre = $apellido = $matricula = $carrera = '';
            } else {
                if ($stmt->errno == 1062) { $errores[] = "Ya existe esa matrícula en la base de datos."; }
                else { $errores[] = "Error al insertar: " . $stmt->error; }
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estudiante</title>
    <style>
        /* ===== ESTILO GENERAL ===== */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(-45deg, #007bff, #00bcd4, #00c6ff, #007bff);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 40px 10px;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background: #fff;
            width: 100%;
            max-width: 480px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            padding: 30px;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        input[type=text] {
            width: 100%;
            padding: 10px;
            margin: 6px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            transition: 0.3s;
        }
        input[type=text]:focus { border-color: #007bff; outline: none; }

        .error, .success {
            padding: 12px;
            margin-bottom: 16px;
            border-left: 4px solid;
            border-radius: 6px;
        }
        .error { background: #ffdddd; border-color: #f44336; }
        .success { background: #ddffdd; border-color: #4CAF50; }

        /* ===== BOTONES ===== */
        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            color: #fff;
            background: #007bff;
            border: 1px solid #007bff;
            transition: 0.3s;
            margin-top: 6px;
        }
        .btn:hover { background: #0056b3; border-color: #0056b3; }
        .btn.secondary { background: #6c757d; border-color: #6c757d; }
        .btn.secondary:hover { background: #545b62; border-color: #545b62; }

        /* ===== NAVEGACIÓN ===== */
        .nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }
        .nav a {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            color: #fff;
            background: #007bff;
            transition: 0.3s;
        }
        .nav a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>➕ Agregar Estudiante</h2>

        <!-- Navegación -->
        <div class="nav">
            <a href="../index.php">🏠 Inicio</a>
            <a href="../Views/StudentsViews.php">📂 Ver / Gestionar</a>
        </div>

        <!-- Mensajes -->
        <?php if (!empty($errores)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errores as $e): ?>
                        <li><?php echo htmlspecialchars($e, ENT_QUOTES); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($exito): ?>
            <div class="success"><?php echo htmlspecialchars($exito, ENT_QUOTES); ?></div>
        <?php endif; ?>

        <!-- Formulario -->
        <form method="post" action="">
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre ?? '', ENT_QUOTES); ?>" required>

            <label>Apellido</label>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($apellido ?? '', ENT_QUOTES); ?>" required>

            <label>Matrícula</label>
            <input type="text" name="matricula" value="<?php echo htmlspecialchars($matricula ?? '', ENT_QUOTES); ?>" required>

            <label>Carrera</label>
            <input type="text" name="carrera" value="<?php echo htmlspecialchars($carrera ?? '', ENT_QUOTES); ?>" required>

            <input type="submit" value="Guardar" class="btn">
        </form>
    </div>
</body>
</html>
