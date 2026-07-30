<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de usuario</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="contenedor">
  <h1>Registro de usuario</h1>

  <form method="POST" action="bienvenido.php">
    <label>Cédula:</label>
    <input type="text" name="cedula" maxlength="10" required>

    <label>Nombre:</label>
    <input type="text" name="nombre" maxlength="30" required>

    <label>Estado Civil:</label>
    <select name="estado_civil" required>
      <option value="">-- Seleccione --</option>
      <option value="soltero">Soltero</option>
      <option value="casado">Casado</option>
      <option value="union_libre">Unión libre</option>
      <option value="viudo">Viudo</option>
    </select>

    <label>Correo:</label>
    <input type="email" name="correo" required>

    <label>Clave:</label>
    <input type="password" name="clave" minlength="6" required>

    <input type="submit" name="registrar" value="Registrar">
    <input type="reset" value="Resetear">
  </form>

  <p class="ayuda"><a href="index.php">Volver al menú</a></p>
</div>
</body>
</html>
