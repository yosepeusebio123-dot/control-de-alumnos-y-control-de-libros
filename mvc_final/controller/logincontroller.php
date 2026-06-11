<?php
// controller/logincontroller.php — con separación admin/alumno
require_once 'model/loginmodel.php';

class logincontroller {
    private $modelo;

    public function __construct() {
        $this->modelo = new loginmodel();
    }

    public function iniciar() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id       = intval(trim($_POST['id_estudiante'] ?? 0));
            $password = trim($_POST['password'] ?? '');

            $alumno = $this->modelo->autenticar($id, $password);

            if ($alumno) {
                session_regenerate_id(true);
                $_SESSION['alumno'] = [
                    'id_estudiante' => $alumno['id_estudiante'],
                    'nombre'        => $alumno['nombre'],
                    'apellidos'     => $alumno['apellidos'],
                    'correo'        => $alumno['correo'],
                    'rol'           => $alumno['rol'],
                ];
                header('Location: index.php?accion=panel');
                exit;
            } else {
                $error = 'ID o contraseña incorrectos.';
            }
        }

        require_once 'view/login_view.php';
    }

    public function panel() {
        if (!isset($_SESSION['alumno'])) {
            header('Location: index.php'); exit;
        }
        $alumno = $_SESSION['alumno'];
        $rol    = $alumno['rol'] ?? 'alumno';

        if ($rol === 'admin') {
            require_once 'view/panel_admin.php';
        } else {
            require_once 'view/panel_alumno.php';
        }
    }

    public function cerrarSesion() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
