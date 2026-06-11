<?php
// reporte/reporte_pdf.php
// Genera PDF del reporte con graficas usando DomPDF
// Recibe las graficas como imagenes base64 via POST desde panel_view.php

session_start();

if (!isset($_SESSION['alumno'])) {
    header('Location: ../index.php');
    exit;
}

// ── Cargar DomPDF ──────────────────────────────────────────────
// vendor/ debe estar en la RAIZ del proyecto (un nivel arriba de reporte/)
$autoload = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($autoload)) {
    die('<h2 style="font-family:Arial;color:#cc0000;padding:30px">
         Error: DomPDF no esta instalado.<br><br>
         Ejecuta en la raiz del proyecto:<br>
         <code style="background:#f4f4f4;padding:8px">composer require dompdf/dompdf</code>
         </h2>');
}

require_once $autoload;

use Dompdf\Dompdf;
use Dompdf\Options;

// ── Recibir graficas base64 desde POST ────────────────────────
$imgLibros  = $_POST['img_libros']  ?? '';
$imgAlumnos = $_POST['img_alumnos'] ?? '';

// ── Consultar datos de la BD ──────────────────────────────────
require_once __DIR__ . '/../model/conexion.php';

try {
    $db = Conexion::conectar();

    // Tabla libros (solo activos)
    $libros = $db->query(
        "SELECT titulo, autor, estado FROM biblioteca
         WHERE activo = 1 ORDER BY titulo ASC"
    )->fetchAll(PDO::FETCH_ASSOC);

    // Tabla alumnos — resumen por carrera
    $carreras = $db->query(
        "SELECT IFNULL(carrera,'Sin carrera') AS carrera,
                COUNT(*) AS total,
                SUM(activo) AS activos,
                SUM(activo=0) AS inactivos
         FROM alumnos
         GROUP BY carrera
         ORDER BY total DESC"
    )->fetchAll(PDO::FETCH_ASSOC);

    // Totales generales
    $totales = $db->query(
        "SELECT
            (SELECT COUNT(*) FROM alumnos)          AS total_alumnos,
            (SELECT COUNT(*) FROM alumnos WHERE activo=1) AS alumnos_activos,
            (SELECT COUNT(*) FROM biblioteca)       AS total_libros,
            (SELECT COUNT(*) FROM biblioteca WHERE estado='Disponible' AND activo=1) AS disponibles,
            (SELECT COUNT(*) FROM biblioteca WHERE estado='Prestado'   AND activo=1) AS prestados
        "
    )->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Error de base de datos: ' . $e->getMessage());
}

// ── Datos del usuario que genera el reporte ───────────────────
$usuario = htmlspecialchars(
    $_SESSION['alumno']['nombre'] . ' ' . $_SESSION['alumno']['apellidos']
);
$fecha = date('d/m/Y H:i:s');

// ── Construir HTML del reporte ────────────────────────────────
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body  { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #222; margin: 0; padding: 0; }
  h1    { color: #1A2B5F; font-size: 18px; text-align: center; margin: 0 0 4px 0; }
  h2    { color: #1A2B5F; font-size: 13px; margin: 18px 0 6px 0;
          border-bottom: 2px solid #F28C28; padding-bottom: 3px; }
  .sub  { text-align: center; color: #666; font-size: 10px; margin-bottom: 16px; }
  .header-bar { background: #1A2B5F; color: white; padding: 12px 20px;
                margin-bottom: 16px; border-radius: 4px; }
  .header-bar h1 { color: white; margin: 0 0 2px 0; }
  .header-bar p  { margin: 0; font-size: 10px; color: #ccc; text-align: center; }

  /* Tarjetas de totales */
  .totales { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
  .totales td { width: 20%; text-align: center; padding: 8px 4px; }
  .tarjeta { background: #1A2B5F; color: white; border-radius: 4px; padding: 8px; }
  .tarjeta .num { font-size: 22px; font-weight: bold; display: block; color: #F28C28; }
  .tarjeta .lbl { font-size: 9px; color: #ccc; }

  /* Graficas */
  .graficas { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
  .graficas td { width: 50%; vertical-align: top; padding: 0 6px; }
  .graf-box { border: 1px solid #ddd; border-radius: 4px; padding: 8px; text-align: center; }
  .graf-box p { font-size: 10px; font-weight: bold; color: #1A2B5F; margin: 0 0 6px 0; }
  .graf-box img { max-width: 100%; height: auto; }

  /* Tablas de datos */
  table.data { width: 100%; border-collapse: collapse; margin-bottom: 14px; font-size: 10px; }
  table.data thead tr { background: #1A2B5F; color: white; }
  table.data th { padding: 6px 8px; text-align: left; font-size: 10px; }
  table.data td { padding: 5px 8px; border-bottom: 1px solid #eee; }
  table.data tbody tr:nth-child(even) td { background: #f4f7fc; }
  .badge-d { color: #155724; font-weight: bold; }
  .badge-p { color: #721c24; font-weight: bold; }
  .footer { text-align: center; color: #888; font-size: 9px; margin-top: 20px;
            border-top: 1px solid #ddd; padding-top: 8px; }
</style>
</head>
<body>

<!-- ENCABEZADO -->
<div class="header-bar">
  <h1>Reporte General — Intranet Academica SENATI</h1>
  <p>Generado por: <?= $usuario ?>  &nbsp;|&nbsp;  Fecha: <?= $fecha ?></p>
</div>

<!-- TARJETAS RESUMEN -->
<h2>Resumen general</h2>
<table class="totales">
  <tr>
    <td><div class="tarjeta"><span class="num"><?= $totales['total_alumnos'] ?></span><span class="lbl">Total Alumnos</span></div></td>
    <td><div class="tarjeta"><span class="num"><?= $totales['alumnos_activos'] ?></span><span class="lbl">Alumnos Activos</span></div></td>
    <td><div class="tarjeta"><span class="num"><?= $totales['total_libros'] ?></span><span class="lbl">Total Libros</span></div></td>
    <td><div class="tarjeta"><span class="num"><?= $totales['disponibles'] ?></span><span class="lbl">Disponibles</span></div></td>
    <td><div class="tarjeta"><span class="num"><?= $totales['prestados'] ?></span><span class="lbl">Prestados</span></div></td>
  </tr>
</table>

<!-- GRAFICAS -->
<h2>Estadisticas visuales</h2>
<table class="graficas">
  <tr>
    <td>
      <div class="graf-box">
        <p>Estado de Libros</p>
        <?php if ($imgLibros): ?>
          <img src="<?= $imgLibros ?>">
        <?php else: ?>
          <p style="color:#999;font-size:9px">(Grafica no disponible — abre el PDF desde el panel)</p>
        <?php endif; ?>
      </div>
    </td>
    <td>
      <div class="graf-box">
        <p>Alumnos por Carrera</p>
        <?php if ($imgAlumnos): ?>
          <img src="<?= $imgAlumnos ?>">
        <?php else: ?>
          <p style="color:#999;font-size:9px">(Grafica no disponible — abre el PDF desde el panel)</p>
        <?php endif; ?>
      </div>
    </td>
  </tr>
</table>

<!-- TABLA LIBROS -->
<h2>Inventario de Libros Activos (<?= count($libros) ?> registros)</h2>
<table class="data">
  <thead>
    <tr><th>#</th><th>Titulo</th><th>Autor</th><th>Estado</th></tr>
  </thead>
  <tbody>
    <?php foreach ($libros as $i => $l): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= htmlspecialchars($l['titulo']) ?></td>
      <td><?= htmlspecialchars($l['autor'])  ?></td>
      <td class="<?= strtolower($l['estado']) === 'disponible' ? 'badge-d' : 'badge-p' ?>">
        <?= htmlspecialchars($l['estado']) ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- TABLA CARRERAS -->
<h2>Alumnos por Carrera</h2>
<table class="data">
  <thead>
    <tr><th>Carrera</th><th>Total</th><th>Activos</th><th>Inactivos</th></tr>
  </thead>
  <tbody>
    <?php foreach ($carreras as $c): ?>
    <tr>
      <td><?= htmlspecialchars($c['carrera']) ?></td>
      <td><strong><?= $c['total'] ?></strong></td>
      <td style="color:#155724"><?= $c['activos'] ?></td>
      <td style="color:#721c24"><?= $c['inactivos'] ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<p class="footer">
  SENATI Huanuco &mdash; Intranet Academica &mdash;
  Curso: Backend Developer Web (PIAD-318) &mdash; <?= $fecha ?>
</p>

</body>
</html>
<?php
$html = ob_get_clean();

// ── Configurar y ejecutar DomPDF ──────────────────────────────
$options = new Options();
$options->set('isRemoteEnabled', true);   // necesario para imagenes base64
$options->set('defaultFont', 'DejaVu Sans');
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Descargar el PDF
$dompdf->stream('reporte_senati_' . date('Ymd_His') . '.pdf', [
    'Attachment' => true   // true = descarga | false = abre en navegador
]);
