<?php
// ajax/datos_graficas.php
session_start();
if (!isset($_SESSION['alumno'])) { http_response_code(401); echo json_encode(['error'=>'No autorizado']); exit; }
header('Content-Type: application/json; charset=utf-8');

require_once '../model/conexion.php';
try {
    $db = Conexion::conectar();

    // Libros por estado
    $rows = $db->query("SELECT estado, COUNT(*) AS total FROM biblioteca GROUP BY estado")->fetchAll(PDO::FETCH_ASSOC);
    $lLabels = array_column($rows,'estado');
    $lData   = array_map('intval', array_column($rows,'total'));

    // Alumnos por carrera
    $rows = $db->query("SELECT IFNULL(carrera,'Sin carrera') AS carrera, COUNT(*) AS total FROM alumnos GROUP BY carrera ORDER BY total DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);
    $aLabels = array_column($rows,'carrera');
    $aData   = array_map('intval', array_column($rows,'total'));

    echo json_encode(['libros'=>['labels'=>$lLabels,'data'=>$lData],
                      'alumnos'=>['labels'=>$aLabels,'data'=>$aData]]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error'=>'Error BD']);
}
