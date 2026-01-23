<?php

namespace App\Domain\ODT;

use App\Domain\ValueObjects\Author;
use App\Domain\Contracts\PrototypeInterface;
use ReflectionClass;

/**
 * Clase base abstracta para documentos de texto (ODT).
 */
abstract class TextDocument implements PrototypeInterface
{
    protected string $title;
    protected string $content;
    protected Author $author;
    protected string $type;

    public function __construct(string $title, string $content, Author $author)
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->type = (new ReflectionClass($this))->getShortName();
    }

    public function __clone()
    {
        // Clonación profunda del autor (objeto anidado)
        $this->author = clone $this->author;
    }

    public function setTitle(string $title): void { $this->title = $title; }
    public function setContent(string $content): void { $this->content = $content; }
    public function getAuthor(): Author { return $this->author; }

    public function getInfo(): string
    {
        return "[ODT: {$this->type}] Title: {$this->title} | Author: {$this->author->getInfo()}";
    }
}
