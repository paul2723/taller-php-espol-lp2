<?php
session_start();
require 'usuario.php';
require 'registros.php';

$error = '';

if (isset($_POST['ingresar'])) {
    $cedula = trim($_POST['cedula'] ?? '');
    $clave  = $_POST['clave'] ?? '';

    if (autenticar($cedula, $clave)) {
        $_SESSION['cedula'] = $cedula;
        $_SESSION['nombre'] = obtenerNombre($cedula);
        header('Location: tareas.php');
        exit;
    } else {
        registrarFallo($cedula);
        $error = 'Cédula o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="contenedor">
  <h1>Iniciar sesión</h1>

  <?php if ($error !== ''): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="POST">
    <label>Cédula:</label>
    <input type="text" name="cedula" maxlength="10" required>

    <label>Clave:</label>
    <input type="password" name="clave" required>

    <input type="submit" name="ingresar" value="Ingresar">
  </form>

  <p class="ayuda"><a href="index.php">Volver al menú</a></p>
</div>
</body>
</html>
