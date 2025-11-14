<?php
$alumnos = [];
try {
    require_once __DIR__ . '/php/config.php';
    if (!isset($mysqli) || $mysqli->connect_errno) {
        throw new Exception('No DB');
    }

    $sql = "SELECT NroMatricula AS legajo, Nombre AS nombre, Apellido AS apellido FROM Alumno ORDER BY NroMatricula";
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $alumnos[] = [
                'legajo' => $row['legajo'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido']
            ];
        }
        $result->free();
    } else {
        throw new Exception('Query error');
    }
} catch (Exception $e) {
    $archivo = __DIR__ . '/Archivos/Alumnos.txt';
    if (file_exists($archivo)) {
        $lines = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = preg_split('/\s+/', trim($line));
            if (count($parts) >= 3) {
                $alumnos[] = [
                    'legajo' => $parts[0],
                    'nombre' => $parts[1],
                    'apellido' => $parts[2]
                ];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sistema de Asistencia</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>SISTEMA DE ASISTENCIA</h2>

        <div style="background:#eef;padding:10px;margin-bottom:15px;">
            Seleccione la fecha, ajuste las casillas de asistencia y presione <b>Confirmar</b>.
        </div>

        <form method="post" action="php/GeneraArchivo.php" onsubmit="return validarFecha();">
            <label>Fecha: <input type="date" name="fecha" id="fecha"></label>
            <br><br>
            <table border="1">
                <tr>
                    <th>Nro. de legajo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Asistencia</th>
                </tr>
                <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <td>
                        <input type="hidden" name="legajo[]" value="<?php echo htmlspecialchars($alumno['legajo']); ?>">
                        <?php echo htmlspecialchars($alumno['legajo']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($alumno['nombre']); ?>
                        <input type="hidden" name="nombre[]" value="<?php echo htmlspecialchars($alumno['nombre']); ?>">
                    </td>
                    <td>
                        <?php echo htmlspecialchars($alumno['apellido']); ?>
                        <input type="hidden" name="apellido[]" value="<?php echo htmlspecialchars($alumno['apellido']); ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="asistencia[<?php echo htmlspecialchars($alumno['legajo']); ?>]" value="P" checked>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <button type="submit">Confirmar</button>
            <button type="reset">Borrar</button>
        </form>
        <script>
        function validarFecha() {
            var fecha = document.getElementById('fecha').value;
            if (!fecha) {
                alert('Por favor, ingrese una fecha.');
                return false;
            }
            return true;
        }
        </script>
    </body>
</html>