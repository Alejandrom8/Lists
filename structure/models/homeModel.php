<?php 

class HomeModel extends Model{
    public function __construct(){
        parent::__construct();
        $this->con = $this->conection->Connect();
    }
    public function getFoto($id){
        try{

            $sql = "SELECT foto_nombre FROM " . constant("TABLA_REGISTRO") .  " WHERE idanfree = '$id' LIMIT 1";
            $SqlBefore = $this->con->prepare($sql);
            $SqlBefore->execute();
            $data = $SqlBefore->fetch(PDO::FETCH_ASSOC);
            $estado = true;
            $respuesta = $data["foto_nombre"];

            return ["estado" => $estado, "respuesta" => $respuesta];
            
        }catch(PDOException $e){
            return ["estado" => false, "mensaje" => $e];
        }
    }
    public function getFile($id){
        try{

            $sql = "SELECT mensajes_ruta FROM mensajes WHERE idanfree = '$id' LIMIT 1";
            $SqlBefore = $this->con->prepare($sql);
            $SqlBefore->execute();
            $data = $SqlBefore->fetch(PDO::FETCH_ASSOC);
            $respuesta = $data["mensajes_ruta"];

            return $respuesta;
            
        }catch(PDOException $e){
            return $e;
        }
    }
}

?>