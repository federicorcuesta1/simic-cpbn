<?php 
    $mysqli=new mysqli("localhost", "root", "Ag241164", "simic");

    if($mysqli->connect_error){
        die('Error en la conexión'.$mysqli->connect_error);
    }
?>