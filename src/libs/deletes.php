<?php
/*
*
*   deletes.php: Librería de funciones DELETE
*
*/
require_once "bbdd.php";

function userDeleted()
{
    global $home;
    alertError("Usuario borrado con éxito", $home);
}

function deleteUser($user)
{
    $con = connect($GLOBALS['db']);
    if(mysqli_query($con, "DELETE FROM user WHERE username = '$user';"))
    {
        disconnect($con);
        return 1;
    }
    disconnect(con);
    return 0;
}