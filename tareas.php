<?php
session_start();
require 'tarea.php';

// Proteger la página: sin sesión activa, no hay acceso
if (!isset($_SESSION['cedula'])) {
    header('Location: ingreso.php');
    exit;
}

$usuario = $_SESSION['cedula'];

// Agregar tarea
if (isset($_POST['agregar'])) {
    $texto = trim($_POST['texto'] ?? '');
    if ($texto !== '') {
        guardarTarea($usuario, $texto);
    }
    header('Location: tareas.php');
    exit;
}

// Completar tarea
if (isset($_GET['completar'])) {
    completarTarea($usuario, $_GET['completar']);
    header('Location: tareas.php');
    exit;
}

// Eliminar tarea
if (isset($_GET['eliminar'])) {
    eliminarTarea($usuario, $_GET['eliminar']);
    header('Location: tareas.php');
    exit;
}

$tareas = listarTareas($usuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Tareas</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="contenedor">
  <h1>Mis Tareas</h1>
  <p>
    Sesión: <strong><?php echo htmlspecialchars($_SESSION['nombre'] ?? $usuario); ?></strong>
    — <a href="logout.php">Cerrar sesión</a>
  </p>

  <form method="POST">
    <label>Nueva tarea:</label>
    <input type="text" name="texto" required>
    <input type="submit" name="agregar" value="Agregar">
  </form>

  <h2>Pendientes</h2>
  <?php if (empty($tareas['pendientes'])): ?>
    <p class="ayuda">No tienes tareas pendientes.</p>
  <?php else: ?>
  <table>
    <tr><th>Tarea</th><th>Acciones</th></tr>
    <?php foreach ($tareas['pendientes'] as $t): ?>
    <tr>
      <td><?php echo htmlspecialchars($t['texto']); ?></td>
      <td>
        <a href="tareas.php?completar=<?php echo urlencode($t['id']); ?>">Completar</a> |
        <a href="tareas.php?eliminar=<?php echo urlencode($t['id']); ?>">Eliminar</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php endif; ?>

  <h2>Completadas</h2>
  <?php if (empty($tareas['completadas'])): ?>
    <p class="ayuda">Aún no has completado tareas.</p>
  <?php else: ?>
  <table>
    <tr><th>Tarea</th><th>Acciones</th></tr>
    <?php foreach ($tareas['completadas'] as $t): ?>
    <tr>
      <td><?php echo htmlspecialchars($t['texto']); ?></td>
      <td><a href="tareas.php?eliminar=<?php echo urlencode($t['id']); ?>">Eliminar</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php endif; ?>

</div>
</body>
</html>
