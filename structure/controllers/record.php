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

    private function enviarBienvenida(){
        //corregir email por id
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

    private function generarId($objeto){

        /*
            @param String $objeto ; la palabra a codificar 
        */
        $sizeID = 7;

        $objeto = preg_replace('([^A-Za-z])', '', $objeto);
        $work = str_split(strtolower($objeto));
        $id = "";
        $cont = 0;
        $letras = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
        $letrasLenght = sizeof($letras)-1;
        $valores = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, a, b, c, d, e, f, "0a", "1b", "2c", "3d", "4e", "5f", "60", "71", "82", "93", "a4"];
        // for($i = 0; $i < $letrasLenght + 1; $i++){
        //     array_push($valores, rand(0, $letrasLenght));
        // }
        foreach($work as $key => $val){
            foreach($letras as $index => $letra){
                if($val == $letra){
                    $id .= $valores[$index];
                }
            }
        }

        if(strlen($id) < $sizeID){
            while(strlen($id) < $sizeID){
                $id .= rand(0, 9);
            }
        }else if(strlen($id) > $sizeID){
            $id = substr($id, 0, 6);
        }

        $id .= rand(22, 144);
        return $id;
    }

    public function newRecord(){

        $registro = new NewRecordObject();
        
        $registro->nombre        = $this->desinfect($_REQUEST['nombre']);
        $registro->cumple        = $this->desinfect($_REQUEST['age']);
        $registro->pass          = hash('sha512', $this->desinfect($_REQUEST["pass"]));
        $registro->email         = $this->desinfect($_REQUEST['email']);
        $registro->genero        = $this->desinfect($_REQUEST['genero']);
        $registro->apodo         = $this->desinfect($_REQUEST['apodo']);
        $registro->foto          = isset($_FILES['foto']) ? $_FILES['foto'] : null;
        $registro->fechaRegistro = strftime("%y-%m-%d %H:%M");
        $registro->ruta          = null;
        $registro->fotoNombre    = null;

        $status = [false, 'Ningun proceso se llevo a cabo'];

        $buscarRegistroExistente = $this->model->buscar('nombre', constant('TABLA_REGISTRO'), 'email', $registro->email);

        if(!$buscarRegistroExistente[0]){
            if($buscarRegistroExistente[1] != 'error'){
                $buscarNombreExistente = $this->model->buscar('nombre', constant('TABLA_REGISTRO'), 'nombre', $registro->nombre);
                if(!$buscarNombreExistente[0]){
                    if($buscarNombreExistente[1] != 'error'){

                        $id = $this->generarId($registro->apodo);
                        $id = strftime("%y") . $id;
                
                        $registro->idanfree = $id;
                        $nombreArchivoMensajes = "m_" . $id . ".json";
                        $registro->mensajes_ruta = constant("CARPETA_MENSAJES") . $nombreArchivoMensajes;

                        //validando la foto si se a introducido una
                        if($registro->foto != null){
                            if(in_array($registro->foto['type'], $this->formatosPermitidos)){
                                if($registro->foto['size'] <= constant('MAX_FOTO_SIZE')){

                                    for($i = 0; $i < count($this->formatosPermitidos)-1; $i++){
                                        if($registro->foto["type"] == $this->formatosPermitidos[$i]){
                                            $tipo = explode("/", $this->formatosPermitidos[$i]);
                                            $tipo = $tipo[1];
                                        }
                                    }
                                    $name = explode(".", $registro->foto["name"]);
                                    $name = basename($registro->foto["name"],$name[1]);
                                    $name = preg_replace('([^A-Za-z0-9])', '', $name);

                                    $nombre_foto = $name . "_" . $id . "." . $tipo;

                                    $registro->ruta = constant('CARPETA_FOTOS') . $nombre_foto;
                                    $registro->fotoNombre = $nombre_foto;

                                }else{
                                    echo json_encode([false, "El tamaño de la foto pasa los limites de subida, elige una foto mas pequeña"]);
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

                            $archivo = fopen($registro->mensajes_ruta, "x");
                            fwrite($archivo, date("d m Y H:m:s") . "\n");
                            fclose($archivo);

                            $estado = true;
                            $mensaje = "Registro Exitoso!, Bienvenid" . $letra;
                            $url = constant('URL') . 'home/getData';
                            $status = [$estado, $mensaje, $url];
                            
                            $this->iniciarSesion($registro->nombre, $registro->idanfree);
                            // $this->enviarBienvenida();
                        }else{
                            $status = [false, $estado_de_registro[2]];
                        }
                        
                    }else{
                        $status = [false, $buscarNombreExistente[2]];
                    }
                }else{
                    $status = [false, "Ya hay un registro con este nombre"];
                }
            }else{
                $status = [false, $buscarRegistroExistente[2]];
            }
        }else{
            $status = [false, "Ya hay un registro con este correo electronico"];
        }

        echo json_encode($status);
    }
}
?>