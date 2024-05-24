<?php
require 'inscription.php';
$con=new crud('gestion-des-taches','localhost','root','');
if(isset($_POST['sign-button'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $id_role=2;
    $confirmation_password=$_POST['confirmation_password'];

    if(!empty($_POST['name'])  && !empty($_POST['email']) && !empty($_POST['password']) ) {
        if($password == $confirmation_password) {
            $con->insertData($name,$email,$password,$id_role);
            echo "Register successful!";
        } else {
            echo "Passwords do not match!";
        }
    } else {
        echo "Please fill in all required fields!";
    }
}
?>