<?php 
class ServiceResult {
    public $success;
    public $errors;
    public $messages;
    public $data;
    public $onSuccessEvent;
    public $onErrorEvent; 
} 

class Mensaje{
    public $emisor;
    public $receptor;
    public $mensaje;
    public $fecha;
}

class amigo{
    public $id;
    public $nombre;
    public $correo;
    public $apodo;
    public $foto;
    public $mensajes;
    public $fecha;
    public $relacion;
}

class notificacion{
    public $asunto;
    public $mensaje;
    public $fecha;
}

class Proyecto{

    public $owner;
    public $name;
    public $proyectID;
    public $description;
    public $creationDate;
    public $start;
    public $end;
    public $completed;
    public $color;
    public $tasks;
    public $targets;

    // public function __construct(){

    //     $this->owner = null;
    //     $this->name    = null;
    //     $this->proyectID = null;
    //     $this->description = null;
    //     $this->start      = "0000-00-00";
    //     $this->end       = "0000-00-00";
    //     $this->completed = 0;
    //     $this->color     = "#ffb135";
    //     $this->tasks     = [];
    //     $this->targets   = [];
    // }

    // public function getCardHTMLFormat(){
    //     return '<div class="swiper-slide card">
    //                 <div class="card-body">
    //                     <h4 class="card-title">' . $this->name . '</h4>
    //                     <p class="card-text">' . $this->description . '</p>
    //                     <a href="' . constant('URL') . 'proyects/' . $this->proyectID . '" class="card-link btn btn-info">abrir</a>
    //                     <span class="card-link">' . $this->creationDate . '</span>
    //                 </div>
    //             </div>';
    // }

    // public function addTask($task){
    //     if($task->title != null){
    //         array_push($this->tasks, $task);
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    // public function addTarget($target){
    //     if($target->title != null){
    //         array_push($this->targets, $target);
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    // public function setColor($color){
    //     if(isset($color) and preg_match("((#)[0-9a-fA-F]{6})",$color)){
    //         $this->color = $color;
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    // public function setCompleted($state){
    //     if(gettype($state) == 'boolean'){
    //         $this->completed = $state;
    //         return true;
    //     }
    //     return false;
    // }

    // public function getJsonData(){
    //     $properties = [];
    //     array_push($properties, $this->$owner);
    //     array_push($properties, $this->$name);
    //     array_push($properties, $this->$proyectID);
    //     array_push($properties, $this->$description);
    //     array_push($properties, $this->$creationDate);
    //     array_push($properties, $this->$start);
    //     array_push($properties, $this->$end);
    //     array_push($properties, $this->$completed);
    //     array_push($properties, $this->$color);
    //     array_push($properties, $this->$tasks);
    //     array_push($properties, $this->$targets);
    //     return json_encode($properties);
    // }
}

class Task {
    public $title;
    public $description;
}

class Target {
    public $type;
    public $title;
    public $description;
    public $points;

    public function __construct(){
        $this->type = "short term";
        $this->title = null;
        $this->description = null;
        $this->points = [];
    }
}
?>