<?php
/**
 * Registro de intentos de ingreso fallidos en logs.txt
 */

define('ARCHIVO_LOGS', __DIR__ . '/logs.txt');

// Guarda en logs.txt la IP y la fecha/hora de un intento de ingreso fallido
function registrarFallo($usuario) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
    $fecha = date('d/m/Y H:i:s');
    $linea = "Usuario: {$usuario} | IP: {$ip} | Fecha: {$fecha}" . PHP_EOL;

    $fp = fopen(ARCHIVO_LOGS, 'a');
    fwrite($fp, $linea);
    fclose($fp);
}
