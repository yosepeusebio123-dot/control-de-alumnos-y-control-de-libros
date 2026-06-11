<?php session_start(); if(!isset($_SESSION['alumno'])||($_SESSION['alumno']['rol']??'')!=='admin'){header('Location: index.php?accion=panel');exit;} ?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8">
<title><?php echo $accion==='crear'?'Nuevo Libro':'Editar Libro'; ?> — SENATI</title>
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
  <div class="card" style="max-width:520px;margin:0 auto">
    <div class="card-header">
      <h2><?php echo $accion==='crear'?'Registrar nuevo libro':'Editar libro'; ?></h2>
    </div>
    <?php if($msg): ?>
      <div class="alerta alerta-<?php echo $tipo==='ok'?'ok':'error'; ?>"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?accion=<?php echo $accion==='crear'?'libros_guardar':'libros_actualizar'; ?>">
      <?php if($accion==='editar'): ?>
        <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
      <?php endif; ?>
      <div class="form-group">
        <label>Titulo *</label>
        <input type="text" name="titulo" required maxlength="100"
               value="<?php echo htmlspecialchars($libro['titulo']??''); ?>"
               placeholder="Ej: Don Quijote">
      </div>
      <div class="form-group">
        <label>Autor *</label>
        <input type="text" name="autor" required maxlength="100"
               value="<?php echo htmlspecialchars($libro['autor']??''); ?>"
               placeholder="Ej: Miguel de Cervantes">
      </div>
      <div class="form-group">
        <label>Estado</label>
        <select name="estado">
          <option value="Disponible" <?php echo (!isset($libro)||$libro['estado']==='Disponible')?'selected':''; ?>>Disponible</option>
          <option value="Prestado"   <?php echo (isset($libro)&&$libro['estado']==='Prestado')?'selected':''; ?>>Prestado</option>
        </select>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <?php echo $accion==='crear'?'Registrar libro':'Guardar cambios'; ?>
        </button>
        <a href="index.php?accion=libros" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>
</body></html>
