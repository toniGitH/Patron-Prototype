<?php

namespace App\Client;

use App\Infrastructure\PrototypeRegistry;

/**
 * Gestor especializado en hojas de cálculo.
 */
class ODSManager extends PrototypeRegistry
{
    /**
     * Implementación específica para el dominio ODS.
     */
    protected function createPrototype(string $type, array $args): \App\Domain\Contracts\PrototypeInterface
    {
        $className = "App\\Domain\\ODS\\" . ucfirst($type);
        
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("La clase $className no existe en el dominio ODS.");
        }

        return new $className(...$args);
    }
}
