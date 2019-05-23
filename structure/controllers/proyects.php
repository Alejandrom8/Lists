<?php 
include_once("../models/modelResponse.php");

class Proyects extends Controller{

    public function __constructor (){
        parent::__constructor();
        $this->view->Proyects = [];
        $this->view->ProyectCreated = [];
    }

    public function render($where = 'proyects/index'){
        $proyectos = $this->model->getAllProyects();
        $this->view->Proyects = $proyectos->data;
        $this->view->render($where);
    }

    public function getProyectId(){
        $num1 = rand(0,9);
        $num2 = rand(0,9);
        $num3 = rand(0,9);
        $num4 = rand(0,9);

        return $num1 . $num2 . $num3 . $num4;
    }

    public function getProyectPrioriProperties(){
        $consult = $this->model->getProperties();
        echo json_encode($consult);
    }

    public function getProyectById($id){
        $pt = $id[0];
        $res = new ServiceResult();

        $consulta = $this->model->getProyect($pt);

        if($consulta->success){
            $res->success = true;
            $res->data = $consulta->data;
            $res->message= "exito!";
        }else{
            $res->success = false;
            $res->errors = $consulta->errors;
            $res->message = "El proyecto que busca no existe o tiene una id erronea";
        }
        $this->view->ProyectCreated = $res;
        $this->render();
    }

    // public function new_proyect(){
    //     $proyecto = new Proyecto();

    //     $proyecto->owner         = $_SESSION['idanfree'];
    //     $proyecto->name          = $nombre        = $this->desinfect($_GET['NombreDelProyecto']);
    //     $proyecto->proyectID     = $proyectID     = $_SESSION['idanfree'] . '-p-' . $this->getProyectId();
    //     $proyecto->description   = $descripcion   = $this->desinfect($_GET['description']);
    //     $proyecto->start         = $fechaDeInicio = $this->desinfect($_GET['fecha-desde']);
    //     $proyecto->end           = $fechaDeFin    = $this->desinfect($_GET['fecha-hasta']);
    //     $proyecto->color         = $color         = $this->desinfect($_GET['color']);
    //     $proyecto->creationDate  = $currentDate   = strftime("%y-%m-%d %H:%M");

    //     $res = new ServiceResult();
    //     $save = $this->model->saveProyect($proyecto);

    //     if($save->success){
    //         $res->success = true;
    //         $res->onSuccessEvent = constant('URL') . 'proyects/renderProyects/' . $proyecto->proyectID;
    //     }else{
    //         $res->success = false;
    //         if($success->errors == 1){
    //             $res->message = "Ya tienes demasiados proyectos (50)";
    //         }else{
    //             $res->errors = $save->errors;
    //         }
    //     }

    //     echo json_encode($res);

    // }
}
?>