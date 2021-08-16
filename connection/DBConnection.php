<?php
class Connection{
   /*  function __construct()
    {
    }
    function __destruct()
    {
    } */
    public function connect(){
        try {
            //Get credentials
            require_once 'Config.php';
            //Init PDO for mysql
            $con = new PDO('mysql:host=' . DB['SERVER'] . ';dbname=' . DB['DATABASE'] . ';charset=utf8', DB['USER'], DB['PASSWORD']);
            //configuration for PDO
            $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->setAttribute(PDO::ATTR_PERSISTENT, false);

            return $con;
        } catch (PDOException $e) {
            //Show errors
            echo "PDO error connection, try again later";
            file_put_contents("PDOerrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
    /* public function close(){
    } */
}
