<?php

include_once("modelResponse.php");

class HomeModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->con = $this->conection->Connect();
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

    public function getAllData($dato, $tabla, $condicion, $comparador){

        $respuesta = new ServiceResult();

        try{

            $sql = "SELECT $dato FROM $tabla WHERE $condicion = '$comparador' OR 'relacion' = '$comparador' ORDER BY id ASC";
            $SqlBefore = $this->con->prepare($sql);
            $SqlBefore->execute();
            
            $resultados = [];

            while($data = $SqlBefore->fetch(PDO::FETCH_ASSOC)){
                array_push($resultados, $data[$dato]);
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
        $user = $_SESSION['idanfree'];

        try{
            $sql = "SELECT * FROM mensajes WHERE (idanfree = \"$user\" AND relacion = '$id_friend') OR (idanfree = '$id_friend' AND relacion = '$user')";
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

}

?>