<?php

namespace App\Domain\ODT;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Informe (Report).
 */
class Report extends TextDocument
{
    private string $reportId;

    public function __construct(string $title, string $content, Author $author, string $reportId)
    {
        parent::__construct($title, $content, $author);
        $this->reportId = $reportId;
    }

    public function setReportId(string $id): void
    {
        $this->reportId = $id;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " | ID: {$this->reportId}";
    }
}
