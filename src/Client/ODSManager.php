<?php

namespace App\Client;

use App\Infrastructure\PrototypeRegistry;

/**
 * Gestor especializado en hojas de cálculo.
 */
class ODSManager extends PrototypeRegistry
{
    /**
     * Registra un prototipo instanciándolo dinámicamente por su tipo.
     */
    public function registerFromType(string $alias, string $type, array $args): void
    {
        $className = "App\\Domain\\ODS\\" . ucfirst($type);
        
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("La clase $className no existe.");
        }

        $prototype = new $className(...$args);
        $this->registerTemplate($alias, $prototype);
    }
}
