<?php
include_once 'structure/models/registro.php';
class recordModel extends Model{
    public function __construct(){
        parent::__construct();
        $this->con = $this->conection->Connect();
    }

    public function buscar($dato, $tabla, $referencia, $comparar){
        try{
            $search = "SELECT $dato FROM $tabla WHERE $referencia = '$comparar'";
            $searchState = $this->con->prepare($search);
            $searchState->execute();
            while($row = $searchState->fetch(PDO::FETCH_ASSOC)){
                return [true, 'success'];
            }

            $searchState->closeCursor();
            return [false, 'success'];
            
        }catch(PDOException $error){
            return [false, 'error', $error];
        }
    }

    public function registrar($registro){
        $data = new NewRecordObject();
        $data = $registro;
        $registro = $data;
        try{
            $ruta = $registro->ruta ? $registro->ruta : "";
            $insert = "INSERT INTO " . constant('TABLA_REGISTRO') . "(id, nombre, apodo, email, pass, cumple, genero, foto_ruta, fecha_registro) 
                       VALUE(
                           0,
                           '$registro->nombre',
                           '$registro->apodo',
                           '$registro->email',
                           '$registro->pass',
                           '$registro->cumple',
                           '$registro->genero', 
                           '$ruta',
                           '$registro->fechaRegistro'
                       )";
            $execInsert = $this->con->prepare($insert);
            $execInsert->execute();
            $execInsert->closeCursor();
            if($registro->ruta){
                move_uploaded_file($registro->foto['tmp_name'], $registro->ruta);
            }
            return [true, 'success'];
        }catch(PDOException $error){
            return [false, 'error', $error];
        }
    }
}
?>