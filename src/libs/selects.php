<?php
/*
*
*   selects.php: Librería de funciones SELECT
*
*/
require "bbdd.php";

function checkLogin($username, $password)
{
    $con = connect($GLOBALS['db']);
    if($res = mysqli_query($con, "SELECT * FROM user WHERE username = '$username' AND password = '$password';"))
    {
        disconnect($con);
        errorBadLogin();
        if(mysqli_num_rows($res))
        {
            $row = mysqli_fetch_assoc($res);
            return $row["type"];
        }
        else
            return 2; // No existe
    }
    else
        errorQuery($con);
    disconnect($con);
}