<?php
// reporte/reporte_pdf.php
// Reporte HTML imprimible — NO requiere Composer ni DomPDF
// El usuario lo imprime con Ctrl+P → "Guardar como PDF"

session_start();
if (!isset($_SESSION['alumno'])) {
    header('Location: ../index.php'); exit;
}

require_once __DIR__ . '/../model/conexion.php';

try {
    $db = Conexion::conectar();

    $libros = $db->query(
        "SELECT titulo, autor, estado FROM biblioteca
         WHERE activo=1 ORDER BY titulo ASC"
    )->fetchAll(PDO::FETCH_ASSOC);

    $carreras = $db->query(
        "SELECT IFNULL(carrera,'Sin carrera') AS carrera,
                COUNT(*) AS total,
                SUM(activo) AS activos,
                SUM(activo=0) AS inactivos
         FROM alumnos GROUP BY carrera ORDER BY total DESC"
    )->fetchAll(PDO::FETCH_ASSOC);

    $t = $db->query(
        "SELECT
            (SELECT COUNT(*) FROM alumnos) AS total_alumnos,
            (SELECT COUNT(*) FROM alumnos WHERE activo=1) AS alumnos_activos,
            (SELECT COUNT(*) FROM biblioteca) AS total_libros,
            (SELECT COUNT(*) FROM biblioteca WHERE estado='Disponible' AND activo=1) AS disponibles,
            (SELECT COUNT(*) FROM biblioteca WHERE estado='Prestado'   AND activo=1) AS prestados"
    )->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Error BD: ' . $e->getMessage());
}

$usuario = htmlspecialchars($_SESSION['alumno']['nombre'].' '.$_SESSION['alumno']['apellidos']);
$fecha   = date('d/m/Y H:i:s');

// Recibir graficas base64 (si vienen del panel via POST)
$imgLibros  = $_POST['img_libros']  ?? '';
$imgAlumnos = $_POST['img_alumnos'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte SENATI — <?= $fecha ?></title>
<style>
/* ── Estilos pantalla ────────────────────────── */
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',Arial,sans-serif;background:#e8eef8;
     display:flex;flex-direction:column;align-items:center;padding:24px}
.pagina{width:210mm;background:white;padding:18mm 16mm;
        box-shadow:0 4px 20px rgba(0,0,0,.18);margin-bottom:20px}
.btn-imprimir{padding:12px 30px;background:#1A2B5F;color:white;
              border:none;border-radius:7px;font-size:15px;font-weight:700;
              cursor:pointer;margin-bottom:20px}
.btn-imprimir:hover{background:#0f1e45}
.btn-volver{padding:12px 24px;background:#6c757d;color:white;
            border:none;border-radius:7px;font-size:14px;cursor:pointer;
            margin-bottom:20px;margin-left:10px;text-decoration:none;
            display:inline-block}

/* ── Encabezado ──────────────────────────────── */
.header{background:#1A2B5F;color:white;padding:14px 18px;
        border-radius:6px;margin-bottom:16px;text-align:center}
.header h1{font-size:17px;margin-bottom:3px}
.header p{font-size:10px;color:#ccc}

/* ── Tarjetas totales ────────────────────────── */
.tarjetas{display:grid;grid-template-columns:repeat(5,1fr);
          gap:8px;margin-bottom:16px}
.tarjeta{background:#1A2B5F;color:white;border-radius:6px;
         padding:10px 6px;text-align:center}
.tarjeta .num{display:block;font-size:22px;font-weight:700;color:#F28C28}
.tarjeta .lbl{font-size:9px;color:#ccc}

/* ── Secciones ───────────────────────────────── */
h2{color:#1A2B5F;font-size:12px;border-bottom:2px solid #F28C28;
   padding-bottom:3px;margin:16px 0 8px}

/* ── Graficas ────────────────────────────────── */
.graficas{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px}
.graf-box{border:1px solid #ddd;border-radius:5px;padding:8px;text-align:center}
.graf-box p{font-size:10px;font-weight:700;color:#1A2B5F;margin-bottom:6px}
.graf-box img{max-width:100%;height:auto}
.graf-box .no-graf{color:#999;font-size:9px;padding:10px}

/* ── Tablas ──────────────────────────────────── */
table{width:100%;border-collapse:collapse;margin-bottom:12px;font-size:10px}
thead tr{background:#1A2B5F;color:white}
th{padding:5px 8px;text-align:left;font-size:9px;letter-spacing:.3px}
td{padding:4px 8px;border-bottom:1px solid #eee}
tbody tr:nth-child(even) td{background:#f4f7fc}
.d{color:#155724;font-weight:700}
.p{color:#721c24;font-weight:700}

/* ── Footer ──────────────────────────────────── */
.footer{text-align:center;color:#888;font-size:9px;
        border-top:1px solid #ddd;padding-top:8px;margin-top:16px}

/* ── IMPRIMIR — oculta todo menos la pagina ──── */
@media print {
    body{background:white;padding:0}
    .no-print{display:none !important}
    .pagina{box-shadow:none;padding:10mm 10mm;margin:0;width:100%}
    @page{size:A4 portrait;margin:10mm}
}
</style>
</head>
<body>

<!-- Botones (no se imprimen) -->
<div class="no-print">
  <button class="btn-imprimir" onclick="window.print()">
    Imprimir / Guardar PDF
  </button>
  <a href="../index.php?accion=panel" class="btn-volver">Volver al panel</a>
  <br>
  <small style="color:#555;font-size:12px">
    Al imprimir: selecciona "Guardar como PDF" en el destino de impresion
  </small>
</div>

<!-- PAGINA DEL REPORTE -->
<div class="pagina">

  <!-- Encabezado -->
  <div class="header">
    <h1>Reporte General — Intranet Academica SENATI</h1>
    <p>Generado por: <?= $usuario ?>  &nbsp;|&nbsp;  Fecha: <?= $fecha ?></p>
  </div>

  <!-- Tarjetas resumen -->
  <h2>Resumen general</h2>
  <div class="tarjetas">
    <div class="tarjeta"><span class="num"><?= $t['total_alumnos'] ?></span><span class="lbl">Total Alumnos</span></div>
    <div class="tarjeta"><span class="num"><?= $t['alumnos_activos'] ?></span><span class="lbl">Activos</span></div>
    <div class="tarjeta"><span class="num"><?= $t['total_libros'] ?></span><span class="lbl">Total Libros</span></div>
    <div class="tarjeta"><span class="num"><?= $t['disponibles'] ?></span><span class="lbl">Disponibles</span></div>
    <div class="tarjeta"><span class="num"><?= $t['prestados'] ?></span><span class="lbl">Prestados</span></div>
  </div>

  <!-- Graficas -->
  <h2>Estadisticas visuales</h2>
  <div class="graficas">
    <div class="graf-box">
      <p>Estado de Libros</p>
      <?php if($imgLibros): ?>
        <img src="<?= $imgLibros ?>">
      <?php else: ?>
        <div class="no-graf">Usa el boton "Exportar PDF" desde el panel para ver las graficas</div>
      <?php endif; ?>
    </div>
    <div class="graf-box">
      <p>Alumnos por Carrera</p>
      <?php if($imgAlumnos): ?>
        <img src="<?= $imgAlumnos ?>">
      <?php else: ?>
        <div class="no-graf">Usa el boton "Exportar PDF" desde el panel para ver las graficas</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Tabla libros -->
  <h2>Inventario de Libros Activos (<?= count($libros) ?> registros)</h2>
  <table>
    <thead>
      <tr><th>#</th><th>Titulo</th><th>Autor</th><th>Estado</th></tr>
    </thead>
    <tbody>
      <?php foreach($libros as $i=>$l): ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td><?= htmlspecialchars($l['titulo']) ?></td>
        <td><?= htmlspecialchars($l['autor'])  ?></td>
        <td class="<?= strtolower($l['estado'])==='disponible'?'d':'p' ?>">
          <?= htmlspecialchars($l['estado']) ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Tabla carreras -->
  <h2>Alumnos por Carrera</h2>
  <table>
    <thead>
      <tr><th>Carrera</th><th>Total</th><th>Activos</th><th>Inactivos</th></tr>
    </thead>
    <tbody>
      <?php foreach($carreras as $c): ?>
      <tr>
        <td><?= htmlspecialchars($c['carrera']) ?></td>
        <td><strong><?= $c['total'] ?></strong></td>
        <td style="color:#155724"><?= $c['activos'] ?></td>
        <td style="color:#721c24"><?= $c['inactivos'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="footer">
    SENATI Huanuco &mdash; Intranet Academica &mdash;
    Backend Developer Web (PIAD-318) &mdash; <?= $fecha ?>
  </div>

</div><!-- fin .pagina -->

</body>
</html>
