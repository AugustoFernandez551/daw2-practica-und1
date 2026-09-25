<?php
/**
 * Evaluador automático - DAW II Unidad I
 * Uso: php tests/evaluar.php /ruta/al/proyecto-del-estudiante
 *
 * Este archivo se ejecuta desde una copia confiable de la rama base.
 */

$root = $argv[1] ?? getcwd();
$root = realpath($root);

if (!$root) {
    fwrite(STDERR, "No se pudo localizar el proyecto del estudiante.\n");
    exit(2);
}

$results = [];
$total = 0;
$variant = null;

$configs = [
    'A' => [
        'name' => 'Préstamo de equipos de laboratorio',
        'entity' => 'Prestamo',
        'table' => 'prestamos',
        'properties' => ['id', 'estudiante', 'equipo', 'fecha', 'estado'],
        'registerArgs' => ['Estudiante GitHub', 'Tablet Test', '2026-09-24'],
        'insertLookupColumn' => 'estudiante',
        'insertLookupValue' => 'Estudiante GitHub',
        'searchTerm' => 'Ana Torres',
        'searchColumn' => 'estudiante',
        'seedId' => 1,
        'targetState' => 'DEVUELTO',
    ],
    'B' => [
        'name' => 'Incidencias de soporte TI',
        'entity' => 'Incidencia',
        'table' => 'incidencias',
        'properties' => ['id', 'usuario', 'asunto', 'prioridad', 'estado'],
        'registerArgs' => ['Usuario GitHub', 'Incidencia de prueba automatizada', 'ALTA'],
        'insertLookupColumn' => 'usuario',
        'insertLookupValue' => 'Usuario GitHub',
        'searchTerm' => 'Carlos Pérez',
        'searchColumn' => 'usuario',
        'seedId' => 1,
        'targetState' => 'ATENDIDO',
    ],
    'C' => [
        'name' => 'Inventario de equipos informáticos',
        'entity' => 'Equipo',
        'table' => 'equipos',
        'properties' => ['id', 'codigo', 'nombre', 'categoria', 'estado'],
        'registerArgs' => ['EQ-GH-001', 'Equipo GitHub', 'Tablet'],
        'insertLookupColumn' => 'codigo',
        'insertLookupValue' => 'EQ-GH-001',
        'searchTerm' => 'Laptop',
        'searchColumn' => 'categoria',
        'seedId' => 1,
        'targetState' => 'BAJA',
    ],
];

function addResult(string $criterion, int $score, string $detail): void
{
    global $results, $total;
    $score = max(0, min(2, $score));
    $results[] = [$criterion, $score, $detail];
    $total += $score;
}

function fileText(string $path): string
{
    return is_file($path) ? (string) file_get_contents($path) : '';
}

function hasExactNamespace(string $source, string $namespace): bool
{
    return (bool) preg_match('/\bnamespace\s+' . preg_quote($namespace, '/') . '\s*;/', $source);
}

function safeClassExists(string $class): bool
{
    try {
        return class_exists($class);
    } catch (Throwable $e) {
        return false;
    }
}

function safeNew(string $class)
{
    try {
        return new $class();
    } catch (Throwable $e) {
        return null;
    }
}

function db(): PDO
{
    return new PDO(
        "mysql:host=127.0.0.1;dbname=practica_daw2_und1;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
}

function containsRow(array $rows, string $column, string $value): bool
{
    foreach ($rows as $row) {
        if (is_array($row) && isset($row[$column]) && (string)$row[$column] === $value) {
            return true;
        }
        if (is_object($row) && isset($row->$column) && (string)$row->$column === $value) {
            return true;
        }
    }
    return false;
}

// -----------------------------------------------------------------------------
// 1. Detectar variante y estructura
// -----------------------------------------------------------------------------
$foundVariants = [];
foreach ($configs as $key => $cfg) {
    $entity = $cfg['entity'];
    $files = [
        "$root/dto/$entity.php",
        "$root/dao/$entity.php",
        "$root/bo/$entity.php",
    ];
    $count = count(array_filter($files, 'is_file'));
    if ($count > 0) {
        $foundVariants[$key] = $count;
    }
}

if (count($foundVariants) === 1) {
    $variant = array_key_first($foundVariants);
    $count = $foundVariants[$variant];
    addResult(
        '1. Estructura de capas',
        $count === 3 ? 2 : 1,
        $count === 3
            ? "Variante {$variant} detectada y archivos DTO/DAO/BO presentes."
            : "Variante {$variant} detectada, pero faltan archivos de capa."
    );
} elseif (count($foundVariants) > 1) {
    addResult('1. Estructura de capas', 0, 'Se detectaron archivos correspondientes a más de una variante.');
} else {
    addResult('1. Estructura de capas', 0, 'No se pudo detectar ninguna variante.');
}

if ($variant === null) {
    for ($i = 2; $i <= 10; $i++) {
        addResult("$i. Criterio no evaluable", 0, 'No se pudo determinar la variante entregada.');
    }
    goto OUTPUT;
}

$cfg = $configs[$variant];
$entity = $cfg['entity'];
$dtoFile = "$root/dto/$entity.php";
$daoFile = "$root/dao/$entity.php";
$boFile  = "$root/bo/$entity.php";
$indexFile = "$root/index.php";

// -----------------------------------------------------------------------------
// 2. DTO / POO
// -----------------------------------------------------------------------------
$dtoClass = "dto\\$entity";
$dtoScore = 0;
$dtoDetail = 'No se pudo cargar la clase DTO.';

try {
    require_once "$root/config/Autoload.php";
    if (safeClassExists($dtoClass)) {
        $ref = new ReflectionClass($dtoClass);
        $props = array_map(fn($p) => $p->getName(), $ref->getProperties());
        $present = count(array_intersect($cfg['properties'], $props));
        if ($present === count($cfg['properties'])) {
            $dtoScore = 2;
            $dtoDetail = 'DTO creado con todas las propiedades esperadas.';
        } elseif ($present >= 3) {
            $dtoScore = 1;
            $dtoDetail = "DTO existe, pero solo se detectaron {$present} de " . count($cfg['properties']) . ' propiedades esperadas.';
        } else {
            $dtoDetail = 'DTO existe, pero su modelado está incompleto.';
        }
    }
} catch (Throwable $e) {
    $dtoDetail = 'Error al cargar DTO: ' . $e->getMessage();
}
addResult('2. POO y DTO', $dtoScore, $dtoDetail);

// -----------------------------------------------------------------------------
// 3. Namespaces
// -----------------------------------------------------------------------------
$nsHits = 0;
if (hasExactNamespace(fileText($dtoFile), 'dto')) $nsHits++;
if (hasExactNamespace(fileText($daoFile), 'dao')) $nsHits++;
if (hasExactNamespace(fileText($boFile), 'bo')) $nsHits++;
addResult(
    '3. Namespaces',
    $nsHits === 3 ? 2 : ($nsHits > 0 ? 1 : 0),
    "Namespaces correctos detectados en {$nsHits} de 3 clases."
);

// -----------------------------------------------------------------------------
// 4. Autoload
// -----------------------------------------------------------------------------
$autoloadHits = 0;
foreach (["dto\\$entity", "dao\\$entity", "bo\\$entity"] as $class) {
    if (safeClassExists($class)) $autoloadHits++;
}
addResult(
    '4. Autoload',
    $autoloadHits === 3 ? 2 : ($autoloadHits > 0 ? 1 : 0),
    "El autoload pudo localizar {$autoloadHits} de 3 clases de la variante."
);

// -----------------------------------------------------------------------------
// 5. Uso de Conexion en DAO
// -----------------------------------------------------------------------------
$daoSource = fileText($daoFile);
$usesNewConexion = (bool) preg_match('/new\s+Conexion\s*\(/i', $daoSource);
$usesGetConexion = str_contains($daoSource, 'getConexion(');
$daoClass = "dao\\$entity";
$daoObj = safeNew($daoClass);

if ($usesNewConexion && $usesGetConexion && $daoObj !== null) {
    addResult('5. Conexión PDO desde DAO', 2, 'DAO instancia Conexion, obtiene PDO y puede construirse correctamente.');
} elseif (($usesNewConexion || $usesGetConexion) && $daoObj !== null) {
    addResult('5. Conexión PDO desde DAO', 1, 'DAO puede construirse, pero la integración con Conexion está parcialmente implementada.');
} else {
    addResult('5. Conexión PDO desde DAO', 0, 'No se comprobó correctamente la integración del DAO con Conexion.');
}

// -----------------------------------------------------------------------------
// 6. Sentencias preparadas
// -----------------------------------------------------------------------------
$hasPrepare = str_contains($daoSource, '->prepare(');
$hasExecute = str_contains($daoSource, '->execute(');
$hasBinding = str_contains($daoSource, 'bindParam(')
    || str_contains($daoSource, 'bindValue(')
    || (bool) preg_match('/:[a-zA-Z_][a-zA-Z0-9_]*/', $daoSource);

if ($hasPrepare && $hasExecute && $hasBinding) {
    addResult('6. Sentencias preparadas', 2, 'Se detecta prepare(), execute() y parámetros enlazados/nombrados.');
} elseif ($hasPrepare && $hasExecute) {
    addResult('6. Sentencias preparadas', 1, 'Se detecta prepare() y execute(), pero no se pudo confirmar el uso correcto de parámetros.');
} else {
    addResult('6. Sentencias preparadas', 0, 'No se detectó una implementación suficiente de sentencias preparadas.');
}

// -----------------------------------------------------------------------------
// Pruebas funcionales a través de BO
// -----------------------------------------------------------------------------
$boClass = "bo\\$entity";
$bo = safeNew($boClass);
$pdo = null;
try {
    $pdo = db();
} catch (Throwable $e) {
    // Si la BD del grader falla, será visible en cada criterio funcional.
}

// 7. Registrar
$score = 0;
$detail = 'Método registrar() no disponible o no funcional.';
if ($bo !== null && method_exists($bo, 'registrar')) {
    $score = 1;
    try {
        $stmt = $pdo?->prepare("SELECT COUNT(*) FROM {$cfg['table']} WHERE {$cfg['insertLookupColumn']} = :valor");
        $stmt?->execute(['valor' => $cfg['insertLookupValue']]);
        $before = $stmt ? (int)$stmt->fetchColumn() : 0;

        $bo->registrar(...$cfg['registerArgs']);

        $stmt = $pdo?->prepare("SELECT COUNT(*) FROM {$cfg['table']} WHERE {$cfg['insertLookupColumn']} = :valor");
        $stmt?->execute(['valor' => $cfg['insertLookupValue']]);
        $after = $stmt ? (int)$stmt->fetchColumn() : 0;

        if ($after > $before) {
            $score = 2;
            $detail = 'registrar() insertó correctamente un nuevo registro.';
        } else {
            $detail = 'registrar() existe, pero no se comprobó la inserción esperada.';
        }
    } catch (Throwable $e) {
        $detail = 'registrar() existe, pero produjo un error: ' . $e->getMessage();
    }
}
addResult('7. Registrar', $score, $detail);

// 8. Listar + Buscar
$listOk = false;
$searchOk = false;
$listDetail = [];

if ($bo !== null && method_exists($bo, 'listar')) {
    try {
        $rows = $bo->listar();
        $listOk = is_array($rows) && count($rows) >= 2;
        $listDetail[] = $listOk ? 'listar() OK' : 'listar() no devolvió el listado esperado';
    } catch (Throwable $e) {
        $listDetail[] = 'listar() con error';
    }
} else {
    $listDetail[] = 'listar() ausente';
}

if ($bo !== null && method_exists($bo, 'buscar')) {
    try {
        $rows = $bo->buscar($cfg['searchTerm']);
        $searchOk = is_array($rows) && containsRow($rows, $cfg['searchColumn'], $cfg['searchTerm']);
        $listDetail[] = $searchOk ? 'buscar() OK' : 'buscar() no devolvió el registro esperado';
    } catch (Throwable $e) {
        $listDetail[] = 'buscar() con error';
    }
} else {
    $listDetail[] = 'buscar() ausente';
}

addResult(
    '8. Listar y buscar',
    ($listOk && $searchOk) ? 2 : (($listOk || $searchOk) ? 1 : 0),
    implode('; ', $listDetail) . '.'
);

// 9. Cambiar estado
$score = 0;
$detail = 'Método cambiarEstado() no disponible o no funcional.';
if ($bo !== null && method_exists($bo, 'cambiarEstado')) {
    $score = 1;
    try {
        $bo->cambiarEstado($cfg['seedId']);
        $stmt = $pdo?->prepare("SELECT estado FROM {$cfg['table']} WHERE id = :id");
        $stmt?->execute(['id' => $cfg['seedId']]);
        $state = $stmt ? $stmt->fetchColumn() : false;
        if ((string)$state === $cfg['targetState']) {
            $score = 2;
            $detail = "cambiarEstado() actualizó correctamente a {$cfg['targetState']}.";
        } else {
            $detail = 'cambiarEstado() existe, pero el estado final no fue el esperado.';
        }
    } catch (Throwable $e) {
        $detail = 'cambiarEstado() existe, pero produjo un error: ' . $e->getMessage();
    }
}
addResult('9. Cambiar estado', $score, $detail);

// -----------------------------------------------------------------------------
// 10. Integración en index.php + rama
// -----------------------------------------------------------------------------
$indexSource = fileText($indexFile);
$methodCalls = 0;
foreach (['registrar', 'listar', 'buscar', 'cambiarEstado'] as $method) {
    if (preg_match('/->\s*' . preg_quote($method, '/') . '\s*\(/', $indexSource)) {
        $methodCalls++;
    }
}
$htmlOk = stripos($indexSource, '<form') !== false && stripos($indexSource, '<table') !== false;
$branch = getenv('STUDENT_BRANCH') ?: '';
$branchOk = str_starts_with($branch, 'practica/') && strlen($branch) > strlen('practica/');

if ($methodCalls === 4 && $htmlOk && $branchOk) {
    addResult('10. Integración y entrega', 2, 'index.php integra las cuatro operaciones y la rama respeta practica/nombre-apellidos.');
} elseif ($methodCalls >= 2 || ($htmlOk && $branchOk)) {
    addResult('10. Integración y entrega', 1, "Integración parcial. Métodos conectados: {$methodCalls}/4; rama: " . ($branchOk ? 'correcta' : 'incorrecta') . '.');
} else {
    addResult('10. Integración y entrega', 0, 'No se comprobó la integración mínima en index.php o el nombre de la rama no es válido.');
}

OUTPUT:
$variantLabel = $variant ? "Variante {$variant} - {$configs[$variant]['name']}" : 'Variante no detectada';

$markdown = [];
$markdown[] = '# Evaluación automática - DAW II Unidad I';
$markdown[] = '';
$markdown[] = "**{$variantLabel}**";
$markdown[] = '';
$markdown[] = '| Criterio | Puntaje | Resultado |';
$markdown[] = '|---|---:|---|';

foreach ($results as [$criterion, $score, $detail]) {
    $icon = $score === 2 ? '✅' : ($score === 1 ? '⚠️' : '❌');
    $safeDetail = str_replace('|', '\\|', $detail);
    $markdown[] = "| {$icon} {$criterion} | {$score}/2 | {$safeDetail} |";
}

$markdown[] = '';
$markdown[] = "## Puntaje automático: **{$total}/20**";
$markdown[] = '';
$markdown[] = '> La calificación automática verifica estructura, POO, namespaces, autoload, PDO y el comportamiento funcional solicitado.';

$output = implode(PHP_EOL, $markdown) . PHP_EOL;
echo $output;

$resultPath = getenv('RESULT_PATH');
if ($resultPath) {
    file_put_contents($resultPath, $output);
}

// El evaluador termina en éxito aunque la nota sea menor que 20.
// Solo un fallo del propio grader debería detener el workflow.
exit(0);
