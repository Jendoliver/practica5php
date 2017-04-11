<?php
/*
*
*   selects.php: Librería de funciones SELECT
*
*/
require_once "bbdd.php";

function checkLogin($username, $password)
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT * FROM user WHERE username = '$username' AND password = '$password';");
    disconnect($con);
    return mysqli_num_rows($res) > 0;
}

/****** USERS ******/
function getPassword($username)
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT password FROM user WHERE username = '$username';");
    disconnect($con);
    $row = mysqli_fetch_row($res);
    return $row[0];
}

function getSession($username)
{
    session_start();
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT * FROM user WHERE username = '$username';");
    disconnect($con);
    $row = mysqli_fetch_assoc($res);
    extract($row);
    $_SESSION["username"] = $username;
    $_SESSION["wins"] = $wins;
    $_SESSION["level"] = $level;
}

function selectCards($username)
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT * FROM deck WHERE user = '$username';");
    $options = "";
    while($row = mysqli_fetch_assoc($res))
    {
        extract($row);
        $options .= "<option value='$card'>$card - Nivel: $level</option>";
    }
    echo $options;
    disconnect($con);
}