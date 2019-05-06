<?php 
class ServiceResult {
    public $success;
    public $errors;
    public $messages;
    public $data;
    public $onSuccessEvent;
    public $onErrorEvent; 
} 

class Mensaje{
    public $emisor;
    public $receptor;
    public $mensaje;
    public $fecha;
}
?>