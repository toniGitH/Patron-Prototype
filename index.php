<?php
require_once 'main.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patrón Prototype - Gestor de Documentos</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>🤖 Patrón Prototype</h1>
            <p>Clonación de objetos complejos y gestión de plantillas en PHP</p>
        </header>

        <section>
            <h2>📁 Documentos Generados</h2>
            <?php foreach ($renderData['documents'] as $family => $docs): ?>
                <div class="family-header">
                    <h3 style="margin: 1rem 0; color: var(--text-muted);"><?= $family ?> (Familia)</h3>
                </div>
                <div class="grid">
                    <?php foreach ($docs as $type => $doc): ?>
                        <div class="card">
                            <h3><i class="fas fa-file-alt"></i> <?= $type ?></h3>
                            <div class="info-line">
                                <span class="label">Información completa:</span><br>
                                <?= htmlspecialchars($doc->getInfo()) ?>
                            </div>
                            <div class="info-line">
                                <span class="label">ID de instancia:</span>
                                <code>#<?= spl_object_id($doc) ?></code>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <section>
            <h2>🗄️ Almacén de Prototipos (Registry)</h2>
            <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Objetos maestros que sirven como molde para las clonaciones.</p>
            <?php foreach ($renderData['registry'] as $family => $prototypes): ?>
                <div class="family-header">
                    <h3 style="margin: 1rem 0; color: var(--text-muted);"><?= $family ?> Registry</h3>
                </div>
                <div class="grid">
                    <?php foreach ($prototypes as $alias => $p): ?>
                        <div class="card" style="border-left: 4px solid var(--primary);">
                            <h3><i class="fas fa-microchip"></i> Alias: <?= $alias ?></h3>
                            <div class="info-line">
                                <span class="label">Clase:</span> <code><?= (new ReflectionClass($p))->getShortName() ?></code>
                            </div>
                            <div class="info-line">
                                <span class="label">ID Maestro:</span> <code>#<?= spl_object_id($p) ?></code>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <section class="verification-section">
            <h2>🧪 Verificaciones de Independencia (Triple Comparativa)</h2>
            <p style="margin-bottom: 1.5rem; color: var(--text-muted);">
                Validación técnica de que los clones son objetos independientes en memoria y que se ha realizado una clonación profunda.
            </p>
            
            <div class="grid">
                <?php foreach ($renderData['verifications'] as $verify): ?>
                    <div class="card">
                        <h3><i class="fas fa-shield-alt"></i> <?= $verify['label'] ?></h3>
                        <div class="info-line">
                            <span class="label">ID Objeto 1:</span> <code>#<?= $verify['id1'] ?></code>
                        </div>
                        <div class="info-line">
                            <span class="label">ID Objeto 2:</span> <code>#<?= $verify['id2'] ?></code>
                        </div>
                        
                        <div class="status-badge <?= $verify['diffInstance'] ? 'status-ok' : 'status-error' ?>">
                            <i class="fas <?= $verify['diffInstance'] ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                            Instancias Diferentes: <?= $verify['diffInstance'] ? 'SÍ' : 'NO' ?>
                        </div>
                        
                        <div class="status-badge <?= $verify['diffAuthor'] ? 'status-ok' : 'status-error' ?>">
                            <i class="fas <?= $verify['diffAuthor'] ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                            Clonación Profunda: <?= $verify['diffAuthor'] ? 'SÍ' : 'NO' ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section>
            <h2>🎯 Ventajas del Patrón</h2>
            <div class="advantages">
                <div class="advantage-tag"><i class="fas fa-bolt"></i> Ahorro de recursos</div>
                <div class="advantage-tag"><i class="fas fa-layer-group"></i> Abstracción de clases concretas</div>
                <div class="advantage-tag"><i class="fas fa-recycle"></i> Reutilización de plantillas</div>
                <div class="advantage-tag"><i class="fas fa-code-branch"></i> Flexibilidad en tiempo de ejecución</div>
            </div>
        </section>

        <footer style="margin-top: 4rem; text-align: center; color: var(--text-muted); font-size: 0.8rem;">
            Patrón Prototype - Ejemplo de Implementación Académica en PHP
        </footer>
    </div>
</body>
</html>
