<?php
// ajax/ajax_alumnos.php — busca por ID o por nombre/apellido
session_start();
if (!isset($_SESSION['alumno'])) { http_response_code(401); echo json_encode(['error'=>'No autorizado']); exit; }
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');
if ($q === '') { echo json_encode(['error'=>'Ingresa un ID o nombre']); exit; }

require_once '../model/conexion.php';
try {
    $db = Conexion::conectar();
    if (ctype_digit($q)) {
        $stmt = $db->prepare("SELECT id_estudiante,nombre,apellidos,correo,IFNULL(carrera,'—') AS carrera FROM alumnos WHERE id_estudiante=:id LIMIT 1");
        $stmt->bindParam(':id', $q, PDO::PARAM_INT);
    } else {
        $like = '%'.$q.'%';
        $stmt = $db->prepare("SELECT id_estudiante,nombre,apellidos,correo,IFNULL(carrera,'—') AS carrera FROM alumnos WHERE nombre LIKE :q OR apellidos LIKE :q LIMIT 1");
        $stmt->bindParam(':q', $like, PDO::PARAM_STR);
    }
    $stmt->execute();
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        echo json_encode(['encontrado'=>true,'id_estudiante'=>$r['id_estudiante'],
            'nombre'=>$r['nombre'],'apellidos'=>$r['apellidos'],
            'correo'=>$r['correo'],'carrera'=>$r['carrera']]);
    } else {
        echo json_encode(['encontrado'=>false,'mensaje'=>'No se encontro ningun alumno.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Error de base de datos']);
}
