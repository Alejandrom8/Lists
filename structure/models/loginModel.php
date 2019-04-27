<?php 

class LoginModel extends Model{
    public function __construct(){
        parent::__construct();
        $this->con = $this->conection->Connect();
    }
    public function validarNC($nc, $pass){
        try{
            $usuario = null;
            $sql = "SELECT nombre,email,pass FROM registros WHERE nombre = '$nc' OR email = '$nc' LIMIT 1";
            $sqlprepare = $this->con->prepare($sql);
            $sqlprepare->execute();

            while($row = $sqlprepare->fetch(PDO::FETCH_ASSOC)){
                $usuario = $row['email'];
                $nombre = $row['nombre'];
                $pre = $row['pass'];
            }

            if($usuario){
                if($pass == $pre){
                    return [true, "", [$nombre,$usuario]];
                }else{
                    return [false, "Usuario o contraseña incorrecto"];
                }
            }else{
                return [false, "Usuario o contraseña incorrecto"];
            }

        }catch(PDOException $e){
            return [false, $e];
        }
    }
}

?>