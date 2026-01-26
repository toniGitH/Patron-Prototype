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
     * 
     * @param string $type El tipo de prototipo a crear ("Budget", "StaffPlanning").
     * @param array $args Propiedades del prototipo de tipo DATOS (Spreadsheet.php).
     * @return \App\Domain\Contracts\PrototypeInterface El prototipo de hoja de cálculo.
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
