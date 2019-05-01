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

        if($foto_usuario["estado"]){

            $img_url = constant("LOCAL") . "intranet/uploads/" . $foto_usuario["respuesta"];
            if(!$this->UR_exists($img_url)){
                $img_url = constant("DEFAULT_FOTO");
            }
            $_SESSION['user_foto'] = $img_url;

        }else{
            $_SESSION['user_foto'] = constant("DEFAULT_FOTO");
        }

        print("<script>window.location= '" . constant("URL") . "home';</script>");
    }

    public function readFriends(){
        $archivo_dir = $this->model->getFile($_SESSION['idanfree']);
        $archivo = file_get_contents($archivo_dir);
        echo json_encode($archivo);
    }

    private static function UR_exists($url){
        $headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;
    }
}

?>