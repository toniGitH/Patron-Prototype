<?php

namespace App\Domain\ODS;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Planificación de Personal (StaffPlanning).
 */
class StaffPlanning extends Spreadsheet
{
    private int $staffCode;

    /**
     * @param string $title Título de la hoja.
     * @param Author $author Autor.
     * @param int $staffCode Código o número identificativo del personal.
     */
    public function __construct(string $title, Author $author, int $staffCode = 0)
    {
        parent::__construct($title, $author);
        $this->staffCode = $staffCode;
    }

    /**
     * @param int $code Nuevo código de personal.
     */
    public function setStaffCode(int $code): void
    {
        $this->staffCode = $code;
    }

    /**
     * @return string Información de la planificación incluyendo el código.
     */
    public function getInfo(): string
    {
        return parent::getInfo() . " | Employees: {$this->staffCode}";
    }
}
