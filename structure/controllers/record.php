<?php
include_once 'structure/models/registro.php';
class record extends Controller implements Render{
    
    public function __construct(){
        parent::__construct();
        $this->formatosPermitidos = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];
    }

    public function render(){
        $this->view->render("utopia/record");
    }

    public function newRecord(){
        
        $status = [false, 'Ningun proceso se llevo a cabo'];

        $registro = new NewRecordObject();
        $registro->nombre = $this->desinfect($_REQUEST['nombre']);
        $registro->cumple = $this->desinfect($_REQUEST['age']);
        $registro->pass = password_hash($this->desinfect($_REQUEST["password"]),PASSWORD_DEFAULT);
        $registro->email = $this->desinfect($_REQUEST['email']);
        $registro->genero = $this->desinfect($_REQUEST['genero']);
        $registro->apodo = $this->desinfect($_REQUEST['apodo']);
        $registro->foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;
        $registro->fechaRegistro = strftime("%y-%m-%d %H:%M");
        $registro->ruta = null;

        $buscar_registro_existente = $this->model->buscar('nombre', constant('TABLA_REGISTRO'), 'email', $registro->email);

        if(!$buscar_registro_existente[0]){
            if($buscar_registro_existente[1] != 'error'){
                $buscar_nombre_existente = $this->model->buscar('nombre', constant('TABLA_REGISTRO'), 'nombre', $registro->nombre);
                if(!$buscar_nombre_existente[0]){
                    if($buscar_nombre_existente[1] != 'error'){
                        //validando la foto
                        if($registro->foto != null){
                            if(in_array($registro->foto['type'], $this->formatosPermitidos)){
                                if($registro->foto['size'] <= constant('MAX_FOTO_SIZE')){
                                    $name = basename($registro->foto["name"]);
                                    $registro->ruta = constant('CARPETA_FOTOS') . $name;
                                }else{
                                    echo json_encode([false, "El tamano de la foto pasa los limites de subida, elige una foto mas pequena"]);
                                    die();
                                }
                            }else{
                                echo json_encode([false, "Introduzca una imagen con formato jpg, png, jpeg o gif"]);
                                die();
                            }
                        }
                        
                        $estado_de_registro = $this->model->registrar($registro);
                        if($estado_de_registro[0]){

                            if($registro->genero == 0){
                                $letra = 'a';
                            }elseif($registro->genero == 1){
                                $letra = 'o';
                            }else{
                                $letra = '@';
                            }

                            $estado = true;
                            $mensaje = "Registro Exitoso!, Bienvenid" . $letra;
                            $url = constant('URL') . 'home';
                            $status = [$estado, $mensaje, $url];
                            
                            $this->iniciarSesion($registro->nombre, $registro->email);
                            //$this->enviarBienvenida();
                        }else{
                            $status = [false, $estado_de_registro[2]];
                        }
                    }else{
                        $status = [false, $buscar_nombre_existente[2]];
                    }
                }else{
                    $status = [false, "Ya hay un registro con este nombre"];
                }
            }else{
                $status = [false, $buscar_registro_existente[2]];
            }
        }else{
            $status = [false, "Ya hay un registro con este correo electronico"];
        }

        echo json_encode($status);
    }

    private static function iniciarSesion($nombre, $email){
        session_regenerate_id();
        $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['nombre'] = $nombre;
        $_SESSION['email'] = $email;
        return true;
    }

    private static function enviarBienvenida(){
        $destino = $_SESSION['email'];
        $nombre = $_SESSION['nombre'];
        $desde = "From: Anfree";
        $asunto = "Bienvenido a Anfree";
        $mensaje = "<div style='width:100%;display:flex;align-items:center;'>
                        <div style='margin:0 auto;width:95%;height:90%;'>
                            <header style='width:100%;height:200px;background:orange;text-align:center;'>
                                <h2>Bienvenido ". $nombre ."!</h2>
                            </header>
                            <p>Este es un correo de prueba para darte la bienvenida ya que te acabas de registrar</p>
                        </div>
                      </div>";
        mail($destino, $asunto, $mensaje, $desde);
    }
}
?>