<?php

// 1. CARGA AUTOMÁTICA DE COMPONENTES (PSR-4)
require_once 'vendor/autoload.php';

// 2. UTILIDADES EXTRA
require_once 'verifier.php';

use App\Domain\ValueObjects\Author;
use App\Domain\ODT\Letter;
use App\Domain\ODT\Report;
use App\Domain\ODS\Budget;
use App\Domain\ODS\StaffPlanning;
use App\Client\ODTManager;
use App\Client\ODSManager;

// --- 1. CABECERA CLI ---
if (php_sapi_name() === 'cli' && count(debug_backtrace()) === 0) {
    echo "============================================================\n";
    echo "       EJEMPLO DEL PATRÓN PROTOTYPE: GESTOR PRO              \n";
    echo "============================================================\n\n";
}

// --- 2. LÓGICA DE NEGOCIO Y CREACIÓN (CON ECHO EN CLI) ---

// Author
$systemAuthor = new Author("Admin Central", "admin@corp.com");
$odtManager = new ODTManager();
$odsManager = new ODSManager();

// ODT: Letter
$odtManager->registerPrototype("std_letter_prototype", "Letter", ["Standard Letter", $systemAuthor, "Guest"]);
/** @var Letter $myLetter */
$myLetter = $odtManager->createFromPrototype("std_letter_prototype");
$myLetter->setTitle("Congratulations Letter");
$myLetter->setRecipient("Antonio González");
$myLetter->getAuthor()->setName("HR Team");
$myLetter->getAuthor()->setEmail("hr@corp.com");
if (php_sapi_name() === 'cli') {
    echo "-> Creado PRIMER documento concreto (clon) de tipo Letter:\n";
    echo $myLetter->getInfo() . "\n\n";
}

// ODT: Report
$odtManager->registerPrototype("std_report_prototype", "Report", ["Standard Report", "...", $systemAuthor, "M-000"]);
/** @var Report $myReport */
$myReport = $odtManager->createFromPrototype("std_report_prototype");
$myReport->setTitle("Monthly Q1 Sales Report");
$myReport->setReportId("R-001");
$myReport->getAuthor()->setName("Sales Team");
$myReport->getAuthor()->setEmail("sales@corp.com");
if (php_sapi_name() === 'cli') {
    echo "-> Creado PRIMER documento concreto (clon) de tipo Report:\n";
    echo $myReport->getInfo() . "\n\n";
}

// ODS: Budget
$odsManager->registerPrototype("std_budget_prototype", "Budget", ["Standard Budget", $systemAuthor, 0.0]);
/** @var Budget $marketingBudget */
$marketingBudget = $odsManager->createFromPrototype("std_budget_prototype");
$marketingBudget->setTitle("Marketing Dept Budget");
$marketingBudget->setTotalAmount(25000.50);
$marketingBudget->getAuthor()->setName("Marketing Office");
$marketingBudget->getAuthor()->setEmail("marketing@corp.com");
if (php_sapi_name() === 'cli') {
    echo "-> Creado PRIMER documento concreto (clon) de tipo Budget:\n";
    echo $marketingBudget->getInfo() . "\n\n";
}

// ODS: StaffPlanning
$odsManager->registerPrototype("std_staff_planning_prototype", "StaffPlanning", ["Standard Staff Planning", $systemAuthor, 0]);
/** @var StaffPlanning $staffPlanning */
$staffPlanning = $odsManager->createFromPrototype("std_staff_planning_prototype");
$staffPlanning->setTitle("Sales Staff Planning");
$staffPlanning->setStaffCode(3414);
$staffPlanning->getAuthor()->setName("Staff Office");
$staffPlanning->getAuthor()->setEmail("staff@corp.com");
if (php_sapi_name() === 'cli') {
    echo "-> Creado PRIMER documento concreto (clon) de tipo StaffPlanning:\n";
    echo $staffPlanning->getInfo() . "\n\n";
}

// --- 3. VISUALIZACIÓN DEL ALMACÉN DE PROTOTIPOS (PROTOTYPE REGISTRY) ---
if (php_sapi_name() === 'cli') {
    echo "=== ESTADO ACTUAL DEL ALMACÉN DE PROTOTIPOS (REGISTRY) ===\n";
    echo "Estos son los objetos MAESTROS que residen en memoria y sirven de base para clonar:\n\n";
    
    $registries = ['ODT' => $odtManager, 'ODS' => $odsManager];
    foreach ($registries as $name => $manager) {
        echo "[$name Registry]:\n";
        foreach ($manager->listPrototypes() as $alias) {
            $p = $manager->getPrototype($alias);
            echo "  • Alias: $alias | Clase: " . (new ReflectionClass($p))->getShortName() . " | ID: " . spl_object_id($p) . "\n";
        }
        echo "\n";
    }
}

// --- 4. VERIFICACIONES (CON ECHO EN CLI) ---
if (php_sapi_name() === 'cli') {
    echo "=== VERIFICACIONES DE INDEPENDENCIA TOTAL ===\n\n";
}

// Letter
/** @var Letter $anotherLetter */
$anotherLetter = $odtManager->createFromPrototype("std_letter_prototype");
$anotherLetter->setTitle("Promotion Letter");
$anotherLetter->getAuthor()->setName("Promotion Team");
$anotherLetter->getAuthor()->setEmail("promotion@corp.com");
$anotherLetter->setRecipient("Antonio González");
$letterPrototype = $odtManager->getPrototype("std_letter_prototype");

verifyIndependence($letterPrototype, $myLetter, "Letter: Prototype vs Clon 1");
verifyIndependence($letterPrototype, $anotherLetter, "Letter: Prototype vs Clon 2");
verifyIndependence($myLetter, $anotherLetter, "Letter: Clon 1 vs Clon 2");

// Budget
/** @var Budget $anotherBudget */
$anotherBudget = $odsManager->createFromPrototype("std_budget_prototype");
$anotherBudget->setTitle("IT Dept Budget");
$anotherBudget->setTotalAmount(50000.00);
$anotherBudget->getAuthor()->setName("IT Office");
$anotherBudget->getAuthor()->setEmail("it@corp.com");
$budgetPrototype = $odsManager->getPrototype("std_budget_prototype");

verifyIndependence($budgetPrototype, $marketingBudget, "Budget: Prototype vs Clon 1");
verifyIndependence($budgetPrototype, $anotherBudget, "Budget: Prototype vs Clon 2");
verifyIndependence($marketingBudget, $anotherBudget, "Budget: Clon 1 vs Clon 2");

// --- 4. RECOPILACIÓN PARA WEB ---
$renderData = [
    'documents' => [
        'ODT' => ['Letter' => $myLetter, 'Report' => $myReport],
        'ODS' => ['Budget' => $marketingBudget, 'StaffPlanning' => $staffPlanning]
    ],
    'registry' => [
        'ODT' => array_map(fn($alias) => $odtManager->getPrototype($alias), array_combine($odtManager->listPrototypes(), $odtManager->listPrototypes())),
        'ODS' => array_map(fn($alias) => $odsManager->getPrototype($alias), array_combine($odsManager->listPrototypes(), $odsManager->listPrototypes())),
    ],
    'verifications' => $verificationResults
];

// --- 5. CONCLUSIÓN Y VENTAJAS (SOLO CLI) ---
if (php_sapi_name() === 'cli' && count(debug_backtrace()) === 0) {
    echo "=== CONCLUSIÓN FINAL ===\n";
    echo "Queda demostrado que el Prototipo (molde maestro) reside en el Registry \n";
    echo "totalmente protegido y ajeno a las modificaciones que sufran los objetos \n";
    echo "que la aplicación crea (clona) a partir de él.\n\n";

    echo "============================================================\n";
    echo "VENTAJAS DEL PATRÓN PROTOTYPE:\n";
    echo "============================================================\n";
    $ventajas = [
        "Ahorro de recursos al evitar constructores costosos.",
        "Mismo proceso de clonación para diferentes representaciones.",
        "Desacoplamiento: el cliente no conoce las clases concretas.",
        "Permite añadir o eliminar productos en tiempo de ejecución."
    ];
    foreach ($ventajas as $ventaja) {
        echo " ✓ " . $ventaja . "\n";
    }
    echo "\n";
}
