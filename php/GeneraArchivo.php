<?php
if (!isset($_POST['fecha'], $_POST['legajo'])) {
    die('Datos incompletos.');
}

require_once __DIR__ . '/config.php';

$fecha = $_POST['fecha'];
$legajos = $_POST['legajo'];
$asistencias = isset($_POST['asistencia']) ? $_POST['asistencia'] : [];
$nombres = isset($_POST['nombre']) ? $_POST['nombre'] : [];
$apellidos = isset($_POST['apellido']) ? $_POST['apellido'] : [];

$fecha_archivo = $fecha;
$archivo = __DIR__ . '/../Archivos/' . $fecha_archivo . '.txt';

$lineas = [];
foreach ($legajos as $idx => $legajo) {
    $presente = (isset($asistencias[$legajo]) && $asistencias[$legajo] === 'P') ? 'P' : 'A';
    $nombre = isset($nombres[$idx]) ? $nombres[$idx] : '';
    $apellido = isset($apellidos[$idx]) ? $apellidos[$idx] : '';
    $lineas[] = $legajo . "\t" . $nombre . "\t" . $apellido . "\t" . $presente;
}

file_put_contents($archivo, implode(PHP_EOL, $lineas));

if (isset($mysqli) && !$mysqli->connect_errno) {
    $stmt = $mysqli->prepare("INSERT INTO Asistencia (fecha, NroMatricula, Presente) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE Presente = VALUES(Presente)");
    if ($stmt) {
        foreach ($legajos as $legajo) {
            $presente = (isset($asistencias[$legajo]) && $asistencias[$legajo] === 'P') ? 'P' : 'A';
            $stmt->bind_param('sis', $fecha, $legajo, $presente);
            $stmt->execute();
        }
        $stmt->close();
    }
}

echo "Archivo de asistencia generado correctamente: " . htmlspecialchars($fecha_archivo) . ".txt<br>";
echo '<a href="../Asistencia.php">Volver</a>';
?>
