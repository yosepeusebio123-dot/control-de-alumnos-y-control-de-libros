<?php session_start(); if(!isset($_SESSION['alumno'])||($_SESSION['alumno']['rol']??'')!=='admin'){header('Location: index.php?accion=panel');exit;} ?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8">
<title><?php echo $accion==='crear'?'Nuevo Alumno':'Editar Alumno'; ?> — SENATI</title>
<link rel="stylesheet" href="view/crud_style.css"></head>
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
  <div class="card" style="max-width:600px;margin:0 auto">
    <div class="card-header">
      <h2><?php echo $accion==='crear'?'Registrar nuevo alumno':'Editar alumno'; ?></h2>
    </div>
    <?php if($msg): ?>
      <div class="alerta alerta-<?php echo $tipo==='ok'?'ok':'error'; ?>"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?accion=<?php echo $accion==='crear'?'alumnos_guardar':'alumnos_actualizar'; ?>">

      <div class="form-row">
        <div class="form-group">
          <label>ID Estudiante *</label>
          <input type="number" name="id_estudiante" required
                 <?php echo $accion==='editar'?'readonly style="background:#f4f4f4"':''; ?>
                 value="<?php echo htmlspecialchars($alumno['id_estudiante']??''); ?>"
                 placeholder="Ej: 1675700">
        </div>
        <div class="form-group">
          <label>Carrera</label>
          <select name="carrera">
            <?php
            $carreras=['Computacion e Informatica','Administracion de Empresas',
                       'Contabilidad','Mecanica Automotriz','Electricidad Industrial',
                       'Electronica Industrial','Ingeniería de Software con IA','Sin carrera'];
            $ca=$alumno['carrera']??'';
            foreach($carreras as $c):
            ?>
            <option value="<?php echo $c; ?>" <?php echo $ca===$c?'selected':''; ?>><?php echo $c; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Apellidos *</label>
        <input type="text" name="apellidos" required maxlength="100"
               value="<?php echo htmlspecialchars($alumno['apellidos']??''); ?>"
               placeholder="Ej: GOMEZ MEZA">
      </div>
      <div class="form-group">
        <label>Nombre *</label>
        <input type="text" name="nombre" required maxlength="100"
               value="<?php echo htmlspecialchars($alumno['nombre']??''); ?>"
               placeholder="Ej: LINCOL JARLY">
      </div>
      <div class="form-group">
        <label>Correo *</label>
        <input type="email" name="correo" required maxlength="100"
               value="<?php echo htmlspecialchars($alumno['correo']??''); ?>"
               placeholder="Ej: 1675700@senati.pe">
      </div>

      <?php if($accion==='crear'): ?>
      <div class="form-group">
        <label>Contrasena * (min. 6 caracteres)</label>
        <input type="password" name="password" required minlength="6">
      </div>
      <?php else: ?>
        <p style="font-size:12px;color:#888;margin-bottom:14px">
          Para cambiar contrasena usa el boton "Password" en la lista.
        </p>
      <?php endif; ?>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <?php echo $accion==='crear'?'Registrar alumno':'Guardar cambios'; ?>
        </button>
        <a href="index.php?accion=alumnos" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>



</body></html>
