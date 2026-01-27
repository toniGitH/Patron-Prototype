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

echo "=== DEMOSTRACIÓN DEL PATRÓN PROTOTYPE ===\n";
echo "=== GESTOR DE DOCUMENTOS DE TEXTO (ODT) Y HOJAS DE CÁLCULO (ODS) ===\n\n";

// FLUJO GENERAL DE GESTIÓN DE DOCUMENTOS
// Los pasos necesarios para gestionar un documento concreto son:
// 1. Crear los objetos externos necesarios (como Author) que serán inyectados en los prototipos y productos concretos
// 2. Inicializar el gestor
// 3. Registrar el prototipo
// 4. Clonar el prototipo
// 5. Modificar el prototipo
// 6. Usar el prototipo
// Estos pasos se repetirán para cada uno de los documentos concretos que se quieran gestionar.

// ---------------------------------------------------------------------
// CREACIÓN DE UNA CARTA (Letter) - GESTIÓN DE DOCUMENTOS DE TEXTO (ODT)
// ---------------------------------------------------------------------

// 1. Crear los objetos externos necesarios (Author)
$systemAuthor = new Author("Admin Central", "admin@corp.com");
// 2. Inicializar el gestor concreto que necesitamos para gestionar un documento de tipo Letter:
$odtManager = new ODTManager();
// 3. Registrar el prototipo "Letter" en el gestor (creamos un prototipo de tipo "Letter" y lo registramos en el gestor)
$odtManager->registerPrototype("std_letter_prototype", "Letter", ["Standard Letter", $systemAuthor, "Guest"]);
// 4. Clonar el prototipo "std_letter_prototype"
/** @var Letter $myLetter */
$myLetter = $odtManager->createFromPrototype("std_letter_prototype");
// 5. Modificar el prototipo clonado
$myLetter->setTitle("Cogratulations Letter");
$myLetter->setRecipient("Antonio González");
$myLetter->getAuthor()->setName("HR Team");
$myLetter->getAuthor()->setEmail("hr@corp.com");
// 6. Usar el prototipo
echo "-> Creado PRIMER documento concreto (clon) de tipo Letter:\n";
echo $myLetter->getInfo() . "\n\n";

// ----------------------------------------------------------------------
// CREACIÓN DE UN REPORTE (Report) - GESTIÓN DE DOCUMENTOS DE TEXTO (ODT)
// ----------------------------------------------------------------------
// 1. Crear los objetos externos necesarios (Author) - Este paso ya está realizado arriba 
// 2. Inicializar el gestor concreto que necesitamos para gestionar un documento de tipo Letter - Ya realizado arriba
// 3. Registrar el prototipo "Report" en el gestor (creamos un prototipo de tipo "Report" y lo registramos en el gestor)
$odtManager->registerPrototype("std_report_prototype", "Report", ["Standard Report", "...", $systemAuthor, "M-000"]);
// 4. Clonar el prototipo "std_report_prototype"
/** @var Report $myReport */
$myReport = $odtManager->createFromPrototype("std_report_prototype");
// 5. Modificar el prototipo clonado
$myReport->setTitle("Monthly Q1 Sales Report");
$myReport->setReportId("R-001");
$myReport->getAuthor()->setName("Sales Team");
$myReport->getAuthor()->setEmail("sales@corp.com");
// 6. Usar el prototipo
echo "-> Creado PRIMER documento concreto (clon) de tipo Report:\n";
echo $myReport->getInfo() . "\n\n";

// -----------------------------------------------------------------------
// CREACIÓN DE UN PRESUPUESTO (Budget) - GESTIÓN DE HOJAS DE CÁLCULO (ODS)
// -----------------------------------------------------------------------
// 1. Crear los objetos externos necesarios (Author) - Este paso ya está realizado arriba 
// 2. Inicializar el gestor concreto que necesitamos para gestionar un documento de tipo Budget:
$odsManager = new ODSManager();
// 3. Registrar el prototipo "Budget" en el gestor (creamos un prototipo de tipo "Budget" y lo registramos en el gestor)
$odsManager->registerPrototype("std_budget_prototype", "Budget", ["Standard Budget", $systemAuthor, 0.0]);
// 4. Clonar el prototipo "std_budget_prototype"
/** @var Budget $marketingBudget */
$marketingBudget = $odsManager->createFromPrototype("std_budget_prototype");
// 5. Modificar el prototipo clonado
$marketingBudget->setTitle("Marketing Dept Budget");
$marketingBudget->setTotalAmount(25000.50);
$marketingBudget->getAuthor()->setName("Marketing Office");
$marketingBudget->getAuthor()->setEmail("marketing@corp.com");
// 6. Usar el prototipo
echo "-> Creado PRIMER documento concreto (clon) de tipo Budget:\n";
echo $marketingBudget->getInfo() . "\n\n";


// ---------------------------------------------------------------------------
// CREACIÓN DE UN PLANNING (StaffPlanning) - GESTIÓN DE HOJAS DE CÁLCULO (ODS)
// ---------------------------------------------------------------------------
// 1. Crear los objetos externos necesarios (Author) - Este paso ya está realizado arriba 
// 2. Inicializar el gestor concreto que necesitamos para gestionar un documento de tipo StaffPlanning -  Ya realizado arriba
// 3. Registrar el prototipo "StaffPlanning" en el gestor (creamos un prototipo de tipo "StaffPlanning" y lo registramos en el gestor)
$odsManager->registerPrototype("std_staff_planning_prototype", "StaffPlanning", ["Standard Staff Planning", $systemAuthor, 0]);
// 4. Clonar el prototipo "std_staff_planning_prototype"
/** @var StaffPlanning $staffPlanning */
$staffPlanning = $odsManager->createFromPrototype("std_staff_planning_prototype");
// 5. Modificar el prototipo clonado
$staffPlanning->setTitle("Sales Staff Planning");
$staffPlanning->setStaffCode(3414);
$staffPlanning->getAuthor()->setName("Staff Office");
$staffPlanning->getAuthor()->setEmail("staff@corp.com");
// 6. Usar el prototipo
echo "-> Creado PRIMER documento concreto (clon) de tipo StaffPlanning:\n";
echo $staffPlanning->getInfo() . "\n\n";

// ---------------------------------------------------------------------------
// 3. VERIFICACIÓN DE INDEPENDENCIA TOTAL (TRIPLE COMPARATIVA)
// ---------------------------------------------------------------------------
echo "=== VERIFICACIONES DE INDEPENDENCIA TOTAL ===\n\n";

// --- CASO 1: DOMINIO DE DOCUMENTOS DE TEXTO (LETTER) ---
echo "\n--- Comparativa Triple: LETTER ---\n";

/** @var Letter $anotherLetter */
$anotherLetter = $odtManager->createFromPrototype("std_letter_prototype");
$anotherLetter->setTitle("Promotion Letter");
$anotherLetter->getAuthor()->setName("Promotion Team");
$anotherLetter->getAuthor()->setEmail("promotion@corp.com");
$anotherLetter->setRecipient("Antonio González");

echo "-> Creado SEGUNDO documento concreto (clon) de tipo Letter:\n";
echo $anotherLetter->getInfo() . "\n\n";

// A. Recuperamos el PROTOTIPO (el molde maestro) del gestor
$letterPrototype = $odtManager->getPrototype("std_letter_prototype");

// B. Mostramos el estado actual de los tres objetos
echo "=== Documentos disponibles para comparar ===\n";
echo "1. PROTOTIPO maestro:   " . $letterPrototype->getInfo() . "\n";
echo "2. PRIMER documento:    " . $myLetter->getInfo() . "\n";
echo "3. SEGUNDO documento:   " . $anotherLetter->getInfo() . "\n";

// C. Realizamos las comparaciones cruzadas
echo "\n> Comparando Prototipo vs Primer documento:\n";
verifyIndependence($letterPrototype, $myLetter, "Prototype vs Letter 1");

echo "\n> Comparando Prototipo vs Segundo documento:\n";
verifyIndependence($letterPrototype, $anotherLetter, "Prototype vs Letter 2");

echo "\n> Comparando Primer documento vs Segundo documento:\n";
verifyIndependence($myLetter, $anotherLetter, "Letter 1 vs Letter 2");

// --- CASO 2: DOMINIO DE HOJAS DE CÁLCULO (BUDGET) ---
echo "--- Comparativa Triple: BUDGET ---\n";

/** @var Budget $anotherBudget */
$anotherBudget = $odsManager->createFromPrototype("std_budget_prototype");
$anotherBudget->setTitle("IT Dept Budget");
$anotherBudget->setTotalAmount(50000.00);
$anotherBudget->getAuthor()->setName("IT Office");
$anotherBudget->getAuthor()->setEmail("it@corp.com");
echo "-> Creado SEGUNDO documento concreto (clon) de tipo Budget:\n";
echo $anotherBudget->getInfo() . "\n\n";

// A. Recuperamos el PROTOTIPO (el molde maestro) del gestor
$budgetPrototype = $odsManager->getPrototype("std_budget_prototype");

// B. Mostramos el estado actual de los tres objetos
echo "=== Documentos disponibles para comparar ===\n";
echo "1. PROTOTIPO maestro:   " . $budgetPrototype->getInfo() . "\n";
echo "2. PRIMER documento:    " . $marketingBudget->getInfo() . "\n";
echo "3. SEGUNDO documento:   " . $anotherBudget->getInfo() . "\n";

// C. Realizamos las comparaciones cruzadas
echo "\n> Comparando Prototipo vs Primer documento:\n";
verifyIndependence($budgetPrototype, $marketingBudget, "Prototype vs Budget 1");

echo "\n> Comparando Prototipo vs Segundo documento:\n";
verifyIndependence($budgetPrototype, $anotherBudget, "Prototype vs Budget 2");

echo "\n> Comparando Primer documento vs Segundo documento:\n";
verifyIndependence($marketingBudget, $anotherBudget, "Budget 1 vs Budget 2");

echo "=== CONCLUSIÓN FINAL ===\n";
echo "Queda demostrado que el Prototipo (molde maestro) reside en el Registry \n";
echo "totalmente protegido y ajeno a las modificaciones que sufran los objetos \n";
echo "que la aplicación crea (clona) a partir de él.\n";
