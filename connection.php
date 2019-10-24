<?php

// class Connection
// {

    function getConnection(){
        try{
            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=Yellow;charset=utf8', 'root', '@tatsuya1707');
            return $pdo;
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
// }
