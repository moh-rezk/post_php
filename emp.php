<?php
session_start();
require_once("db_connection.php");
require_once("empolyee.php");

// ************************* edit **********************

if (isset($_GET['action'])&&$_GET['action']=='edit'&&isset($_GET['id']) ) {

    $id= filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    if($id>0){
        $dataQyery=$conn->prepare("SELECT * FROM `employee` where id= :id");
        $dataUser=$dataQyery->execute( ['id'=>$id]);
        $user=$dataQyery->fetchAll(PDO::FETCH_ASSOC);
        $user=array_shift($user);


   
      

    }

   


  
}

// ************************** insert***********************
if (isset($_POST['submit'])) {

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
    $address = filter_input(INPUT_POST, 'addess', FILTER_SANITIZE_STRING);
    $salary = filter_var($_POST['salary'], FILTER_SANITIZE_NUMBER_INT);
    $tax = filter_input(INPUT_POST, 'tax', FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);




    $paramter=[
        ":name"=>$name,
        ":email"=>$email,
        ":salary"=>$salary,
        ":address"=>$address,
        ":tax"=>$tax,
        ":age"=>$age
      
    ];
    if (isset($_GET['action'])&&$_GET['action']=='edit'&&isset($_GET['id']) ) {

        $query =  "UPDATE `employee` SET `name`=:name,`email`=:email,`salary`=:salary,`address`=:address,`tax`=:tax,`age`=:age WHERE `id`=:id";
        $paramter[':id']=$_GET['id'];


    }else{

        $query = "INSERT INTO `employee`( `name`, `email`, `salary`, `address`, `tax`, `age`) VALUES
        (:name,:email,:salary,:address,:tax,:age)";
        
    }

   


   
 $perp=$conn->prepare($query);
 $stat= $perp->execute($paramter);

    
    if ($stat &&$_GET['action']=='edit') {


       
        $_SESSION['success'] = "we updated data successfully";
        header('location:emp.php');
        session_write_close();
        exit();
        
      
        
    } else if($stat){
        $_SESSION['success'] = "we inserted data successfully";
        header('location:emp.php');
        session_write_close();
        exit();

    }
    else {

        $_SESSION['error'] = "we  didn't insert data and we found error ";
        header('location:emp.php');
        session_write_close();
        exit();
    }
}


// **********************************end insert *************************************************

// ******************************* delete ******************************

if (isset($_GET['action'])&&$_GET['action']=='delete'&&isset($_GET['id']) ) {
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    if ($id>0) {


        $query =  "DELETE FROM `employee` WHERE `id`=:id";
    
        $perp=$conn->prepare($query);
        $stat= $perp->execute([':id'=>$id]);
    
        
        if ($stat &&$_GET['action']=='delete') {
    
    
           
            $_SESSION['success'] = "we deleted data successfully";
            header('location:emp.php');
            session_write_close();
            exit();
            
          
            
        }
    }

   



}




// ********************** select
$dataQyery=$conn->query('SELECT * FROM `employee` ');

 $result= $dataQyery->fetchAll(PDO::FETCH_CLASS |PDO::FETCH_PROPS_LATE,'Employee',['name','salary','tax','age','address']);
// $result= $dataQyery->fetchAll(PDO::FETCH_ASSOC);
// var_dump($result);
$result=(is_array($result)&&!empty($result))?$result:false;



?>
<!-- ******************************** -->

<html>

<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
   
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">


</head>

<body>



    <div class=" w-25 m-5  bg-transparent float-left">


    <?php
    
    if(isset( $_SESSION['success'])){?>

        <div class="alert alert-success" role="alert">
            
        <?= $_SESSION['success'] ?>
          
        </div>

       
    <?php  unset( $_SESSION['success']);  }
   
    
   
 
 
   

    ?>

    <?php

    if(isset( $_SESSION['error'])){?>

    <div class="alert alert-danger" role="alert">
     
    <?= $_SESSION['error'] ?>
  
    </div>


<?php unset( $_SESSION['success']);  } 


?>

        <form method="POST" enctype="application/x-www-form-urlencoded" >


            <input class=" form-control shadow bg-transparent rounded-pill text-center my-3" type="text" name="name" placeholder="name" value="<?= isset($user)? $user['name']: ''?>">
            <input class=" form-control shadow bg-transparent rounded-pill text-center my-3" type="text" name="email" placeholder="email" value="<?= isset($user)? $user['email']:'' ?>">
            <input class=" form-control shadow bg-transparent rounded-pill text-center my-3" type="text" name="age" placeholder="age" value="<?= isset($user)? $user['age']:'';?>"/>
            <input class=" form-control shadow bg-transparent rounded-pill text-center my-3" type="text" name="addess" placeholder="addess" value="<?= isset($user)? $user['address']:'';?>"/>
            <input class=" form-control shadow bg-transparent rounded-pill text-center my-3" type="text" name="salary" placeholder="salary" value="<?= isset($user)? $user['salary']:'';?>"/>
            <input class=" form-control shadow bg-transparent rounded-pill text-center my-3" type="floatval" name="tax" placeholder="tax" value="<?= isset($user)? $user['tax']:'';?>"/>
            <button type="submit" value="submit" name="submit" class=" btn btn-secondary form-control my-3 rounded-pill "> submit</button>

        </form>
    </div>





    <div>
        <table class=" table table-striped table-sm w-50 m-5 bg-transparent float-right">


            <thead>
                <tr>
                    <td> name</td>
                    <td> age</td>
                    <td> email</td>
                    <td> address</td>
                    <td> salary</td>
                    <td> tax</td>
                    <td> control</td>
                </tr>
            </thead>
            <tbody>
                <?php if($result==0){?>

                 <tr> 
                     <td colspan="7" class=" text-center"> no data found</td>
                 </tr>

               <?php }else{  foreach($result as $item){ ?>
                <tr>
                    <td> <?= $item->name ?></td>
                    <td> <?= $item->age ?></td>
                    <td> <?= $item->email ?></td>
                    <td> <?= $item->address ?></td>
                    <td> <?= $item->salary() ?></td>
                    <td> <?= $item->tax ?></td>
                    <td> <a href="emp.php?action=edit&id=<?= $item->id?>"> <i class="fas aal fa-edit"> </i></a>
                      <a href="emp.php?action=delete&id=<?= $item->id?>" onclick="!confirm('do you want to cxl ')? false: true "> <i class="fas fa-user-minus"></i> </a></td>
                   
                   
                </tr> 
                <?php } }?>
            </tbody>

        </table>
    </div>


    <script src="js/script.js"></script>

</body>

</html>

<?php 
 


?>