<?php 

include_once("../models/modelResponse.php");

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
        $headers = get_headers($url);
        return stripos($headers[0],"200 OK");
    }

    public function getRelationDataFirst () {
        
        $respuesta = new ServiceResult();
        $first = $this->model->getFirstRelation($this->user);
        $respuesta->success = $first->success;
        $respuesta->errors  = $first->errors;
        $respuesta->data    = $first->data;

        if($respuesta->success){
            echo $respuesta->data;
        }else{
            echo $respuesta->errors;
        }
    }

    public function getUserRelationData(){

        $respuesta = new ServiceResult();

        $relaciones_consult = $this->model->getAllRelations(
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
                            $foto->data != 'null' ? constant("URL_FOTOS") . $foto->data : constant("DEFAULT_FOTO");
                            
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
            echo json_encode($getmensajes->data);
        }

    }

    public function search(){
        if(!empty($_GET)){
            $searched = $this->desinfect($_GET['search']);
            $counted = explode(" ", trim($searched));
            $sendSearch = $this->model->searchWords($searched, count($counted));

            $res = new ServiceResult();
            $s = $res->success = $sendSearch->success;
            $e = $res->errors  = $sendSearch->errors;
            $d = $sendSearch->data;

            if($s){
                if($d != null and count($d) > 0){
                    $res->data = $d;
                }else{
                    $res->message = "No hay resultados que coincidan con la busqueda";
                }
            }

            echo json_encode($res);
        }
    }

    public function registRelation(){
        $id = $this->desinfect($_POST['id']);
        $this->model->createRelation($id);
    }

    public function registPetition(){

        $res = new ServiceResult();

        $id = $this->desinfect($_POST['id']);
        $fecha = strftime("%y-%m-%d %H:%M");
        $r = $this->model->createPetitionRelation($id, $fecha);

        if($r->success){
            $res->success = true;
            $res->errors = 0;
        }else{
           $res->success = false;
           $res->errors = 0;

           switch($r->errors){
               case 1: 
                    $res->message = ["title" => "Ya se lo pediste", "text" => "Ya se ha enviado previamente una solicitud a "];
                    $res->onErrorEvent = "warning";
                    break;
                case 2: 
                    $res->message = ["title" => "Error", "text" => "No logro enviarse la solicitud a "];
                    $res->onErrorEvent = "error";
                    break;
                case 3:
                    $res->message = ["title" => "Wow", "text" => "Ya tienes una solicitud en la seccion de notificaciónes de "];
                    $res->onErrorEvent = "info";
                    break;
                case 4:
                    $res->message = ["title" => "Wow", "text" => "Ya eres amig@ de "];
                    $res->onErrorEvent = "info";
                    break;
                default:
                    $res->errors = 1;
                    $res->message = $r->errors;
                    break;
           }
        }

        echo json_encode($res);
    }

    public function getpetitions(){
        echo json_encode($this->model->getPetitions());
    }

    public function aceptPetition(){
        $id = $this->desinfect($_POST['id']);
        $res = $this->model->aceptPetition($id);
        echo json_encode($res);
    }

    public function deletePetition(){
        $id = $this->desinfect($_POST['id']);
        $res = $this->model->deletePetition($id);
        echo json_encode($res);
    }

    public function getNotifications(){
        $noti = $this->model->getNotificationsData();
        if($noti->success){
            $display = "";
            foreach($noti->data as $notifi){
                $display .= "<li class='list-group-item'>
                                <h5>$notifi->asunto</h5>
                                <p>$notifi->mensaje<p>
                                <p>$notifi->fecha</p>
                            </li>";
            }
            echo $display;
        }else{ 
            echo $noti->errors;
        }
    }

    public function getProyects(){
        $data = $this->model->getProyectsModel();
        echo json_encode($data);
    }

    public function getProyectId(){
        $num1 = rand(0,9);
        $num2 = rand(0,9);
        $num3 = rand(0,9);
        $num4 = rand(0,9);

        return $num1 . $num2 . $num3 . $num4;
    }
    
    public function new_proyect(){
        $proyecto = new Proyecto();

        $proyecto->owner         = $_SESSION['idanfree'];
        $proyecto->name          = $this->desinfect($_POST['NombreDelProyecto']);
        $proyecto->proyectID     = $_SESSION['idanfree'] . '-p-' . $this->getProyectId();
        $proyecto->description   = $this->desinfect($_POST['description']);
        $proyecto->start         = $this->desinfect($_POST['fecha-desde']);
        $proyecto->end           = $this->desinfect($_POST['fecha-hasta']);
        $proyecto->color         = $this->desinfect($_POST['color']);
        $proyecto->creationDate  = strftime("%y-%m-%d %H:%M");
        $proyecto->completed = 0;

        $res = new ServiceResult();

        $save = $this->model->saveProyect($proyecto);

        if($save->success){
            $res->success = true;
            $res->onSuccessEvent = constant('URL') . 'proyects/getProyectById/' . $proyecto->proyectID;
        }else{
            $res->success = false;
            if($success->errors == 1){
                $res->message = "Ya tienes demasiados proyectos (50)";
            }else{
                $res->errors = $save->errors;
            }
        }

        echo json_encode($res);

    }
}

?>