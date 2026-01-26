<?php

namespace App\Domain\ODT;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Carta (Letter).
 */
class Letter extends TextDocument
{
    private string $recipient;

    /**
     * @param string $title Título de la carta.
     * @param Author $author Autor.
     * @param string $recipient Destinatario de la carta.
     */
    public function __construct(string $title, Author $author, string $recipient)
    {
        parent::__construct($title, "Cuerpo de la carta...", $author);
        $this->recipient = $recipient;
    }

    /**
     * @param string $recipient Nuevo destinatario.
     */
    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string Información de la carta incluyendo el destinatario.
     */
    public function getInfo(): string
    {
        return parent::getInfo() . " | To: {$this->recipient}";
    }
}
