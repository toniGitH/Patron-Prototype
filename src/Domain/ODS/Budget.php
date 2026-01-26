<?php

namespace App\Domain\ODS;

use App\Domain\ValueObjects\Author;

/**
 * Prototipo concreto: Presupuesto (Budget).
 */
class Budget extends Spreadsheet
{
    private float $totalAmount;

    /**
     * @param string $title Título de la hoja.
     * @param Author $author Autor.
     * @param float $totalAmount Importe total del presupuesto.
     */
    public function __construct(string $title, Author $author, float $totalAmount = 0.0)
    {
        parent::__construct($title, $author);
        $this->totalAmount = $totalAmount;
    }

    /**
     * @param float $amount Nuevo importe total.
     */
    public function setTotalAmount(float $amount): void
    {
        $this->totalAmount = $amount;
    }

    /**
     * @return string Información del presupuesto incluyendo el importe.
     */
    public function getInfo(): string
    {
        return parent::getInfo() . " | Total: {$this->totalAmount}€";
    }
}
