<?php
require_once 'Config.php';
class Connection{
    public function connect(){
        try {
            $con = new PDO('mysql:host=' . DB['SERVER'] . ';dbname=' . DB['DATABASE'] . ';charset=utf8', DB['USER'], DB['PASSWORD']);
            $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->setAttribute(PDO::ATTR_PERSISTENT, false);

            return $con;
        } catch (PDOException $e) {
            echo "PDO error connection, try again later";
            file_put_contents("PDOerrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
}
