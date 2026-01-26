<?php

/**
 * Función de utilidad para comparar objetos y demostrar independencia técnica.
 * 
 * @param mixed $obj1 Primer objeto a comparar.
 * @param mixed $obj2 Segundo objeto a comparar.
 * @param string $label Etiqueta descriptiva para la salida por consola.
 */
function verifyIndependence($obj1, $obj2, string $label): void {
    echo "--- Verificando independencia: $label ---\n";
    echo "ID Objeto 1: " . spl_object_id($obj1) . "\n";
    echo "ID Objeto 2: " . spl_object_id($obj2) . "\n";
    
    if ($obj1 !== $obj2) {
        echo "RESULTADO: Los objetos son INSTANCIAS DIFERENTES en memoria (OK).\n";
    } else {
        echo "ALERTA: Los objetos comparten la misma instancia (ERROR).\n";
    }

    // Verificar independencia del objeto anidado Author
    if ($obj1->getAuthor() !== $obj2->getAuthor()) {
        echo "RESULTADO: Los Autores son INSTANCIAS DIFERENTES (Clonación Profunda OK).\n";
    } else {
        echo "ALERTA: Los objetos comparten el mismo Autor (Clonación Superficial).\n";
    }
    echo "\n";
}