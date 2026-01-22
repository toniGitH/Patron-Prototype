<?php

require_once 'src/Domain/Author.php';
require_once 'src/Domain/Document.php';
require_once 'src/Client/DocumentManager.php';

use App\Domain\Author;
use App\Domain\Document;
use App\Client\DocumentManager;

echo "=== PATRÓN PROTOTYPE EN PHP ===\n\n";

$manager = new DocumentManager();

// Crear autor para la plantilla
$defaultAuthor = new Author("Sistema", "sistema@email.com");

// Crear plantilla de artículo técnico
$articleTemplate = new Document(
    "Artículo Técnico",
    "Contenido del artículo...",
    $defaultAuthor,
    ["técnico", "documentación"]
);

// Mostrar plantilla original antes de ser clonada y utilizada
echo "--- Plantilla original (debe conservar autor original) ---\n";
echo $articleTemplate->getInfo() . "\n\n";

$manager->registerTemplate("tech_article", $articleTemplate);

// Clonar y personalizar artículo sobre PHP
echo "--- Creando artículo sobre PHP ---\n";
$phpArticle = $manager->createFromTemplate("tech_article");
$phpArticle->setTitle("Patrones de Diseño en PHP");
$phpArticle->setContent("Los patrones de diseño son soluciones...");
$phpArticle->addTag("PHP");
$phpArticle->addTag("patrones");

// Modificar el autor del clon (gracias a __clone, es independiente)
$phpArticle->getAuthor()->setName("Antonio González");
$phpArticle->getAuthor()->setEmail("antonio@email.com");

echo $phpArticle->getInfo() . "\n\n";

// Clonar y personalizar artículo sobre Laravel
echo "--- Creando artículo sobre Laravel ---\n";
$laravelArticle = $manager->createFromTemplate("tech_article");
$laravelArticle->setTitle("Eloquent ORM en Laravel");
$laravelArticle->setContent("Eloquent es el ORM de Laravel...");
$laravelArticle->addTag("Laravel");
$laravelArticle->addTag("ORM");

$laravelArticle->getAuthor()->setName("Carlos Ruiz");
$laravelArticle->getAuthor()->setEmail("carlos@email.com");

echo $laravelArticle->getInfo() . "\n\n";

// Verificar que la plantilla original NO se modificó
echo "--- Plantilla original (debe conservar autor original) ---\n";
echo $articleTemplate->getInfo() . "\n\n";

