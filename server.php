<?php

header('Access-Control-Allow-Origin: *');  

header('Content-Type: application/json');

if(!isset($_POST)) die();

session_start();

$response =[];

$con= mysqli_connect('localhost','root','root','test_site');

$username=mysqli_real_escape_string($con, $_POST['username']);
$password=mysqli_real_escape_string($con,$_POST['password']);

$query = "SELECT * FROM `register` WHERE email='$username' AND pass='$password'";

$result= mysqli_query($con, $query);

if(mysqli_num_rows($result)>0){
        
        $response['status']='loggedin';
        $response['user']=$username;
        $response['useruniqueid'] = md5(uniqid());
        $_SESSION['useruniqueid'] = $response['useruniqueid'];
}
else
{
    $response['status']='error';

}
echo json_encode($response);