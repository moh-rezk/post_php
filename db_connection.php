<?php

try {

    $username="root";
    $password="";
    $servername="localhost";


    $conn=new PDO("mysql:host=$servername;dbname=work", $username, $password,[
    
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8',

    ]);

} catch (PDOException $e) {
   echo $e;
    
}

?>