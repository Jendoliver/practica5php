<?php
/*
*
*   bbdd.php: Librería de funciones de gestión de la BBDD
*
*/
require "errors.php";

function connect($database)
{
    global $dburl, $dbuser, $dbpass;
    $con = mysqli_connect($dburl, $dbuser, $dbpass, $database) or
        die("No se ha podido conectar a la BBDD");
    mysqli_set_charset($con, "utf8");
    return $con;
}

function disconnect($db)
{
    mysqli_close($db);
}