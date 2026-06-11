<?php session_start(); if(!isset($_SESSION['alumno'])||($_SESSION['alumno']['rol']??'')!=='admin'){header('Location: index.php?accion=panel');exit;} ?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Libros — SENATI</title>
<link rel="stylesheet" href="view/crud_style.css">
<style>
.badge-activo  {background:#d4edda;color:#155724}
.badge-inactivo{background:#f8d7da;color:#721c24}
tr.inactivo td {opacity:.5}
</style>
</head>
<body>
<div class="topbar"><span class="marca">Intranet SENATI</span>
  <nav>
    <a href="index.php?accion=panel">Panel</a>
    <a href="index.php?accion=libros">Libros</a>
    <a href="index.php?accion=alumnos">Alumnos</a>
    <a href="index.php?accion=logout" class="logout">Salir</a>
  </nav>
</div>
<div class="wrap">
  <?php if($mensaje): ?>
    <div class="alerta alerta-<?php echo $tipo_msg==='ok'?'ok':'error'; ?>">
      <?php echo htmlspecialchars($mensaje); ?>
    </div>
  <?php endif; ?>
  <div class="card">
    <div class="card-header">
      <h2>Gestion de Libros (<?php echo count($libros); ?> registros)</h2>
      <a href="index.php?accion=libros_crear" class="btn btn-primary">+ Nuevo libro</a>
    </div>
    <?php if(empty($libros)): ?>
      <p style="color:#888;text-align:center;padding:20px">Sin registros.</p>
    <?php else: ?>
    <table>
      <thead>
        <tr><th>#</th><th>Titulo</th><th>Autor</th><th>Prestamo</th><th>Estado</th><th>Acciones</th></tr>
      </thead>
      <tbody>
      <?php foreach($libros as $i=>$l): $activo=(int)$l['activo']; ?>
      <tr class="<?php echo $activo?'':'inactivo'; ?>">
        <td><?php echo $i+1; ?></td>
        <td><?php echo htmlspecialchars($l['titulo']); ?></td>
        <td><?php echo htmlspecialchars($l['autor']);  ?></td>
        <td><span class="badge <?php echo strtolower($l['estado'])==='disponible'?'badge-ok':'badge-warn'; ?>">
          <?php echo htmlspecialchars($l['estado']); ?></span></td>
        <td><span class="badge <?php echo $activo?'badge-activo':'badge-inactivo'; ?>">
          <?php echo $activo?'Activo':'Inactivo'; ?></span></td>
        <td><div class="acc">
          <a href="index.php?accion=libros_editar&id=<?php echo $l['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
          <?php if($activo): ?>
            <a href="index.php?accion=libros_desactivar&id=<?php echo $l['id']; ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Desactivar: <?php echo htmlspecialchars(addslashes($l['titulo'])); ?>?')">
               Desactivar</a>
          <?php else: ?>
            <a href="index.php?accion=libros_activar&id=<?php echo $l['id']; ?>"
               class="btn btn-primary btn-sm">Activar</a>
          <?php endif; ?>
        </div></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>
</body></html>
