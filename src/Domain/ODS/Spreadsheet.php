<?php

namespace App\Domain\ODS;

use App\Domain\ValueObjects\Author;
use App\Domain\Contracts\PrototypeInterface;
use ReflectionClass;

/**
 * Clase base abstracta para hojas de cálculo (ODS).
 * Contiene todas las propiedades y métodos que deben tener las hojas de cálculo.
 */
abstract class Spreadsheet implements PrototypeInterface
{
    protected string $title;
    protected Author $author;
    protected string $type;

    /**
     * @param string $title Título de la hoja de cálculo.
     * @param Author $author Objeto autor (se clonará profundamente).
     */
    public function __construct(string $title, Author $author)
    {
        $this->title = $title;
        $this->author = $author;
        $this->type = (new ReflectionClass($this))->getShortName();
    }

    /**
     * Implementación de la clonación profunda.
     * Asegura que el autor sea un objeto independiente en el clon.
     */
    public function __clone()
    {
        $this->author = clone $this->author;
    }

    /**
     * @param string $title Nuevo título de la hoja.
     */
    public function setTitle(string $title): void { $this->title = $title; }

    /**
     * @return Author El objeto autor.
     */
    public function getAuthor(): Author { return $this->author; }

    /**
     * @return string Información básica formateada.
     */
    public function getInfo(): string
    {
        return "[ODS: {$this->type}] Sheet: {$this->title} | Author: {$this->author->getInfo()}";
    }
}
