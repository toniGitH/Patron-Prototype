<?php

namespace App\Domain\ODT;

use App\Domain\ValueObjects\Author;
use App\Domain\Contracts\PrototypeInterface;
use ReflectionClass;

/**
 * Clase base abstracta para documentos de texto (ODT).
 * Contiene todas las propiedades y métodos que deben tener los documentos de texto.
 */
abstract class TextDocument implements PrototypeInterface
{
    protected string $title;
    protected string $content;
    protected Author $author;
    protected string $type;

    /**
     * @param string $title Título del documento.
     * @param string $content Contenido de texto.
     * @param Author $author Objeto autor (se clonará profundamente).
     */
    public function __construct(string $title, string $content, Author $author)
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->type = (new ReflectionClass($this))->getShortName();
    }

    /**
     * Implementación de la clonación profunda.
     * Asegura que el objeto Author también sea clonado.
     */
    public function __clone()
    {
        // Clonación profunda del autor (objeto anidado)
        $this->author = clone $this->author;
    }

    /**
     * @param string $title Nuevo título.
     */
    public function setTitle(string $title): void { $this->title = $title; }

    /**
     * @param string $content Nuevo contenido.
     */
    public function setContent(string $content): void { $this->content = $content; }

    /**
     * @return Author El objeto autor.
     */
    public function getAuthor(): Author { return $this->author; }

    /**
     * @return string Información básica formateada.
     */
    public function getInfo(): string
    {
        return "[ODT: {$this->type}] Title: {$this->title} | Author: {$this->author->getInfo()}";
    }
}
