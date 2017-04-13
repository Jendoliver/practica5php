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

function giveCardAdmin($card, $user)
{
    if(insertNewCardTo($card, $user))
        return 1;
    else
    {
        require_once "updates.php";
        lvlUpCard($card, $user);
        return 1;
    }
    return 0;
    
}
function cardGiven()
{
    global $home;
    alertError("Carta entregada con éxito", $home);
}

/****** TABLA CARD ******/
function cardCreated()
{
    global $home;
    alertError("Carta creada con éxito", $home);
}

function insertCard($name, $type, $rarity, $hp, $dmg, $cost)
{
    $con = connect($GLOBALS['db']);
    $insert = "INSERT INTO card VALUES('$name', '$type', '$rarity', $hp, $dmg, $cost);";
    if(mysqli_query($con, $insert))
    {
        disconnect($con);
        return 1;
    }
    disconnect($con);
    return 0;
}