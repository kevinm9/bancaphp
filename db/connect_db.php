<?php

try{
    $pdo = new PDO('mysql:host=localhost;dbname=ipos','root','');
    $pdo->exec("set names utf8");

}catch(PDOException $error){
    echo $error->getmessage();
}


?>