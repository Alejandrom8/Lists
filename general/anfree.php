<?php
session_start();
require_once "structure/controllers/error.php";

class Anfree{

    protected $user;
    protected $password;
    public $u;

    public function __construct(){

        $this->user = $_SESSION['nombre'];
        $this->password = $_SESSION['email'];

        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        $this->u = $url[0];
        
        if(empty($this->u)){
            require('structure/controllers/utopia.php');
            $WelcomePage = new Utopia();
            $WelcomePage->loadModel('utopia');
            $WelcomePage->render();
            return false;
        }else{
            $access = $this->u != 'record' ? $this->access($this->user, $this->password) : true;

            if($access){
                $file_of_controller = 'structure/controllers/' . $this->u . '.php';
                if(file_exists($file_of_controller)){
                    require_once $file_of_controller;
                    $page = new $this->u;
                    $page->loadModel($this->u);
                    $num_of_parameters = sizeof($url);
                    if($num_of_parameters > 1){
                        if($num_of_parameters > 2){
                            $parameters = [];
                            for($i = 2; $i < $num_of_parameters; $i++){
                                array_push($parameters, $url[$i]);
                            }
                            if(method_exists($page, $url[1])){
                                $page->{$url[1]}($parameters);
                            }else{
                                $page = new ManageError();
                            }
                        }else{
                            if(method_exists($page, $url[1])){
                                $page->{$url[1]}();
                            }else{
                                $page = new ManageError();
                            }
                        }
                    }else{
                        //solo se llamo a un controlador
                        $page->render();
                    }
                }else{
                    $page = new ManageError();
                }
            }else{
                print("<script>
                        alert('acceso denegado');
                        window.location = '". constant('URL') ."';
                      </script>");
            }
        }
    }

    protected static function access(){
        $variables = func_get_args();
        foreach($variables as $variable){
            if(!isset($variable) || $variable == null || $variable == ""){
                return false;
            }
        }
        return true;
    }
}

?>