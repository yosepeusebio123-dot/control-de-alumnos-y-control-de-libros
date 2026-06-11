<?php
// model/libromodel.php — con eliminacion logica (activo/inactivo)
require_once 'conexion.php';

class libromodel {
    private $db;
    public function __construct() { $this->db = Conexion::conectar(); }

    // Solo lista activos
    public function listarTodos() {
        return $this->db->query(
            "SELECT id, titulo, autor, estado, activo
             FROM biblioteca ORDER BY titulo ASC"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $s = $this->db->prepare("SELECT * FROM biblioteca WHERE id=:id");
        $s->bindParam(':id',$id,PDO::PARAM_INT); $s->execute();
        return $s->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarportitulo($titulo) {
        $b = strtolower(trim($titulo));
        $s = $this->db->prepare(
            "SELECT titulo, autor, estado FROM biblioteca
             WHERE titulo_busqueda=:b AND activo=1"
        );
        $s->bindParam(':b',$b,PDO::PARAM_STR); $s->execute();
        $r=$s->fetch(PDO::FETCH_ASSOC); $s->closeCursor(); return $r;
    }

    public function crear($titulo,$autor,$estado) {
        $tb=strtolower(trim($titulo));
        $s=$this->db->prepare(
            "INSERT INTO biblioteca (titulo_busqueda,titulo,autor,estado,activo)
             VALUES (:tb,:titulo,:autor,:estado,1)"
        );
        $s->bindParam(':tb',$tb,PDO::PARAM_STR);
        $s->bindParam(':titulo',$titulo,PDO::PARAM_STR);
        $s->bindParam(':autor',$autor,PDO::PARAM_STR);
        $s->bindParam(':estado',$estado,PDO::PARAM_STR);
        return $s->execute();
    }

    public function actualizar($id,$titulo,$autor,$estado) {
        $tb=strtolower(trim($titulo));
        $s=$this->db->prepare(
            "UPDATE biblioteca
             SET titulo_busqueda=:tb,titulo=:titulo,autor=:autor,estado=:estado
             WHERE id=:id"
        );
        $s->bindParam(':tb',$tb,PDO::PARAM_STR);
        $s->bindParam(':titulo',$titulo,PDO::PARAM_STR);
        $s->bindParam(':autor',$autor,PDO::PARAM_STR);
        $s->bindParam(':estado',$estado,PDO::PARAM_STR);
        $s->bindParam(':id',$id,PDO::PARAM_INT);
        return $s->execute();
    }

    // Eliminacion logica: cambia activo entre 1 y 0
    public function toggleActivo($id, $activo) {
        $s=$this->db->prepare("UPDATE biblioteca SET activo=:a WHERE id=:id");
        $s->bindParam(':a',$activo,PDO::PARAM_INT);
        $s->bindParam(':id',$id,PDO::PARAM_INT);
        return $s->execute();
    }
}
