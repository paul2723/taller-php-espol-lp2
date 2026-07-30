<?php

// Nombre de archivo seguro por usuario (evita traversal / caracteres raros)
function archivoTareas($usuario) {
    $usuario_seguro = preg_replace('/[^a-zA-Z0-9_]/', '', $usuario);
    return __DIR__ . "/tareas_{$usuario_seguro}.csv";
}

// Agrega una línea con id, texto y estado al archivo tareas_$usuario.csv
function guardarTarea($usuario, $texto) {
    $archivo = archivoTareas($usuario);

    // Calcular el siguiente id disponible
    $siguiente_id = 1;
    if (file_exists($archivo)) {
        $fp = fopen($archivo, 'r');
        while (($campos = fgetcsv($fp)) !== false) {
            if (isset($campos[0]) && (int)$campos[0] >= $siguiente_id) {
                $siguiente_id = (int)$campos[0] + 1;
            }
        }
        fclose($fp);
    }

    $fp = fopen($archivo, 'a');
    fputcsv($fp, [$siguiente_id, $texto, 'pendiente']);
    fclose($fp);
}

// Retorna las tareas de ese usuario separadas en pendientes y completadas
function listarTareas($usuario) {
    $archivo = archivoTareas($usuario);
    $pendientes = [];
    $completadas = [];

    if (file_exists($archivo)) {
        $fp = fopen($archivo, 'r');
        while (($campos = fgetcsv($fp)) !== false) {
            if (!isset($campos[0])) {
                continue;
            }
            $tarea = [
                'id'     => $campos[0],
                'texto'  => $campos[1] ?? '',
                'estado' => $campos[2] ?? 'pendiente',
            ];
            if ($tarea['estado'] === 'completada') {
                $completadas[] = $tarea;
            } else {
                $pendientes[] = $tarea;
            }
        }
        fclose($fp);
    }

    return ['pendientes' => $pendientes, 'completadas' => $completadas];
}

// Cambia el estado de la tarea indicada a "completada"
function completarTarea($usuario, $id) {
    $archivo = archivoTareas($usuario);
    if (!file_exists($archivo)) {
        return;
    }

    $lectura = fopen($archivo, 'r');
    $filas = [];
    while (($campos = fgetcsv($lectura)) !== false) {
        if (isset($campos[0]) && (string)$campos[0] === (string)$id) {
            $campos[2] = 'completada';
        }
        $filas[] = $campos;
    }
    fclose($lectura);

    $escritura = fopen($archivo, 'w');
    foreach ($filas as $fila) {
        fputcsv($escritura, $fila);
    }
    fclose($escritura);
}

// Elimina la línea correspondiente del archivo
function eliminarTarea($usuario, $id) {
    $archivo = archivoTareas($usuario);
    if (!file_exists($archivo)) {
        return;
    }

    $lectura = fopen($archivo, 'r');
    $filas = [];
    while (($campos = fgetcsv($lectura)) !== false) {
        if (isset($campos[0]) && (string)$campos[0] === (string)$id) {
            continue; // se omite -> queda eliminada
        }
        $filas[] = $campos;
    }
    fclose($lectura);

    $escritura = fopen($archivo, 'w');
    foreach ($filas as $fila) {
        fputcsv($escritura, $fila);
    }
    fclose($escritura);
}
