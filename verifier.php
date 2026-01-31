<?php

/**
 * Almacén global para capturar resultados de verificación y mostrarlos en la web.
 */
$verificationResults = [];

/**
 * Función de utilidad para comparar objetos y demostrar independencia técnica.
 * 
 * @param mixed $obj1 Primer objeto a comparar.
 * @param mixed $obj2 Segundo objeto a comparar.
 * @param string $label Etiqueta descriptiva para la salida.
 */
function verifyIndependence($obj1, $obj2, string $label): void {
    global $verificationResults;
    
    $id1 = spl_object_id($obj1);
    $id2 = spl_object_id($obj2);
    $diffInstance = ($obj1 !== $obj2);
    $diffAuthor = ($obj1->getAuthor() !== $obj2->getAuthor());

    $verificationResults[] = [
        'label' => $label,
        'id1' => $id1,
        'id2' => $id2,
        'diffInstance' => $diffInstance,
        'diffAuthor' => $diffAuthor
    ];

    if (php_sapi_name() === 'cli') {
        echo "--- Verificando independencia: $label ---\n";
        echo "ID Objeto 1: $id1\n";
        echo "ID Objeto 2: $id2\n";
        echo "RESULTADO: " . ($diffInstance ? "Los objetos son INSTANCIAS DIFERENTES en memoria (OK)." : "ALERTA: Los objetos comparten la misma instancia (ERROR).") . "\n";
        echo "RESULTADO: " . ($diffAuthor ? "Los Autores son INSTANCIAS DIFERENTES (Clonación Profunda OK)." : "ALERTA: Los objetos comparten el mismo Autor (Clonación Superficial).") . "\n\n";
    }
}