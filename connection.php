<?php 
try{
    $con= new PDO('mysql:host=localhost;dbname=gestion-des-taches','root','');
}
catch (PDOExcepton $e){
    echo "<p>Erreur:".$e->getMessage();
    die() ;
}
?>