<?php
session_start();
require 'usuario.php';

$cedula       = trim($_POST['cedula'] ?? '');
$nombre       = trim($_POST['nombre'] ?? '');
$estado_civil = trim($_POST['estado_civil'] ?? '');
$correo       = trim($_POST['correo'] ?? '');
$clave        = $_POST['clave'] ?? '';

// Si la cédula ya existe, no registrar de nuevo: mandar a ingreso.php
if ($cedula === '' || validar($cedula)) {
    header('Location: ingreso.php');
    exit;
}

// Cifrar la contraseña antes de guardarla
$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT);

guardar([
    'cedula'       => $cedula,
    'nombre'       => $nombre,
    'estado_civil' => $estado_civil,
    'correo'       => $correo,
    'clave'        => $clave_cifrada,
]);

// Crear la sesión del usuario recién registrado
$_SESSION['cedula'] = $cedula;
$_SESSION['nombre'] = $nombre;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Usuario registrado</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="contenedor">
  <h1>USUARIO REGISTRADO</h1>
  <p class="exito">Bienvenido, <?php echo htmlspecialchars($nombre); ?>.</p>
  <p><a href="index.php">Volver al menú</a></p>
</div>
</body>
</html>
