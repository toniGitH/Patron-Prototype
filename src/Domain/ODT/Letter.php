<?php

namespace App\Domain\ODT;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Carta (Letter).
 */
class Letter extends TextDocument
{
    private string $recipient;

    public function __construct(string $title, Author $author, string $recipient)
    {
        parent::__construct($title, "Cuerpo de la carta...", $author);
        $this->recipient = $recipient;
    }

    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " | To: {$this->recipient}";
    }
}
