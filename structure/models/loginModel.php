<?php 

class LoginModel extends Model{
    public function __construct(){
        parent::__construct();
        $this->con = $this->conection->Connect();
    }
    public function validar($nc, $pass){
        try{
            $usuario = null;
            $sql = "SELECT pass FROM registros WHERE nombre = '$nc' OR email = '$nc' LIMIT 1";
            $sqlprepare = $this->con->prepare($sql);
            $sqlprepare->execute();
            while($row = $sqlprepare->fetch(PDO::FETCH_ASSOC)){
                $usuario = $row['pass'];
            }
            if($usuario){
                if(password_verify($pass, $usuario)){
                    return [true, ''];
                }else{
                    return [false, 'contraseña incorrecta'];
                }
            }else{
                return [false, 'Usuario o correo incorrecto'];
            }
        }catch(PDOException $e){
            return [false, $e];
        }
    }
}

?>