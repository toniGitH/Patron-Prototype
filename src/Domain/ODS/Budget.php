<?php

namespace App\Domain\ODS;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Presupuesto (Budget).
 */
class Budget extends Spreadsheet
{
    private float $totalAmount;

    public function __construct(string $sheetName, Author $author, float $totalAmount = 0.0)
    {
        parent::__construct($sheetName, $author);
        $this->totalAmount = $totalAmount;
    }

    public function setTotalAmount(float $amount): void
    {
        $this->totalAmount = $amount;
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " | Total: {$this->totalAmount}€";
    }
}
