<?php

namespace App\Domain\Contracts;

/**
 * Role Interface (Contrato o Interfaz de rol o capacidad).
 * Garantiza que cualquier objeto que la implemente sea formalmente clonable 
 * y proporcione una forma estandarizada de presentarse (getInfo()).
 */
interface PrototypeInterface
{
    public function __clone();
    
    /**
     * Método para obtener información básica del objeto (para demostración).
     */
    public function getInfo(): string;
}
