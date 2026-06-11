<?php session_start(); if(!isset($_SESSION['alumno'])||($_SESSION['alumno']['rol']??'')!=='admin'){header('Location: index.php?accion=panel');exit;} ?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Alumnos — SENATI</title>
<link rel="stylesheet" href="view/crud_style.css">
<style>
.badge-activo  {background:#d4edda;color:#155724}
.badge-inactivo{background:#f8d7da;color:#721c24}
tr.inactivo td {opacity:.5}
</style>
</head>
<body>
<div class="topbar"><span class="marca">Intranet SENATI</span><span class="rol-admin">⚡ ADMIN</span>
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
      <h2>Gestion de Alumnos (<?php echo count($alumnos); ?> registros)</h2>
      <a href="index.php?accion=alumnos_crear" class="btn btn-primary">+ Nuevo alumno</a>
    </div>
    <input type="text" class="filtro" id="filtro"
           placeholder="Filtrar por nombre, apellido o ID..." onkeyup="filtrar()">
    <?php if(empty($alumnos)): ?>
      <p style="color:#888;text-align:center;padding:20px">Sin registros.</p>
    <?php else: ?>
    <table id="tbl">
      <thead>
        <tr><th>ID</th><th>Apellidos</th><th>Nombre</th><th>Carrera</th><th>Estado</th><th>Acciones</th></tr>
      </thead>
      <tbody>
      <?php foreach($alumnos as $a): $activo=(int)$a['activo']; ?>
      <tr class="<?php echo $activo?'':'inactivo'; ?>">
        <td><?php echo $a['id_estudiante']; ?></td>
        <td><?php echo htmlspecialchars($a['apellidos']); ?></td>
        <td><?php echo htmlspecialchars($a['nombre']);    ?></td>
        <td><?php echo htmlspecialchars($a['carrera']);   ?></td>
        <td><span class="badge <?php echo $activo?'badge-activo':'badge-inactivo'; ?>">
          <?php echo $activo?'Activo':'Inactivo'; ?></span></td>
        <td><div class="acc">
          <a href="index.php?accion=alumnos_editar&id=<?php echo $a['id_estudiante']; ?>"
             class="btn btn-warning btn-sm">Editar</a>
          <a href="index.php?accion=alumnos_pwd&id=<?php echo $a['id_estudiante']; ?>"
             class="btn btn-secondary btn-sm">Password</a>
          <?php if($activo): ?>
            <a href="index.php?accion=alumnos_desactivar&id=<?php echo $a['id_estudiante']; ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Desactivar: <?php echo htmlspecialchars(addslashes($a['nombre'].' '.$a['apellidos'])); ?>?')">
               Desactivar</a>
          <?php else: ?>
            <a href="index.php?accion=alumnos_activar&id=<?php echo $a['id_estudiante']; ?>"
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
<script>
function filtrar(){
    const t=document.getElementById('filtro').value.toLowerCase();
    document.querySelectorAll('#tbl tbody tr').forEach(r=>{
        const id=r.cells[0].textContent.toLowerCase();
        const ap=r.cells[1].textContent.toLowerCase();
        const nm=r.cells[2].textContent.toLowerCase();
        r.style.display=(id.includes(t)||ap.includes(t)||nm.includes(t))?'':'none';
    });
}
</script>
</body></html>
