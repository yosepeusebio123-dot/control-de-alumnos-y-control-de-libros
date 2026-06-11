<?php
// model/loginmodel.php

require_once 'conexion.php';

class loginmodel {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    /**
     * Autentica a un alumno por ID y contraseña.
     * Devuelve un arreglo con los datos del alumno (sin password) si es correcto,
     * o FALSE si las credenciales no son válidas.
     */
    public function autenticar($id, $password) {
        $id = intval(trim($id));
        $password = trim($password);

        try {
            $sql = "SELECT id_estudiante, apellidos, nombre, correo, password,rol
                    FROM alumnos
                    WHERE id_estudiante = :id LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $alumno = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            // Verificar que el alumno exista y que el hash coincida
            if ($alumno && password_verify($password, $alumno['password'])) {
                // Por seguridad, removemos el hash antes de devolver los datos
                unset($alumno['password']);
                return $alumno;
            }
            return false;

        } catch (PDOException $e) {
            die("Error en la autenticación: " . $e->getMessage());
        }
    }
}
