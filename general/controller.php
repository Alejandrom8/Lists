<?php
interface Render{
    public function render();
}
class Respuesta{
    public $estado;
    public $mensaje;
    public $respuesta;
    public $donde;
}
class Controller{

    public function __construct(){
        $this->view = new View();
    }
    
    public function loadModel($model){
        $url_model = 'structure/models/' . $model . 'Model.php';

        if(file_exists($url_model)){
          require_once($url_model);

          $modelName = $model . 'Model';
          $this->model = new $modelName();
        }
    }

    public function desinfect($data){
        /*  funcion para evaluar cada dato que entre al servidor
        *  y quitar caracteres especiales para más seguridad
        * @access public
        * @param String,int,boolean,etc. $data dato al que se le quitaran caractres especiales
        * @return $data dato sin caracteres especiales.
        */
        // $data = preg_replace('([^A-Za-z0-9._@-])', '', $data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function iniciarSesion($nombre, $id){
        session_regenerate_id();
        $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['nombre'] = $nombre;
        $_SESSION['idanfree'] = $id;
        return true;
    }
}
?>