<?php

namespace App\Client;

use App\Infrastructure\PrototypeRegistry;

/**
 * Gestor especializado en documentos de texto.
 */
class ODTManager extends PrototypeRegistry
{
    /**
     * Implementación específica para el dominio ODT.
     * Este método no lo heredamos implementado en la clase padre.
     * Viene declarado como abstracto en la clase padre, por lo que estamos obligados a implementarlo aquí.
     * 
     * @param string $type El tipo de prototipo a crear.
     * @param array $args Son las propiedades de cualquier prototipo de tipo TEXTO (TextDocument.php).
     * @return \App\Domain\Contracts\PrototypeInterface El prototipo creado.
     */
    protected function createPrototype(string $type, array $args): \App\Domain\Contracts\PrototypeInterface
    {
        $className = "App\\Domain\\ODT\\" . ucfirst($type);
        
        if (!class_exists($className)) {
            throw new \InvalidArgumentException("La clase $className no existe en el dominio ODT.");
        }

        return new $className(...$args);
    }
}
