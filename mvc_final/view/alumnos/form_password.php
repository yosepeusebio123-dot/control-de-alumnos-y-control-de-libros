<?php session_start(); if(!isset($_SESSION['alumno'])||($_SESSION['alumno']['rol']??'')!=='admin'){header('Location: index.php?accion=panel');exit;} ?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Cambiar Contrasena — SENATI</title>
<link rel="stylesheet" href="view/crud_style.css"></head>
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
  <div class="card" style="max-width:420px;margin:0 auto">
    <div class="card-header"><h2>Cambiar contrasena</h2></div>
    <p style="margin-bottom:16px;color:#555;font-size:13px">
      Alumno: <strong><?php echo htmlspecialchars($alumno['nombre'].' '.$alumno['apellidos']); ?></strong><br>
      ID: <?php echo $alumno['id_estudiante']; ?>
    </p>
    <?php if($msg): ?>
      <div class="alerta alerta-<?php echo $tipo==='ok'?'ok':'error'; ?>"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?accion=alumnos_cambiar_pwd" onsubmit="return chk()">
      <input type="hidden" name="id_estudiante" value="<?php echo $alumno['id_estudiante']; ?>">
      <div class="form-group">
        <label>Nueva contrasena *</label>
        <input type="password" id="p1" name="password1" required minlength="6">
      </div>
      <div class="form-group">
        <label>Confirmar *</label>
        <input type="password" id="p2" name="password2" required>
        <p id="perr" style="color:#cc0000;font-size:12px;margin-top:4px;display:none">No coinciden.</p>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Cambiar contrasena</button>
        <a href="index.php?accion=alumnos" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>
<script>
function chk(){
    const ok=document.getElementById('p1').value===document.getElementById('p2').value;
    document.getElementById('perr').style.display=ok?'none':'block';
    return ok;
}
document.getElementById('p2').addEventListener('input',chk);
</script>
</body></html>
