<?php

namespace App\Domain\ValueObjects;

/**
 * Clase Autor (apoyo). Representa al creador de los documentos.
 */
class Author
{
    private string $name;
    private string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getInfo(): string
    {
        return "{$this->name} ({$this->email})";
    }
}