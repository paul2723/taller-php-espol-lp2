<?php

define('ARCHIVO_USUARIOS', __DIR__ . '/usuarios.csv');

// Guarda un usuario nuevo como línea en usuarios.csv
function guardar($datos) {
    $fp = fopen(ARCHIVO_USUARIOS, 'a');
    fputcsv($fp, [
        $datos['cedula'],
        $datos['nombre'],
        $datos['estado_civil'],
        $datos['correo'],
        $datos['clave'], // ya debe venir cifrada con password_hash()
    ]);
    fclose($fp);
}

// Retorna True si la cédula ya está registrada
function validar($cedula) {
    if (!file_exists(ARCHIVO_USUARIOS)) {
        return false;
    }
    $fp = fopen(ARCHIVO_USUARIOS, 'r');
    while (($campos = fgetcsv($fp)) !== false) {
        if (isset($campos[0]) && $campos[0] === $cedula) {
            fclose($fp);
            return true;
        }
    }
    fclose($fp);
    return false;
}

// Valida usuario y contraseña con password_verify()
function autenticar($cedula, $contrasena) {
    if (!file_exists(ARCHIVO_USUARIOS)) {
        return false;
    }
    $fp = fopen(ARCHIVO_USUARIOS, 'r');
    while (($campos = fgetcsv($fp)) !== false) {
        if (isset($campos[0]) && $campos[0] === $cedula) {
            fclose($fp);
            $hash = $campos[4] ?? '';
            return password_verify($contrasena, $hash);
        }
    }
    fclose($fp);
    return false;
}

// Ayuda extra: obtiene el nombre de un usuario a partir de su cédula
function obtenerNombre($cedula) {
    if (!file_exists(ARCHIVO_USUARIOS)) {
        return '';
    }
    $fp = fopen(ARCHIVO_USUARIOS, 'r');
    while (($campos = fgetcsv($fp)) !== false) {
        if (isset($campos[0]) && $campos[0] === $cedula) {
            fclose($fp);
            return $campos[1] ?? '';
        }
    }
    fclose($fp);
    return '';
}
