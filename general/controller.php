<?php
interface Render{
    public function render();
}
class Controller{
    public function __construct(){
        $this->view = new View();
    }
    public function loadModel($model){
        $url_model = 'structure/models/' . $model . 'Model.php';

        if(file_exists($url_model)){
          require_once($url_model);

          $modelName = $model . 'Model';
          $this->model = new $modelName();
        }
    }
}
?>