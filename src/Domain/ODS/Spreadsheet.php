<?php

namespace App\Domain\ODS;

use App\Domain\ValueObjects\Author;
use App\Domain\Contracts\PrototypeInterface;
use ReflectionClass;

/**
 * Clase base abstracta para hojas de cálculo (ODS).
 */
abstract class Spreadsheet implements PrototypeInterface
{
    protected string $sheetName;
    protected Author $author;
    protected string $type;

    public function __construct(string $sheetName, Author $author)
    {
        $this->sheetName = $sheetName;
        $this->author = $author;
        $this->type = (new ReflectionClass($this))->getShortName();
    }

    public function __clone()
    {
        $this->author = clone $this->author;
    }

    public function setSheetName(string $name): void { $this->sheetName = $name; }
    public function getAuthor(): Author { return $this->author; }

    public function getInfo(): string
    {
        return "[ODS: {$this->type}] Sheet: {$this->sheetName} | Author: {$this->author->getInfo()}";
    }
}
