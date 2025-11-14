# Sistema de Asistencia

Descripción breve  
Este proyecto permite registrar la asistencia diaria de alumnos. Los registros se guardan en archivos de texto diarios (Archivos/YYYY-MM-DD.txt) y, si hay conexión a MySQL, también se insertan/actualizan en la tabla `Asistencia`.

Requisitos

- PHP y servidor web (por ejemplo XAMPP/Apache).
- MySQL/MariaDB.
- Permisos de escritura en la carpeta `Archivos/`.

Estructura relevante

- php/config.php            -> configuración de conexión a la BD.
- php/GeneraArchivo.php     -> procesa el formulario, genera archivo .txt e inserta/actualiza en BD.
- Asistencia.php            -> formulario web para marcar asistencias; lee alumnos desde la BD o, si no hay conexión, desde `Archivos/Alumnos.txt`.
- Archivos/                 -> carpeta donde se guardan los archivos de asistencia y puede contener `Alumnos.txt` como respaldo.
- sql/create_db_and_tables.sql -> script para crear la BD y las tablas.
- sql/insert_data.sql       -> script para insertar datos de ejemplo.

Instalación rápida

1. Copie la carpeta del proyecto a la raíz de su servidor web (por ejemplo `c:\xampp\htdocs\App-para-tomar-asistencias-main`).
2. Ajuste las credenciales en `php/config.php` (usuario/clave/host) según su entorno.
3. Inicie Apache y MySQL.
4. En su administrador MySQL (phpMyAdmin o CLI) importe primero `sql/create_db_and_tables.sql` y luego `sql/insert_data.sql`.
5. Asegúrese que la carpeta `Archivos/` sea escribible por el servidor web.

Uso

1. Abra en el navegador: `http://localhost/App-para-tomar-asistencias-main/Asistencia.php`
2. Seleccione la fecha, ajuste las casillas de asistencia (por defecto marcadas = presente) y presione "Confirmar".
3. Resultado:
   - Se genera un archivo: `Archivos/YYYY-MM-DD.txt`.
   - Formato de cada línea del archivo: `NroMatricula<TAB>Nombre<TAB>Apellido<TAB>Presente` (P o A).
   - Si la BD está disponible, se inserta o actualiza la tabla `Asistencia` (clave primaria: fecha + NroMatricula). En caso de registro ya existente se actualiza el estado de `Presente`.

Notas y recomendaciones

- Verifique credenciales en `php/config.php` y permisos en `Archivos/`.  
- Para depurar, revise los logs de PHP/Apache y las tablas en phpMyAdmin.  
- Puede poblar o actualizar los alumnos con `sql/insert_data.sql` (o usar su propio script SQL).
