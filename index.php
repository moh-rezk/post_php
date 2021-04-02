
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

 $select="select * from users";
 $get_data=$conn->query($select);
 



 if(isset($_POST['submit'])){


    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
    
    $password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
    $query="INSERT INTO `users`(`email`, `password`) VALUES ('$email','$password')";
    $insert_in_users=$conn->exec($query);
    if($insert_in_users){

        echo" done ";
    }
   

 }else{

    echo "eee";
 }





?>