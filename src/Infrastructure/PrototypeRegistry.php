<?php

namespace App\Infrastructure;

use App\Domain\Contracts\PrototypeInterface;

/**
 * Esta clase es lo que, oficialmente, en el patrón, se conoce como Prototype Manager.
 * Clase base para el registro o gestor de prototipos (un prototipo es un objeto instanciado de una clase base, que se
 * utiliza como plantilla para crear nuevos objetos).
 * Contiene la lógica genérica de almacenamiento y clonación.
 * Es abstracta porque en este ejemplo hemos decidido tener dos gestores específicos: ODTManager y ODSManager.
 * Que sea abstracta nos permite:
 * - definir la lógica de los gestores una sola vez
 * - crear nuevos gestores en el futuro sin repetir código, simplemente extendiendo esta clase abstracta
 */
abstract class PrototypeRegistry
{
    /**
     * @var PrototypeInterface[]
     */
    protected array $templates = [];

    /**
     * Registra una plantilla en el catálogo.
     */
    public function registerTemplate(string $name, PrototypeInterface $prototype): void
    {
        $this->templates[$name] = $prototype;
    }

    /**
     * Crea un clon a partir de una plantilla registrada.
     */
    public function createFromTemplate(string $name): ?PrototypeInterface
    {
        if (!isset($this->templates[$name])) {
            return null;
        }

        return clone $this->templates[$name];
    }

    /**
     * Devuelve los nombres de todas las plantillas registradas.
     */
    public function listTemplates(): array
    {
        return array_keys($this->templates);
    }
}
