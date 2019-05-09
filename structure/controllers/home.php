<?php 

include_once("../models/modelResponse.php");

class amigo{
    public $id;
    public $nombre;
    public $foto;
    public $mensajes;
}

class Home extends controller implements Render{

    protected $user;

    public function __construct(){
        parent::__construct();
        $this->user = $_SESSION['idanfree'];
    }

    public function render(){
        $this->view->render('home/index');
    }
    public function social(){
        $this->view->render("home/social");
    }

    public function getUserData(){

        $respuesta = new ServiceResult();

        $foto_usuario = $this->model->getOneData(
                "foto_nombre",
                constant("TABLA_REGISTRO"),
                "idanfree",
                $this->user
        );

        $respuesta->success = $foto_usuario->success;
        $respuesta->errors  = $foto_usuario->errors;
        $respuesta->data    = $foto_usuario->data;

        $user_foto_url = constant("DEFAULT_FOTO");

        if($respuesta->success){
            if($respuesta->data != null){
                $user_foto_url = constant("LOCAL") . "intranet/uploads/" . $respuesta->data;
                if(!$this->UR_exists($user_foto_url)){
                    $user_foto_url = constant("DEFAULT_FOTO");
                }
            }
        }

        $_SESSION['user_foto'] = $user_foto_url;
        header("Location: " . constant("URL") . "home");
    }

    private static function UR_exists($url){
        $headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;
    }

    public function getUserRelationData(){

        $respuesta = new ServiceResult();

        $relaciones_consult = $this->model->getAllData(
            "relacion",
            "relaciones",
            "idanfree",
            $this->user
        );

        $respuesta->success = $relaciones_consult->success;
        $respuesta->errors  = $relaciones_consult->errors;
        $respuesta->data    = $relaciones_consult->data;

        $ajaxResponse = new ServiceResult();

        if($respuesta->success){
            if($respuesta->data != null){

                $amigos = [];
                $errores = [];

                if(count($respuesta->data) > 0){
                    
                    foreach($respuesta->data as $amigo_id){
                        
                        $friendObj = new amigo();
                        $friendObj->id = $amigo_id;

                        $foto = $this->model->getOneData(
                            "foto_nombre",
                            constant("TABLA_REGISTRO"),
                            "idanfree",
                            $amigo_id
                        );

                        $nombre = $this->model->getOneData(
                            "nombre",
                            constant("TABLA_REGISTRO"),
                            "idanfree",
                            $amigo_id
                        );

                        if($foto->errors != 0){
                            array_push($errores, $foto->errors);
                        }
                        if($nombre->errors != 0){
                            array_push($errores, $nombre->errors);
                        }

                        $friendObj->nombre  = $nombre->data;
                        $friendObj->foto    = 
                            $foto->data != null && 
                            $foto->data != "" && 
                            $foto->data != 'null' ? $foto->data : "porfile-default.png";
                            
                        array_push($amigos, $friendObj);
                    }
                }

                $ajaxResponse->success = true;
                $ajaxResponse->errors  = $errores;
                $ajaxResponse->data    = $amigos;

            }

        }else{
            $ajaxResponse->success = false;
            $ajaxResponse->errors  = $respuesta->errors;
            $ajaxResponse->data    = null;
            $ajaxResponse->message = "No se lograron obtener los datos de tus amigos";
        }

        echo json_encode($ajaxResponse);
    }

    public function registMessage(){
        $friend = $this->desinfect($_POST['amigo']);
        $mensaje = $this->desinfect($_POST['message']);
        if($mensaje != "" and $mensaje != null){
            $date  = strftime("%y-%m-%d %H:%M");
            $regist = $this->model->registMessage(
                $this->user,
                $friend,
                $mensaje,
                $date
            );
        }
    }

    public function getUserRelationMessage(){

        $amigo = $this->desinfect($_POST['amigo']);
        
        $getmensajes = $this->model->getMensajes($amigo);

        if($getmensajes->success){
            if($getmensajes->data != null){
                echo json_encode($getmensajes->data);
            }
        }

    }
}

?>