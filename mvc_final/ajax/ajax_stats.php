<?php
// ajax/ajax_stats.php — estadísticas de alumnos para el panel admin
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['alumno']) || ($_SESSION['alumno']['rol'] ?? '') !== 'admin') {
    echo json_encode(['error' => 'No autorizado']); exit;
}

require_once '../model/conexion.php';
try {
    $db = Conexion::conectar();
    $activos   = $db->query("SELECT COUNT(*) FROM alumnos WHERE activo=1")->fetchColumn();
    $inactivos = $db->query("SELECT COUNT(*) FROM alumnos WHERE activo=0")->fetchColumn();
    echo json_encode(['activos' => (int)$activos, 'inactivos' => (int)$inactivos]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
