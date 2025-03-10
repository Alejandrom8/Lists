<?php
class Connection {
    private $user;
    private $password;
    private $host;
    private $dataBase;
    private $charset;

    public function __construct(){
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
        $this->host = constant('HOST');
        $this->dataBase = constant('DB');
        $this->charset = constant('CHARSET');
    }

    public function Connect(){
        try{

            $conection = "mysql:host=" . $this->host . ";dbname=" . $this->dataBase . ";charset=" . $this->charset;
            $options = [
              PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_EMULATE_PREPARES    => false,
              PDO::ATTR_ORACLE_NULLS      => PDO::NULL_TO_STRING,
            ];
            $pdo = new PDO($conection, $this->user, $this->password, $options);
    
            return $pdo;
    
          }catch(PDOException $e){
            print_r("Error de conexion: " . $error->getMessage() . "</br>");
          }
    }
}
?>