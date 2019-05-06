<?php 
class Login extends Controller implements Render{

    public function __construct(){
        parent::__construct();
    }

    public function render(){
        $this->view->render('utopia/login');
    }

    public function logear(){
        $nombre_correo = $this->desinfect($_POST['nombre-correo']);
        $pass = hash("sha512", $this->desinfect($_POST['pass']));
        $status = new Respuesta();

        $validarNC = $this->model->validarNC($nombre_correo, $pass);
        $estado = $validarNC[0];
        $mensaje = $validarNC[1];

        if($estado){
            $respuesta = $validarNC[2];
                $nombre = $respuesta[0];
                $id = $respuesta[1];
            $status->estado = true;
            $status->mensaje = "Bienvenido";
            $status->donde = constant("URL") . "home/getUserData";
            $this->iniciarSesion($nombre, $id);
        }else{
            $status->estado = false;
            $status->mensaje = $mensaje;
        }

        echo json_encode($status);
    }
}

?>