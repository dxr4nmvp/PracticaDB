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

<?php
include "../Models/db.php";

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$errores = [];
$exito = "";
$nombre = $apellido = $matricula = $carrera = '';
$edit_id = (int)($_GET['edit_id'] ?? 0);

// Verificar si el ID es válido
if ($edit_id <= 0) {
    die("ID inválido.");
}

// Cargar datos actuales del estudiante
$stmt = $dbconnect->prepare("SELECT nombre, apellido, matricula, carrera FROM estudiantes WHERE id = ?");
$stmt->bind_param('i', $edit_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    die("No se encontró el estudiante.");
}
$stmt->bind_result($nombre, $apellido, $matricula, $carrera);
$stmt->fetch();
$stmt->close();

// Procesar formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $matricula = trim($_POST['matricula'] ?? '');
    $carrera = trim($_POST['carrera'] ?? '');

    // Validaciones
    if ($nombre === '') $errores[] = "El nombre es obligatorio.";
    elseif (strlen($nombre) > 50) $errores[] = "El nombre no puede tener más de 50 caracteres.";

    if ($apellido === '') $errores[] = "El apellido es obligatorio.";
    elseif (strlen($apellido) > 50) $errores[] = "El apellido no puede tener más de 50 caracteres.";

    if ($matricula === '') $errores[] = "La matrícula es obligatoria.";
    elseif (strlen($matricula) > 5) $errores[] = "La matrícula no puede tener más de 5 caracteres.";
    elseif (!preg_match('/^[A-Za-z0-9\-]+$/', $matricula)) $errores[] = "La matrícula contiene caracteres inválidos.";

    if ($carrera === '') $errores[] = "La carrera es obligatoria.";
    elseif (strlen($carrera) > 50) $errores[] = "La carrera no puede tener más de 50 caracteres.";

    // Si todo OK, actualizar DB
    if (empty($errores)) {
        $stmt = $dbconnect->prepare("UPDATE estudiantes SET nombre=?, apellido=?, matricula=?, carrera=? WHERE id=?");
        $stmt->bind_param('ssssi', $nombre, $apellido, $matricula, $carrera, $edit_id);

        if ($stmt->execute()) {
            $exito = "Estudiante actualizado con éxito.";
        } else {
            if ($stmt->errno == 1062) $errores[] = "Ya existe esa matrícula en la base de datos.";
            else $errores[] = "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Estudiante</title>
<style>
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

    h2 { color: #007bff; margin-bottom: 20px; text-align: center; }

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
    <h2>✏️ Editar Estudiante</h2>

    <div class="nav">
        <a href="../index.php">🏠 Inicio</a>
        <a href="../Views/StudentsViews.php">📂 Ver / Gestionar</a>
        <a href="addStudent.php">➕ Agregar Estudiante</a>
    </div>

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

    <form method="post" action="">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES); ?>" required>

        <label>Apellido</label>
        <input type="text" name="apellido" value="<?php echo htmlspecialchars($apellido, ENT_QUOTES); ?>" required>

        <label>Matrícula</label>
        <input type="text" name="matricula" value="<?php echo htmlspecialchars($matricula, ENT_QUOTES); ?>" required>

        <label>Carrera</label>
        <input type="text" name="carrera" value="<?php echo htmlspecialchars($carrera, ENT_QUOTES); ?>" required>

        <input type="submit" value="Guardar Cambios" class="btn">
    </form>
</div>
</body>
</html>

<?php
// Conexión a la DB
include "../Models/db.php";

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../Controllers/login.php");
    exit();
}


// borrar estudiantes desde la vista
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $stmt = $dbconnect->prepare("DELETE FROM estudiantes WHERE ID = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header("Location: StudentsViews.php");
    exit;
}

$result = $dbconnect->query("SELECT id, nombre, apellido, matricula, carrera FROM estudiantes ORDER BY apellido ASC;");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudiantes</title>
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
            max-width: 1000px;
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

        /* ===== BOTONES ===== */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            color: #fff;
            background: #007bff;
            transition: 0.3s;
            margin-bottom: 20px;
        }
        .btn:hover { background: #0056b3; }
        .btn.danger { background: #dc3545; }
        .btn.danger:hover { background: #a71d2a; }
        .btn.secondary { background: #6c757d; }
        .btn.secondary:hover { background: #545b62; }

        /* ===== TABLA ESTILIZADA ===== */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 10px;
            text-align: left;
        }

        thead {
            background: #007bff;
            color: #fff;
        }

        tbody tr:nth-child(even) { background: #f5f5f5; }
        tbody tr:hover { background: #e0f0ff; transform: scale(1.01); transition: 0.3s; }

        /* ===== NAVEGACIÓN SECCIONES ===== */
        .nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 25px;
        }

        .nav a {
            padding: 10px 18px;
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
        <h2>📋 Lista de Estudiantes</h2>

        <!-- Navegación rápida -->
        <div class="nav">
            <a href="../index.php">🏠 Inicio</a>
            <a href="../Controllers/addStudent.php">➕ Agregar Estudiante</a>
            <a href="StudentsViews.php">📂 Ver / Gestionar</a>
            <a href="#info">ℹ️ Acerca del Proyecto</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Nombre</th><th>Apellido</th><th>Matrícula</th><th>Carrera</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo (int)$row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($row['apellido'], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($row['matricula'], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($row['carrera'], ENT_QUOTES); ?></td>
                        <td>
                            <a class="btn" href="../Controllers/editStudent.php?edit_id=<?php echo (int)$row['id']; ?>">Editar</a>
                            <a class="btn danger" href="StudentsViews.php?delete_id=<?php echo (int)$row['id']; ?>" onclick="return confirm('¿Seguro que quieres borrar este estudiante?');">Borrar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <footer style="text-align:center; color:#666; font-size:0.9em;">
            © <?php echo date("Y"); ?> RA2.1 CE2.1.3  - Desarrollado por <strong>Cristopher Duran</strong>
        </footer>
    </div>
</body>
</html>
