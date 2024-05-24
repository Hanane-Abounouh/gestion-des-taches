<?php
require "connection.php";

$email = $_POST['email'];
$pass = $_POST['password'];

session_start();

if(true){

    if($_POST['email'] ==  "" or $_POST['password'] == ""){
            // if this condition true we stay here and Show message
            header("location: login.php.?error=You must fill in the email and pass field");
            exit;
    }else{
        $Existing = $con-> prepare("SELECT * FROM users WHERE email = :email ");
        $Existing->execute([
            ':email'=>$email
        ]);
        $row = $Existing ->FETCH(PDO::FETCH_ASSOC);

        if($Existing->rowCount() == 0){
            // if this condition true we go to massage.html page 
            header("location: login.php.?error=this email is undefined!!!");

            exit;
        }else{

            echo "Hashed Password from Database:". $row["motDePasse"];
            echo "<br> Entered Password: ". $pass;
            echo"<br>";
            echo $email;
            $hashed_password = $row["motDePasse"];

            if($pass == $hashed_password) {
                // Password is correct
                echo "Password is correct";
                $_SESSION["nom"] = $row["nom"];
                $_SESSION["id_user"] = $row["id_user"];
                $_SESSION["id_role"] = $row["id_role"];
                header("location: Home.php");
            } else {
                // Password is incorrect
                header("location: login.php.?error=assword is incorrect!!!");
            }
            exit;
        }
}
}
?>
