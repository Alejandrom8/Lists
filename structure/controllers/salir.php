<?php 

class Salir extends Controller{
    public function __construct(){
        parent::__construct();   
    }
    public function saliendo(){
        echo "Espere un momento porfavor...";
        foreach($_SESSION as $key => $value){
          $_SESSION[$key] = NULL;
        }
        session_destroy();
        print("<script>window.location = '" . constant('URL') . "';</script>'");
      }
}

?>