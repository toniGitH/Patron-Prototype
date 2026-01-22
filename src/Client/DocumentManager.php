<?php

namespace App\Client;

use App\Domain\Document;

class DocumentManager
{
    private array $templates = [];

    public function registerTemplate(string $name, Document $document): void
    {
        $this->templates[$name] = $document;
    }

    public function createFromTemplate(string $name): ?Document
    {
        if (!isset($this->templates[$name])) {
            return null;
        }

        // Al clonar, se ejecutará __clone() automáticamente
        // haciendo una copia profunda del objeto Author
        return clone $this->templates[$name];
    }

    public function listTemplates(): array
    {
        return array_keys($this->templates);
    }
}