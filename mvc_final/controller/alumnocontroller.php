<?php
require_once 'model/alumnomodel.php';

class alumnocontroller {
    private $modelo;
    public function __construct() { $this->modelo = new alumnomodel(); }

    public function listar() {
        $alumnos=$this->modelo->listarTodos();
        $mensaje=$_GET['msg']??''; $tipo_msg=$_GET['tipo']??'';
        require_once 'view/alumnos/lista_alumnos.php';
    }

    public function formularioCrear() {
        $accion='crear'; $alumno=null;
        $msg=$_GET['msg']??''; $tipo=$_GET['tipo']??'';
        require_once 'view/alumnos/form_alumno.php';
    }

    public function crear() {
        $id=(int)trim($_POST['id_estudiante']??0);
        $apellidos=trim($_POST['apellidos']??'');
        $nombre=trim($_POST['nombre']??'');
        $correo=trim($_POST['correo']??'');
        $password=trim($_POST['password']??'');
        $carrera=trim($_POST['carrera']??'');
        if(!$id||$apellidos===''||$nombre===''||$correo===''||$password===''){
            header('Location: index.php?accion=alumnos_crear&msg=Todos+los+campos+son+obligatorios&tipo=error'); exit;
        }
        if($this->modelo->crear($id,$apellidos,$nombre,$correo,$password,$carrera))
            header('Location: index.php?accion=alumnos&msg=Alumno+registrado+correctamente&tipo=ok');
        else
            header('Location: index.php?accion=alumnos_crear&msg=Error:+ese+ID+ya+existe&tipo=error');
        exit;
    }

    public function formularioEditar() {
        $id=(int)($_GET['id']??0);
        $alumno=$this->modelo->obtenerPorId($id);
        if(!$alumno){ header('Location: index.php?accion=alumnos&msg=No+encontrado&tipo=error'); exit; }
        $accion='editar'; $msg=$_GET['msg']??''; $tipo=$_GET['tipo']??'';
        require_once 'view/alumnos/form_alumno.php';
    }

    public function editar() {
        $id=(int)trim($_POST['id_estudiante']??0);
        $apellidos=trim($_POST['apellidos']??'');
        $nombre=trim($_POST['nombre']??'');
        $correo=trim($_POST['correo']??'');
        $carrera=trim($_POST['carrera']??'');
        if($this->modelo->actualizar($id,$apellidos,$nombre,$correo,$carrera))
            header('Location: index.php?accion=alumnos&msg=Alumno+actualizado&tipo=ok');
        else
            header("Location: index.php?accion=alumnos_editar&id=$id&msg=Error&tipo=error");
        exit;
    }

    public function formularioPwd() {
        $id=(int)($_GET['id']??0);
        $alumno=$this->modelo->obtenerPorId($id);
        if(!$alumno){ header('Location: index.php?accion=alumnos&msg=No+encontrado&tipo=error'); exit; }
        $msg=$_GET['msg']??''; $tipo=$_GET['tipo']??'';
        require_once 'view/alumnos/form_password.php';
    }

    public function cambiarPassword() {
        $id=(int)trim($_POST['id_estudiante']??0);
        $pwd1=trim($_POST['password1']??'');
        $pwd2=trim($_POST['password2']??'');
        if($pwd1===''||$pwd1!==$pwd2){
            header("Location: index.php?accion=alumnos_pwd&id=$id&msg=Las+contrasenas+no+coinciden&tipo=error"); exit;
        }
        if(strlen($pwd1)<6){
            header("Location: index.php?accion=alumnos_pwd&id=$id&msg=Minimo+6+caracteres&tipo=error"); exit;
        }
        if($this->modelo->cambiarPassword($id,$pwd1))
            header('Location: index.php?accion=alumnos&msg=Contrasena+actualizada&tipo=ok');
        else
            header("Location: index.php?accion=alumnos_pwd&id=$id&msg=Error&tipo=error");
        exit;
    }

    // Desactivar (eliminacion logica)
    public function desactivar() {
        $id=(int)($_GET['id']??0);
        if($this->modelo->toggleActivo($id,0))
            header('Location: index.php?accion=alumnos&msg=Alumno+desactivado&tipo=ok');
        else
            header('Location: index.php?accion=alumnos&msg=Error&tipo=error');
        exit;
    }

    // Reactivar
    public function activar() {
        $id=(int)($_GET['id']??0);
        if($this->modelo->toggleActivo($id,1))
            header('Location: index.php?accion=alumnos&msg=Alumno+activado&tipo=ok');
        else
            header('Location: index.php?accion=alumnos&msg=Error&tipo=error');
        exit;
    }
}
// NOTE: Role protection is handled in index.php
