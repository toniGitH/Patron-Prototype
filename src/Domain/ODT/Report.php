<?php

namespace App\Domain\ODT;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Informe (Report).
 */
class Report extends TextDocument
{
    private string $reportId;

    /**
     * @param string $title Título del informe.
     * @param string $content Contenido.
     * @param Author $author Autor.
     * @param string $reportId Identificador único del informe.
     */
    public function __construct(string $title, string $content, Author $author, string $reportId)
    {
        parent::__construct($title, $content, $author);
        $this->reportId = $reportId;
    }

    /**
     * @param string $id Nuevo ID de informe.
     */
    public function setReportId(string $id): void
    {
        $this->reportId = $id;
    }

    /**
     * @return string Información del informe incluyendo su ID.
     */
    public function getInfo(): string
    {
        return parent::getInfo() . " | ID: {$this->reportId}";
    }
}
