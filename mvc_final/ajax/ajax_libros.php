<?php
// ajax/ajax_libros.php
session_start();
if (!isset($_SESSION['alumno'])) { http_response_code(401); echo json_encode(['error'=>'No autorizado']); exit; }
header('Content-Type: application/json; charset=utf-8');

$titulo = trim($_GET['titulo'] ?? '');
if ($titulo === '') { echo json_encode(['error'=>'Ingresa un titulo']); exit; }

require_once '../model/libromodel.php';
$modelo = new libromodel();
$r = $modelo->buscarportitulo($titulo);

if ($r) {
    echo json_encode(['encontrado'=>true,'titulo'=>$r['titulo'],'autor'=>$r['autor'],'estado'=>$r['estado']]);
} else {
    echo json_encode(['encontrado'=>false,'mensaje'=>'No se encontro ningun libro con ese titulo.']);
}
