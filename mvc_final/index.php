<?php
// index.php — Enrutador principal con protección de roles
session_start();

require_once 'controller/logincontroller.php';
require_once 'controller/alumnocontroller.php';
require_once 'controller/librocontroller.php';

$accion = $_GET['accion'] ?? 'login';

// Rutas públicas
if ($accion === 'login') {
    $app = new logincontroller(); $app->iniciar(); exit;
}

// Verificar sesión
if (!isset($_SESSION['alumno'])) {
    header('Location: index.php'); exit;
}

$rol = $_SESSION['alumno']['rol'] ?? 'alumno';

// Rutas SOLO ADMIN
$rutas_admin = [
    'alumnos','alumnos_crear','alumnos_guardar','alumnos_editar',
    'alumnos_actualizar','alumnos_pwd','alumnos_cambiar_pwd',
    'alumnos_desactivar','alumnos_activar',
    'libros','libros_crear','libros_guardar','libros_editar',
    'libros_actualizar','libros_desactivar','libros_activar',
];

if (in_array($accion, $rutas_admin) && $rol !== 'admin') {
    // Alumno intentando acceder a ruta de admin → redirigir a su panel
    header('Location: index.php?accion=panel&msg=acceso_denegado'); exit;
}

switch ($accion) {
    case 'panel':   $app=new logincontroller();  $app->panel();         break;
    case 'logout':  $app=new logincontroller();  $app->cerrarSesion();  break;

    // LIBROS (solo admin)
    case 'libros':             $app=new librocontroller(); $app->listar();           break;
    case 'libros_crear':       $app=new librocontroller(); $app->formularioCrear();  break;
    case 'libros_guardar':     $app=new librocontroller(); $app->crear();            break;
    case 'libros_editar':      $app=new librocontroller(); $app->formularioEditar(); break;
    case 'libros_actualizar':  $app=new librocontroller(); $app->editar();           break;
    case 'libros_desactivar':  $app=new librocontroller(); $app->desactivar();       break;
    case 'libros_activar':     $app=new librocontroller(); $app->activar();          break;

    // ALUMNOS (solo admin)
    case 'alumnos':             $app=new alumnocontroller(); $app->listar();           break;
    case 'alumnos_crear':       $app=new alumnocontroller(); $app->formularioCrear();  break;
    case 'alumnos_guardar':     $app=new alumnocontroller(); $app->crear();            break;
    case 'alumnos_editar':      $app=new alumnocontroller(); $app->formularioEditar(); break;
    case 'alumnos_actualizar':  $app=new alumnocontroller(); $app->editar();           break;
    case 'alumnos_pwd':         $app=new alumnocontroller(); $app->formularioPwd();    break;
    case 'alumnos_cambiar_pwd': $app=new alumnocontroller(); $app->cambiarPassword();  break;
    case 'alumnos_desactivar':  $app=new alumnocontroller(); $app->desactivar();       break;
    case 'alumnos_activar':     $app=new alumnocontroller(); $app->activar();          break;

    default: $app=new logincontroller(); $app->panel(); break;
}
