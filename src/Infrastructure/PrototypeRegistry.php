<?php

namespace App\Infrastructure;

use App\Domain\Contracts\PrototypeInterface;

/**
 * Esta clase es lo que, oficialmente, en el patrón, se conoce como Prototype Manager.
 * Clase base para el registro o gestor de prototipos (un prototipo es un objeto instanciado de una clase base, que se
 * utiliza como prototipo o modelo para crear nuevos objetos).
 * Contiene la lógica genérica de almacenamiento y clonación.
 * Es abstracta porque en este ejemplo hemos decidido tener dos gestores específicos: ODTManager y ODSManager.
 * Que sea abstracta nos permite:
 * - definir la lógica de los gestores una sola vez
 * - crear nuevos gestores en el futuro sin repetir código, simplemente extendiendo esta clase abstracta
 */
abstract class PrototypeRegistry
{
    /**
     * Almacén de prototipos.
     * Es un array que contiene todos los prototipos registrados.
     * Cada prototipo es un objeto instanciado de una clase base, que se utiliza como prototipo o modelo para crear nuevos objetos.
     * 
     * @var PrototypeInterface[]
     */
    protected array $prototypes = [];

    /**
     * Registra un prototipo en el catálogo instanciándolo dinámicamente.
     * 
     * @param string $alias Nombre con el que se registrará en el catálogo.
     * @param string $type Nombre corto de la clase.
     * @param array $args Argumentos para el constructor del prototipo en particular.
     */
    public function registerPrototype(string $alias, string $type, array $args = []): void
    {
        $prototype = $this->createPrototype($type, $args);
        $this->prototypes[$alias] = $prototype;
    }

    /**
     * Método de "Fábrica": Debe ser implementado por los hijos
     * para saber en qué namespace buscar la clase concreta.
     */
    abstract protected function createPrototype(string $type, array $args): PrototypeInterface;

    /**
     * Crea un clon a partir de un prototipo registrado.
     * 
     * @param string $name Nombre del prototipo a clonar.
     * @return ?PrototypeInterface El nuevo objeto clonado o null si no existe.
     */
    public function createFromPrototype(string $name): ?PrototypeInterface
    {
        if (!isset($this->prototypes[$name])) {
            return null;
        }

        return clone $this->prototypes[$name];
    }

    /**
     * Devuelve el objeto prototipo original (el maestro) para inspección.
     * No es necesario usarlo en la práctica, pero es útil con fines didácticos para la verificación de independencia.
     * 
     * @param string $name Nombre con el que se registrará en el catálogo.
     * @return ?PrototypeInterface
     */
    public function getPrototype(string $name): ?PrototypeInterface
    {
        return $this->prototypes[$name] ?? null;
    }

    /**
     * Devuelve los nombres de todos los prototipos registrados.
     * 
     * @return array Lista de alias registrados.
     */
    public function listPrototypes(): array
    {
        return array_keys($this->prototypes);
    }
}
