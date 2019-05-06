<?php 
class Home extends controller implements Render{

    public function __construct(){
        parent::__construct();
    }

    public function render(){
        $this->view->render('home/index');
    }

    public function getData(){
        $foto_usuario = $this->model->getFoto($_SESSION["idanfree"]);

        if($foto_usuario != null){

            $img_url = constant("LOCAL") . "intranet/uploads/" . $foto_usuario;
            if(!$this->UR_exists($img_url)){
                $img_url = constant("DEFAULT_FOTO");
            }
            $_SESSION['user_foto'] = $img_url;

        }else{
            $_SESSION['user_foto'] = constant("DEFAULT_FOTO");
        }

        print("<script>window.location= '" . constant("URL") . "home';</script>");
    }

    public function getDataFriends(){

        $archivo = $this->getFileArray();
        $amigos = $archivo["amigos"];
        $fotos = [];

        foreach($amigos as $key => $amigo){
            $foto = $this->model->getFoto($amigo);
            $nombre = $this->model->getNombre($amigo);
            if($foto == null || $foto == false){
                $foto = constant("DEFAULT_FOTO");
            }else{
                $foto = constant("LOCAL") . "intranet/uploads/" . $foto;
            }
            $fotos[] = ["idanfree" => $amigo, "nombre" => $nombre,"foto" => $foto];
        }
        
        echo json_encode($fotos, true);
    }
    
    public function getConversation(){
        $index = (string)$_POST['data'];
        $archivo = $this->getFileArray();
        $mensajes = $archivo["mensajes"];
        $mensajes = (array)$mensajes;
        echo json_encode($mensajes[$index], true);
    }

    private static function UR_exists($url){
        $headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;
    }

    protected function getFileArray(){
        $archivo_dir = $this->model->getFile($_SESSION['idanfree']);
        $archivo = file_get_contents($archivo_dir);
        $amigos = json_decode($archivo, true);
        return $amigos;
    }

    public function sendMessage(){

        $friend = $_REQUEST['friend'];
        $mensaje = $_REQUEST['message'];
        $fecha = strtotime("%y-%m-%d");
        
        $archivo = $this->getFileArray();

        if(isset($archivo["mensajes"][$friend])){

            $longitud = count($archivo["mensajes"][$friend]);
            $index = "mensaje" . $longitud;
            $idanfree_local = $_SESSION['idanfree'];

            $nuevoMensaje = ["id" => $idanfree_local, "mensaje" => $mensaje, "fecha" => "19-04-02"];
            $archivo["mensajes"][$friend][$index] = $nuevoMensaje;
            
            $archivo_dir = $this->model->getFile($idanfree_local);
            file_put_contents($archivo_dir, json_encode($archivo));

            $archivo_dir_friend = $this->model->getFile($friend);
            $archivo_friend_get = file_get_contents($archivo_dir_friend);
            $archivo_friend = json_decode($archivo_friend_get, true);

            $archivo_friend["mensajes"][$idanfree_local][$index] = $nuevoMensaje;

            file_put_contents($archivo_dir_friend, json_encode($archivo_friend));
        }else{ 

        }
    }
}

?>