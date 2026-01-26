<?php

namespace App\Domain\Contracts;

/**
 * Role Interface (Contrato o Interfaz de rol o capacidad).
 * Garantiza que cualquier objeto que la implemente sea formalmente clonable 
 * y proporcione una forma estandarizada de presentarse (getInfo()).
 */
interface PrototypeInterface
{
    /**
     * El método mágico __clone es el corazón técnico del patrón Prototype en PHP.
     * Interviene en el proceso de clonación para asegurar que no se compartan referencias (Deep Copy).
     */
    public function __clone();
    
    /**
     * Método para obtener información básica del objeto (para demostración).
     */
    public function getInfo(): string;
}
