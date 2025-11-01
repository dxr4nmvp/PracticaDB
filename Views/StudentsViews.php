<?php
// Conexión a la DB
include "../Controllers/db.php";

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
