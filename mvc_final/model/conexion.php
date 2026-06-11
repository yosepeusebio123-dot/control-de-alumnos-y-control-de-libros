<?php
// model/conexion.php

class Conexion {
    public static function conectar() {
        $host = "localhost";
        $db   = "libro";
        $user = "root";
        $pass = ""; // Vacío por defecto en XAMPP

        try {
            $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
            $conexion = new PDO($dsn, $user, $pass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die("❌ Error en la conexión PDO: " . $e->getMessage());
        }
    }
}
