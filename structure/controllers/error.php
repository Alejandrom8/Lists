<?php
class ManageError extends Controller{
    public function __construct(){
        parent::__construct();
        print("<script>alert('Error');window.location = '". constant('URL') ."';</script>");
    }
}
?>