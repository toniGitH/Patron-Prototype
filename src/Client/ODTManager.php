<?php

namespace App\Client;

use App\Infrastructure\PrototypeRegistry;

/**
 * Gestor especializado en documentos de texto.
 */
class ODTManager extends PrototypeRegistry
{
    /**
     * Registra un prototipo instanciándolo dinámicamente por su tipo.
     * 
     * @param string $alias Nombre con el que se registrará en el catálogo.
     * @param string $type Nombre de la clase (ej: "Letter").
     * @param array $args Argumentos para el constructor.
     */
    public function registerFromType(string $alias, string $type, array $args): void
    {
        $className = "App\\Domain\\ODT\\" . ucfirst($type);
        
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("La clase $className no existe.");
        }

        $prototype = new $className(...$args);
        $this->registerTemplate($alias, $prototype);
    }
}
