<?php

include_once("modelResponse.php");

class HomeModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->con = $this->conection->Connect();
        $this->user = $_SESSION['idanfree'];
    }

    public function getOneData($dato, $tabla, $condicion, $comparador){

        $respuesta = new ServiceResult();

        try{

            $sql = "SELECT $dato FROM $tabla WHERE $condicion = '$comparador'";
            $SqlBefore = $this->con->prepare($sql);
            $SqlBefore->execute();
            $data = $SqlBefore->fetch(PDO::FETCH_ASSOC);
            
            $respuesta->success = true;
            $respuesta->errors = 0;
            $respuesta->data = $data[$dato];
            
        }catch(PDOException $e){

            $respuesta->success = false;
            $respuesta->errors = $e;
            $respuesta->data = null;

        }

        return $respuesta;

    }

    public function getFirstRelation($id){

        $respuesta = new ServiceResult();

        try{

            $sql = "SELECT relacion FROM relaciones WHERE idanfree = '$id' LIMIT 1";
            $SqlBefore = $this->con->prepare($sql);
            $SqlBefore->execute();
            $data = $SqlBefore->fetch(PDO::FETCH_ASSOC);
            
            $respuesta->success = true;
            $respuesta->errors = 0;
            $respuesta->data = $data['relacion'];
            
        }catch(PDOException $e){

            $respuesta->success = false;
            $respuesta->errors = $e;
            $respuesta->data = null;

        }

        return $respuesta;

    }

    public function getAllrelations(){

        $respuesta = new ServiceResult();

        try{

            $sql = "SELECT idanfree,relacion FROM relaciones WHERE idanfree = '$this->user' OR relacion = '$this->user'";
            $SqlBefore = $this->con->prepare($sql);
            $SqlBefore->execute();
            
            $resultados = [];

            while($data = $SqlBefore->fetch(PDO::FETCH_ASSOC)){
                if($data["relacion"] == $this->user){
                        $dato = $data["idanfree"];
                }else{
                    $dato = $data["relacion"];
                }
                array_push($resultados, $dato);
            }
            
            $respuesta->success = true;
            $respuesta->errors = 0;
            $respuesta->data = $resultados;
            
        }catch(PDOException $e){

            $respuesta->success = false;
            $respuesta->errors = $e;
            $respuesta->data = null;

        }

        return $respuesta;

    }



    public function registMessage($emisor, $receptor, $mensaje, $fecha){
        $respuesta = new ServiceResult();
        try{
            $sql = "INSERT INTO mensajes(id, idanfree, relacion, mensaje, fecha) VALUE(0, '$emisor', '$receptor', '$mensaje', '$fecha')";
            $e = $this->con->prepare($sql);
            $e->execute();

            $respuesta->success = true;
            $respuesta->errors = 0;
        }catch(PDOException $e){
            $respuesta->success = false;
            $respuesta->errors = $e;
        }
        return $respuesta;
    }

    public function getMensajes($id_friend){

        $respuesta = new ServiceResult();

        try{
            $sql = "SELECT * FROM mensajes WHERE (idanfree = '$this->user' AND relacion = '$id_friend') OR (idanfree = '$id_friend' AND relacion = '$this->user')";
            $e = $this->con->prepare($sql);
            $e->execute();

            $mensajes = [];

            while($mensaje = $e->fetch(PDO::FETCH_ASSOC)){
                $n = new Mensaje();
                $n->emisor = $mensaje["idanfree"];
                $n->receptor = $mensaje["relacion"];
                $n->mensaje = $mensaje["mensaje"];
                $n->fecha = $mensaje["fecha"];
                array_push($mensajes, $n);
            }

            $respuesta->success = true;
            $respuesta->errors = 0;
            $respuesta->data = $mensajes;

        }catch(PDOException $e){
            $respuesta->success = false;
            $respuesta->errors = $e;
            $respuesta->data = null;
        }

        return $respuesta;
    }

    public function searchWords($s, $c){
        $res = new ServiceResult();
        try{

            if($c  <= 1){
                $sql = "SELECT idanfree,nombre,apodo,email,foto_nombre 
                    FROM " . constant("TABLA_REGISTRO") . " 
                    WHERE (nombre LIKE '%$s%' 
                    OR apodo LIKE '%$s%' 
                    OR email LIKE '%$s%') 
                    AND idanfree <> '$this->user'
                    LIMIT " . constant("MAX_SEARCH_RESULTS");
            }else{
                $sql = "SELECT  idanfree,nombre,apodo,email,foto_nombre, 
                    MATCH ( nombre, apodo, email ) 
                    AGAINST (  '$s' ) AS Score FROM " . constant("TABLA_REGISTRO") . " 
                    WHERE MATCH ( nombre, apodo, email ) AGAINST (  '$s' )
                    AND idanfree <> '$this->user' 
                    ORDER  BY Score DESC LIMIT " . constant("MAX_SEARCH_RESULTS");
            }

            $ex = $this->con->prepare($sql);
            $ex->execute();

            $people = [];

            while($r = $ex->fetch(PDO::FETCH_ASSOC)){
                $new = new amigo();
                $new->id = $r["idanfree"];
                $new->correo = $r["email"];
                $new->nombre = $r["nombre"];
                $new->apodo  = $r["apodo"];
                $new->foto   = ($r["foto_nombre"] != null and $this->UR_exists(constant("URL_FOTOS") . $r["foto_nombre"])) ? constant("URL_FOTOS") . $r["foto_nombre"] : constant("DEFAULT_FOTO");
                array_push($people, $new);
            }

            $res->success = true;
            $res->errors = 0;
            $res->data = $people;

        }catch(PDOException $e){
            $res->succes = false;
            $res->errors = $e;
        }finally{
            return $res;
        }
    }

    private static function UR_exists($url){
        $headers = get_headers($url);
        return stripos($headers[0],"200 OK");
    }

    public function createRelation($id){
        try{
            $sql = "INSERT INTO relaciones(id, idanfree, relacion) VALUE(0, '$this->user', '$id')";
            $SqlBefore = $this->con->prepare($sql);
            $SqlBefore->execute();
            
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function createPetitionRelation($id, $fecha){

        $res = new ServiceResult();

        try{

            $comprobar = "SELECT * FROM solicitudes 
            WHERE idanfree = '$id' AND 
            solicitud = '$this->user' AND estado = 2";

            $exComp = $this->con->prepare($comprobar);
            $exComp->execute();

            if(count($exComp->fetchAll()) == 0){

                $comprobarOtro = "SELECT * FROM solicitudes 
                WHERE idanfree = '$this->user' AND 
                solicitud = '$id' AND estado = 2";
                $exCompOtro = $this->con->prepare($comprobarOtro);
                $exCompOtro->execute();

                if(count($exCompOtro->fetchAll()) == 0){

                    $comprobarAmistad = "SELECT * FROM relaciones WHERE 
                    (idanfree = '$this->user' AND relacion = '$id') OR 
                    (idanfree = '$id' AND relacion = '$this->user')";
                    $exCompAmistad = $this->con->prepare($comprobarAmistad);
                    $exCompAmistad->execute();

                    if(count($exCompAmistad->fetchAll()) == 0){
                        $sql = "INSERT INTO solicitudes(id, idanfree, solicitud, fecha) VALUE(0, '$id', '$this->user', '$fecha')";
                        $SqlBefore = $this->con->prepare($sql);
                        $SqlBefore->execute();
                        if($SqlBefore){
                            $res->success = true;
                            $res->errors = 0;
                        }else{
                            $res->success = false;
                            $res->errors = 2;
                        }
                    }else{
                        $res->success = false;
                        $res->errors = 4;
                    }
                }else{
                    $res->success = false;
                    $res->errors = 3;
                }
            }else{
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

    public function getPetitions(){
        $res = new ServiceResult();
        try{
            $sql = "SELECT * FROM solicitudes WHERE idanfree = '$this->user' AND estado = 2";
            $exSql = $this->con->prepare($sql);
            $exSql->execute();

            $noti = [];

            while($row = $exSql->fetch(PDO::FETCH_ASSOC)){

                $n = new amigo();
                $n->id = $row["solicitud"];
                $n->fecha = $row["fecha"];

                $friendData = "SELECT nombre, apodo, foto_nombre FROM " . constant("TABLA_REGISTRO") . " WHERE idanfree = '$n->id'";
                $exFriend = $this->con->prepare($friendData);
                $exFriend->execute();

                while($row2 = $exFriend->fetch(PDO::FETCH_ASSOC)){
                    $n->nombre = $row2["nombre"];
                    $n->apodo = $row2["apodo"];
                    $n->foto = $row2["foto_nombre"] ? constant("URL_FOTOS") . $row2["foto_nombre"] : constant("DEFAULT_FOTO");
                }

                array_push($noti, $n);
            }

            $res->success = true;
            $res->errors = 0;
            $res->data = $noti;

        }catch(PDOException $e){
            $res->success = false;
            $res->errors = $e;
            $res->data = null;
        }finally{
            return $res;
        }
    }

    public function aceptPetition($id){
        $res = new ServiceResult();
        try{
            $sql = "UPDATE solicitudes SET estado = 1 WHERE solicitud = '$id' AND idanfree = '$this->user'";
            $exSql = $this->con->prepare($sql);
            $exSql->execute();

            $sql2 = "INSERT INTO relaciones(id, idanfree, relacion) VALUE(0, '$this->user', '$id')";
            $exSql2 = $this->con->prepare($sql2);
            $exSql2->execute();
            
            $res->success = true;
            $res->errors = 0;
        }catch(PDOException $e){
            $res->success = false;
            $res->errors = $e;
        }finally{
            return $res;
        }
    }

    public function deletePetition($id){
        $res = new ServiceResult();

        try{

            $sql = "UPDATE solicitudes SET estado = 0 WHERE solicitud = '$id' AND idanfree = '$this->user'";
            $exSql = $this->con->prepare($sql);
            $exSql->execute();
            
            $res->success = true;
            $res->errors = 0;
            
        }catch(PDOException $e){

            $res->success = false;
            $res->errors = $e;

        }finally{
            return $res;
        }
    }

    public function getNotificationsData(){

        $res = new ServiceResult();
        try{
            $sql = "SELECT * FROM notificaciones WHERE destinatario = '$this->user' ORDER BY fecha DESC";
            $exSql = $this->con->prepare($sql);
            $exSql->execute();

            $notificaciones = [];

            while($row = $exSql->fetch(PDO::FETCH_ASSOC)){
                $noti = new notificacion();
                $noti->asunto = $row["evento"];
                $noti->mensaje = $row["mensaje"];
                $noti->fecha = $row["fecha"];
                array_push($notificaciones, $noti);
            }

            $res->success = true;
            $res->errors = 0;
            $res->data = $notificaciones;

        }catch(PDOException $e){
            $res->success = false;
            $res->errors = $e;
        }finally{
            return $res;
        }
    }

    public function getProyectsModel(){
        $res = new ServiceResult();
        try{
            $sql = "SELECT * FROM proyectos WHERE idanfree = :user";
            $e = $this->con->prepare($sql);
            $e->bindValue(':user', $this->user);
            $e->execute();
            $proyectos = [];
            while($row = $e->fetch(PDO::FETCH_ASSOC)){
                $pt = new Proyecto();
                $pt->name = $row["nombre"];
                $pt->proyectID = $row["proyectid"];
                $pt->description =$row["descripcion"];
                $pt->creationDate = date("d/m/Y H:m ", strtotime($row["fecha_creacion"]));
                $pt->color = $row["color"];
                $pt->completed = $row["terminado"];
                array_push($proyectos, $pt);
            }
            $res->success = True;
            $res->data = $proyectos;
        }catch(PDOException $e){
            $res->success = false;
            $res->errors = $e;
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

                $insert = "INSERT INTO proyectos(id,idanfree,proyectid,nombre,descripcion,fecha_inicio,fecha_termino,color,fecha_creacion,terminado) VALUE(0,'$pt->owner','$pt->proyectID','$pt->name','$pt->description','$pt->start','$pt->end','$pt->color','$pt->creationDate','$pt->completed')";
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

// $res = new ServiceResult();
// try{

//     $res->success = true;
// }catch(PDOException $e){
//     $res->success = false;
//     $res->errors = $e;
// }finally{
//     return $res;
// }

?>