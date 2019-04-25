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
        $pass = $this->desinfect($_POST['pass']);
        $status = new Respuesta();

        $validar = $this->model->validar($nombre_correo, $pass);
        $estado = $validar[0];
        $mensaje = $validar[1];
        if($estado){
            $status->estado = true;
            $status->mensaje = "Bienvenido";
            $status->donde = constant('URL') . "home";
        }else{
            $status->estado = false;
            $status->mensaje = $pass;
        }
        echo json_encode($status);
    }
}

?>