<?php

header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods:POST, GET, OPTIONS, PUT');
header('Accept:application/json');
header('Access-Control-Allow-Credentials :true');

if(!isset($_POST)) die();

session_start();

$response [];
$con = new mysqli('localhost','root','root','test_site');

$email=mysqli_real_escape_string($con, $_POST['email']);
$pass=mysqli_real_escape_string($con,  $_POST['pass']);
$fname=mysqli_real_escape_string($con, $_POST['fname']);
$lname=mysqli_real_escape_string($con, $_POST['lname']);
$phone=mysqli_real_escape_string($con, $_POST['phone']);



    if(mysqli_connect_error())
    {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        echo "not connected";
        $response['status']='conerror';
    }

    
    else
    {
        $SELECT = "SELECT email From register Where email = ? Limit 1";
        $INSERT	= "INSERT Into register (fname, lname, email, phone, pass) values(?, ?, ?, ?, ?)";
        $response['status']='here';

        $stmt = $con->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        echo "$rnum";
        if($rnum==0)
        {
            $stmt->close();
            
            $stmt = $con->prepare($INSERT);
            $stmt->bind_param("isssis", $fname, $lname, $email, $phone, $pass);
            $stmt->execute();
            echo "New record inserted sucessfully";
            $response['status']='registered';
            $INSERT="INSERT INTO `result` (`email`, `s1`, `s2`, `s3`) VALUES ('$email', '-1', '-1', '-1')";
            
        }
        else
        {
            $response['status']='failed';
            echo "Someone already register using this email";
        }
        
        $stmt->close();
        $con->close();
            
        
    }
    echo json_encode($response);


  
   
/*
if(!empty($email) || !empty($pass) || !empty($fname) || !empty($lname) || !empty($phone) || !empty($phone))
{

}
else
{
echo "All field are required";
}
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods:POST, GET, OPTIONS, PUT');
header('Accept:application/json');

if(mysqli_connect_error()){
    echo('Failed to connect' mysqli_connect_error());
    die();    
}

$email=mysqli_real_escape_string($con, $_POST['email']);
$pass=mysqli_real_escape_string($con,  $_POST['pass']);
$fname=mysqli_real_escape_string($con, $_POST['fname']);
$lname=mysqli_real_escape_string($con, $_POST['lname']);
$phone=mysqli_real_escape_string($con, $_POST['phone']);


$query = "INSERT INTO `register` (`fname`, `lname`, `email`, `phone`, `pass`) VALUES ('$fname','$lname', '$email', '$phone', '$pass',NOW())";

$result= mysqli_query($con, $query);

if($result){
    
    $response['user']=$email;
    $response['status']='Registered';
       
}
else
{
    $response['status']='error';

}
echo json_encode($response);*/
