<?php
/*
*
*   updates.php: Librería de funciones UPDATE
*
*/
require_once "bbdd.php";
function updateSuccessful($newlocation)
{
    echo "<script type='text/javascript'>
    alert('Actualización exitosa');
    window.location = '$newlocation';
    </script>";
}

function lvlUpCard($card, $user)
{
    $con = connect($GLOBALS['db']);
    mysqli_query($con, "UPDATE deck SET level = level + 1 WHERE user = '$user' AND card = '$card';");
    disconnect($con);
    return 1;
}

function lvlUpUser($user)
{
    $con = connect($GLOBALS['db']);
    mysqli_query($con, "UPDATE user SET level = level + 1 WHERE username = '$user';");
    disconnect($con);
    return 1;
}

function updatePassword($username, $newpass)
{
    global $home;
    $con = connect($GLOBALS['db']);
    mysqli_query($con, "UPDATE user SET password = '$newpass' WHERE username = '$username';");
    disconnect($con);
    updateSuccessful($home);
    return 1;
}

function updateWins($username)
{
    $con = connect($GLOBALS['db']);
    mysqli_query($con, "UPDATE user SET wins = wins + 1 WHERE username = '$username';");
    disconnect($con);
    return 1;
}