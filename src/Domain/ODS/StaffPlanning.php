<?php

namespace App\Domain\ODS;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Planificación de Personal (StaffPlanning).
 */
class StaffPlanning extends Spreadsheet
{
    private int $employeeCount;

    public function __construct(string $sheetName, Author $author, int $employeeCount = 0)
    {
        parent::__construct($sheetName, $author);
        $this->employeeCount = $employeeCount;
    }

    public function setEmployeeCount(int $count): void
    {
        $this->employeeCount = $count;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " | Employees: {$this->employeeCount}";
    }
}
