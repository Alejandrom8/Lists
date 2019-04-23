<?php 
class Home extends controller implements Render{
    public function __construct(){
        parent::__construct();
    }
    public function render(){
        $this->view->render('home/index');
    }
}

?>