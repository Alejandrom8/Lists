<?php 
include_once("modelResponse.php");

class ProyectoModel{

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

}

class ProyectsModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->con = $this->conection->Connect();
        $this->user = $_SESSION['idanfree'];
    }

    public function getProyect($id){
        $res = new ServiceResult();
        try{
            $sql = "SELECT * FROM `proyectos` WHERE idanfree='$this->user' AND proyectid = '$id'";
            $exec = $this->con->prepare($sql);
            $exec->execute();

            if($exec){
                $pt_new = [];

                while($row = $exec->fetch(PDO::FETCH_ASSOC)){
                    $pt = new ProyectoModel();
                    $pt->owner = $this->user;
                    $pt->proyectID = $row['proyectid'];
                    $pt->name = $row['nombre'];
                    $pt->description = $row['descripcion'];
                    $pt->start = $row['fecha_inicio'];
                    $pt->end = $row['fecha_termino'];
                    $pt->completed = $row['terminado'];
                    $pt->color = $row['color'];
                    array_push($pt_new, $pt);
                }

                $res->data = $pt_new;
                $res->success = true;
            }else{
                $res->success = false;
                $res->errors = 1;
                $res->message = "Ningun resultado encontrado";
            }
        }catch(PDOException $e){
            $res->success = false;
            $res->errors = $e;
        }finally{
            return $res;
        }
    }

    public function getAllProyects(){
        $res = new ServiceResult();
        try{
            $sql = "SELECT * FROM `proyectos` WHERE idanfree='$this->user'";
            $exec = $this->con->prepare($sql);
            $exec->execute();

            if($exec){
                $pt_new = [];

                while($row = $exec->fetch(PDO::FETCH_ASSOC)){
                    $pt = new ProyectoModel();
                    $pt->owner = $this->user;
                    $pt->proyectID = $row['proyectid'];
                    $pt->name = $row['nombre'];
                    $pt->description = $row['descripcion'];
                    $pt->start = $row['fecha_inicio'];
                    $pt->end = $row['fecha_termino'];
                    $pt->completed = $row['terminado'];
                    $pt->color = $row['color'];
                    array_push($pt_new, $pt);
                }

                $res->data = $pt_new;
                $res->success = true;
            }else{
                $res->success = false;
                $res->errors = 1;
                $res->data = null;
                $res->message = "Ningun resultado encontrado";
            }
        }catch(PDOException $e){
            $res->success = false;
            $res->errors = $e;
            $res->data = null;
        }finally{
            return $res;
        }
    }

    public function saveProyect($pt){
        $res = new ServiceResult();
        try{
            $sql = "SELECT proyectid FROM proyectos WHERE idanfree = :user";
            $execSql = $this->con->prepare($sql);
            $execSql->bindValue(':user', $this->user);
            $execSql->execute();

            if($execSql->rowCount() <= 50){

                $insert = "INSERT INTO 
                          proyectos(
                              id,
                              idanfree,
                              proyectid,
                              nombre,
                              descripcion,
                              fecha_inicio,
                              fecha_termino,
                              color,
                              fecha_creacion,
                              terminado
                          )
                          VALUE(
                              0,
                              $pt->owner,
                              $pt->proyectID,
                              $pt->name,
                              $pt->description,
                              $pt->start,
                              $pt->end,
                              $pt->color,
                              $pt->creationDate,
                              $pt->completed
                          )";
                $execInsert = $this->con->prepare($insert);
                $execInsert->execute();

                $res->success = true;
            }else{
                //Break: el usuario tiene demasiados proyectos (50)
                $res->success = false;
                $res->errors = 1;
            }

        }catch(PDOException $e){
            $res->success = false;
            $res->errors = $e;
        }finally{
            return $res;
        }
    }
}
?>