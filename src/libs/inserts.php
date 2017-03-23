<?php
/*
*
*   inserts.php: Librería de funciones INSERT
*
*/
require "selects.php";

function insertUser($username, $password)
{
    $con = connect($GLOBALS['db']);
    $insert = "INSERT INTO user VALUES('$username', '$password', 0, 0, 1);";
    if(mysqli_query($con, $insert))
    {
        disconnect($con);
        return 1;
    }
    else
        errorQuery($con);
    disconnect($con);
    return 0;
}