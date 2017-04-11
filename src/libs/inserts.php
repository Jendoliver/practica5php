<?php
/*
*
*   inserts.php: Librería de funciones INSERT
*
*/
require_once "selects.php";

/******* TABLA USER *******/
function insertUser($username, $password)
{
    $con = connect($GLOBALS['db']);
    $insert = "INSERT INTO user VALUES('$username', '$password', 0, 0, 1);";
    if(mysqli_query($con, $insert))
    {
        disconnect($con);
        return 1;
    }
    errorQuery($con);
    disconnect($con);
    return 0;
}

/******* TABLA DECK *******/
function insertNewCardTo($card, $user)
{
    $con = connect($GLOBALS['db']);
    $insert = "INSERT INTO deck VALUES('$user', '$card', 1);";
    if(mysqli_query($con, $insert))
    {
        disconnect($con);
        return 1;
    }
    disconnect($con);
    return 0;
}