<?php
/*
*
*   cards.php: Librería de funciones relacionadas con las cartas del usuario
*
*/
require_once "bbdd.php";

function getAllCards() // Devuelve todos los `name` de las cartas registradas en la BBDD en forma de array
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT name FROM card;");
    disconnect($con);
    return mysqli_fetch_row($res);
}

function getCardsFrom($user)
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT card FROM deck WHERE user = '$user';");
    disconnect($con);
    return mysqli_fetch_row($res);
}

function firstReward($user)
{
    
}