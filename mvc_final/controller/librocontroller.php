<?php
require_once 'model/libromodel.php';

class librocontroller {
    private $modelo;
    public function __construct() { $this->modelo = new libromodel(); }

    public function listar() {
        $libros=$this->modelo->listarTodos();
        $mensaje=$_GET['msg']??''; $tipo_msg=$_GET['tipo']??'';
        require_once 'view/libros/lista_libros.php';
    }

    public function formularioCrear() {
        $accion='crear'; $libro=null;
        $msg=$_GET['msg']??''; $tipo=$_GET['tipo']??'';
        require_once 'view/libros/form_libro.php';
    }

    public function crear() {
        $titulo=trim($_POST['titulo']??'');
        $autor=trim($_POST['autor']??'');
        $estado=trim($_POST['estado']??'Disponible');
        if($titulo===''||$autor===''){
            header('Location: index.php?accion=libros_crear&msg=Titulo+y+autor+obligatorios&tipo=error'); exit;
        }
        if($this->modelo->crear($titulo,$autor,$estado))
            header('Location: index.php?accion=libros&msg=Libro+registrado+correctamente&tipo=ok');
        else
            header('Location: index.php?accion=libros_crear&msg=Error+al+registrar&tipo=error');
        exit;
    }

    public function formularioEditar() {
        $id=(int)($_GET['id']??0);
        $libro=$this->modelo->obtenerPorId($id);
        if(!$libro){ header('Location: index.php?accion=libros&msg=No+encontrado&tipo=error'); exit; }
        $accion='editar'; $msg=$_GET['msg']??''; $tipo=$_GET['tipo']??'';
        require_once 'view/libros/form_libro.php';
    }

    public function editar() {
        $id=(int)($_POST['id']??0);
        $titulo=trim($_POST['titulo']??'');
        $autor=trim($_POST['autor']??'');
        $estado=trim($_POST['estado']??'Disponible');
        if($titulo===''||$autor===''){
            header("Location: index.php?accion=libros_editar&id=$id&msg=Campos+obligatorios&tipo=error"); exit;
        }
        if($this->modelo->actualizar($id,$titulo,$autor,$estado))
            header('Location: index.php?accion=libros&msg=Libro+actualizado&tipo=ok');
        else
            header("Location: index.php?accion=libros_editar&id=$id&msg=Error&tipo=error");
        exit;
    }

    // Desactivar (eliminacion logica)
    public function desactivar() {
        $id=(int)($_GET['id']??0);
        if($this->modelo->toggleActivo($id,0))
            header('Location: index.php?accion=libros&msg=Libro+desactivado&tipo=ok');
        else
            header('Location: index.php?accion=libros&msg=Error&tipo=error');
        exit;
    }

    // Reactivar
    public function activar() {
        $id=(int)($_GET['id']??0);
        if($this->modelo->toggleActivo($id,1))
            header('Location: index.php?accion=libros&msg=Libro+activado&tipo=ok');
        else
            header('Location: index.php?accion=libros&msg=Error&tipo=error');
        exit;
    }
}
