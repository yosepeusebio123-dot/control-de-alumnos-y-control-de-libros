<?php
// model/alumnomodel.php — con eliminacion logica (activo/inactivo)
require_once 'conexion.php';

class alumnomodel {
    private $db;
    public function __construct() { $this->db = Conexion::conectar(); }

    public function listarTodos() {
        return $this->db->query(
            "SELECT id_estudiante, apellidos, nombre, correo,
                    IFNULL(carrera,'—') AS carrera, activo
             FROM alumnos ORDER BY apellidos ASC"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $s=$this->db->prepare(
            "SELECT id_estudiante,apellidos,nombre,correo,
                    IFNULL(carrera,'') AS carrera, activo
             FROM alumnos WHERE id_estudiante=:id"
        );
        $s->bindParam(':id',$id,PDO::PARAM_INT); $s->execute();
        return $s->fetch(PDO::FETCH_ASSOC);
    }

    public function buscar($q) {
        if(ctype_digit(trim($q))){
            $s=$this->db->prepare(
                "SELECT id_estudiante,nombre,apellidos,correo,
                        IFNULL(carrera,'—') AS carrera
                 FROM alumnos WHERE id_estudiante=:id AND activo=1 LIMIT 1"
            );
            $s->bindParam(':id',$q,PDO::PARAM_INT);
        } else {
            $like='%'.trim($q).'%';
            $s=$this->db->prepare(
                "SELECT id_estudiante,nombre,apellidos,correo,
                        IFNULL(carrera,'—') AS carrera
                 FROM alumnos WHERE (nombre LIKE :q OR apellidos LIKE :q)
                 AND activo=1 LIMIT 1"
            );
            $s->bindParam(':q',$like,PDO::PARAM_STR);
        }
        $s->execute(); return $s->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($id,$apellidos,$nombre,$correo,$password,$carrera) {
        $hash=password_hash($password,PASSWORD_BCRYPT);
        $s=$this->db->prepare(
            "INSERT INTO alumnos (id_estudiante,apellidos,nombre,correo,password,carrera,activo)
             VALUES (:id,:ap,:nom,:cor,:pwd,:car,1)"
        );
        $s->bindParam(':id',$id,PDO::PARAM_INT);
        $s->bindParam(':ap',$apellidos,PDO::PARAM_STR);
        $s->bindParam(':nom',$nombre,PDO::PARAM_STR);
        $s->bindParam(':cor',$correo,PDO::PARAM_STR);
        $s->bindParam(':pwd',$hash,PDO::PARAM_STR);
        $s->bindParam(':car',$carrera,PDO::PARAM_STR);
        return $s->execute();
    }

    public function actualizar($id,$apellidos,$nombre,$correo,$carrera) {
        $s=$this->db->prepare(
            "UPDATE alumnos
             SET apellidos=:ap,nombre=:nom,correo=:cor,carrera=:car
             WHERE id_estudiante=:id"
        );
        $s->bindParam(':ap',$apellidos,PDO::PARAM_STR);
        $s->bindParam(':nom',$nombre,PDO::PARAM_STR);
        $s->bindParam(':cor',$correo,PDO::PARAM_STR);
        $s->bindParam(':car',$carrera,PDO::PARAM_STR);
        $s->bindParam(':id',$id,PDO::PARAM_INT);
        return $s->execute();
    }

    public function cambiarPassword($id,$nueva) {
        $hash=password_hash($nueva,PASSWORD_BCRYPT);
        $s=$this->db->prepare("UPDATE alumnos SET password=:pwd WHERE id_estudiante=:id");
        $s->bindParam(':pwd',$hash,PDO::PARAM_STR);
        $s->bindParam(':id',$id,PDO::PARAM_INT);
        return $s->execute();
    }

    // Eliminacion logica: cambia activo entre 1 y 0
    public function toggleActivo($id, $activo) {
        $s=$this->db->prepare("UPDATE alumnos SET activo=:a WHERE id_estudiante=:id");
        $s->bindParam(':a',$activo,PDO::PARAM_INT);
        $s->bindParam(':id',$id,PDO::PARAM_INT);
        return $s->execute();
    }
}
