<?php

namespace App\Domain\ValueObjects;

/**
 * Clase Autor (apoyo). Representa al creador de los documentos.
 */
class Author
{
    private string $name;
    private string $email;

    /**
     * @param string $name Nombre del autor.
     * @param string $email Correo electrónico del autor.
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @param string $name Nuevo nombre.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $email Nuevo email.
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string Información básica.
     */
    public function getInfo(): string
    {
        return "{$this->name} ({$this->email})";
    }
}