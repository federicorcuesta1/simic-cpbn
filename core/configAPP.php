<?php
    const SERVER= "localhost:8080";     //AQUI VA EL SERVIDOR EN ESTE CASO ES EL SERVIDOR LOCAL PERO PUEDE SER EL NOMBRE DE NUESTRO PROVEEDOR
    const DB= "simic";  //AQUI DEBE SER EL NOMBRE DE LA BASE DE DATOS QUE VAMOS A UTILIZAR.
    const USER= "root";     //aqui va el usuario como estoy utilizando xampp por defecto el usuario es este.
    const PASS= "Ag241164"; //xampp no tiene una contraseña definida pero aqui debemos colocar la contraseña suministrada por nuestro proveedor de servicio.

    const SGBD="mysql:host8080=".SERVER.";dbname=".DB;

    const METHOD= "AES-256-CBC";
    const SECRET_KEY= '$SIMIC@2021';
    const SECRET_IV= '161200';