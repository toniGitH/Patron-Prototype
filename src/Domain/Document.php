<?php

namespace App\Domain;

class Document
{
    private string $title;
    private string $content;
    private Author $author; // Objeto anidado
    private array $tags;

    public function __construct(string $title, string $content, Author $author, array $tags = [])
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->tags = $tags;
    }

    /**
     * Método mágico para controlar la clonación
     * Se ejecuta automáticamente cuando usas clone
     */
    public function __clone()
    {
        // Clonar el objeto Author para que sea independiente
        $this->author = clone $this->author;
        
        // Los arrays se copian automáticamente (son tipos valor en PHP)
        // pero si tuvieran objetos dentro, también habría que clonarlos
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function addTag(string $tag): void
    {
        $this->tags[] = $tag;
    }

    public function getInfo(): string
    {
        $tagsList = implode(", ", $this->tags);
        return "Documento: {$this->title}\n" .
               "Contenido: {$this->content}\n" .
               "Autor: {$this->author->getInfo()}\n" .
               "Tags: [{$tagsList}]";
    }
}