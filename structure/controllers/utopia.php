<?php
class Utopia extends Controller implements Render {
    public function __construct(){
        parent::__construct();
    }
    public function render(){
        $this->view->render('utopia/index');
    }
    
}
?>