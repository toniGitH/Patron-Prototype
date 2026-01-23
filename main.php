<?php

// CARGA DE COMPONENTES
require_once 'src/Domain/ValueObjects/Author.php';
require_once 'src/Domain/Contracts/PrototypeInterface.php';
require_once 'src/Infrastructure/PrototypeRegistry.php';

// Familia ODT (Texto)
require_once 'src/Domain/ODT/TextDocument.php';
require_once 'src/Domain/ODT/Letter.php';
require_once 'src/Domain/ODT/Report.php';
require_once 'src/Client/ODTManager.php';

// Familia ODS (Hojas de cálculo)
require_once 'src/Domain/ODS/Spreadsheet.php';
require_once 'src/Domain/ODS/Budget.php';
require_once 'src/Domain/ODS/StaffPlanning.php';
require_once 'src/Client/ODSManager.php';

require_once 'verifier.php';

use App\Domain\ValueObjects\Author;
use App\Domain\ODT\Letter;
use App\Domain\ODT\Report;
use App\Domain\ODS\Budget;
use App\Domain\ODS\StaffPlanning;
use App\Client\ODTManager;
use App\Client\ODSManager;

echo "=== DEMOSTRACIÓN AVANZADA: PROTOTYPE MULTIDOMINIO (ODT & ODS) ===\n\n";

$systemAuthor = new Author("Admin Central", "admin@corp.com");

// ---------------------------------------------------------
// 1. GESTIÓN DE DOCUMENTOS DE TEXTO (ODT)
// ---------------------------------------------------------
echo "[+] Inicializando ODTManager...\n";
$odtManager = new ODTManager();
$odtManager->registerFromType("std_letter", "Letter", ["Standard Letter", $systemAuthor, "Guest"]);
$odtManager->registerFromType("monthly_report", "Report", ["Monthly Sales", "...", $systemAuthor, "M-000"]);

/** @var Letter $myLetter */
$myLetter = $odtManager->createFromTemplate("std_letter");
$myLetter->setRecipient("Antonio González");
$myLetter->getAuthor()->setName("HR Team");

echo $myLetter->getInfo() . "\n\n";

/** @var Report $myReport */
$myReport = $odtManager->createFromTemplate("monthly_report");
$myReport->setReportId("R-001");
$myReport->getAuthor()->setName("HR Team");

echo $myReport->getInfo() . "\n\n";

// ---------------------------------------------------------
// 2. GESTIÓN DE HOJAS DE CÁLCULO (ODS)
// ---------------------------------------------------------
echo "[+] Inicializando ODSManager...\n";
$odsManager = new ODSManager();
$odsManager->registerFromType("annual_budget", "Budget", ["Annual Budget 2026", $systemAuthor, 0.0]);
$odsManager->registerFromType("q1_planning", "StaffPlanning", ["Q1 Workforce", $systemAuthor, 0]);

/** @var Budget $marketingBudget */
$marketingBudget = $odsManager->createFromTemplate("annual_budget");
$marketingBudget->setSheetName("Marketing Dept Budget");
$marketingBudget->setTotalAmount(25000.50);
$marketingBudget->getAuthor()->setName("CMO Office");

echo $marketingBudget->getInfo() . "\n\n";

// ---------------------------------------------------------
// 3. VERIFICACIÓN DE INDEPENDENCIA (TRANSVERSAL)
// ---------------------------------------------------------
echo "=== VERIFICACIONES DE INDEPENDENCIA ===\n";

/** @var Budget $anotherBudget */
$anotherBudget = $odsManager->createFromTemplate("annual_budget");
$anotherBudget->setSheetName("IT Dept Budget");
$anotherBudget->setTotalAmount(50000.00);

verifyIndependence($marketingBudget, $anotherBudget, "Marketing Budget vs IT Budget");

/** @var Letter $anotherLetter */
$anotherLetter = $odtManager->createFromTemplate("std_letter");
verifyIndependence($myLetter, $anotherLetter, "Letter 1 vs Letter 2");

echo "=== CONCLUSIÓN ===\n";
echo "Hemos usado una misma base (PrototypeRegistry) para gestionar dos dominios \n";
echo "totalmente distintos (Texto y Datos), demostrando la potencia de la abstracción.\n";
