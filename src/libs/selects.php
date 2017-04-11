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
    $_SESSION["usertype"] = $type;
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

function selectAllCards()
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT name FROM card;");
    $options = "";
    while($row = mysqli_fetch_assoc($res))
    {
        extract($row);
        $options .= "<option value='$name'>$name</option>";
    }
    echo $options;
    disconnect($con);
}

function selectAllUsers()
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT username FROM user;");
    $options = "";
    while($row = mysqli_fetch_assoc($res))
    {
        extract($row);
        $options .= "<option value='$username'>$username</option>";
    }
    echo $options;
    disconnect($con);
}

function tableBestPlayers()
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT username, wins, level FROM user ORDER BY level DESC, wins DESC LIMIT 10;");
    $row = mysqli_fetch_assoc($res);
    $table = "<table class='table table-hover'>"; // ese bootstrap joder
    $table .= "<thead>";
    foreach($row as $key => $value) // header tabla
    {
        switch($key)
        {
            case "username": $table .= "<th>Nombre</th>"; break;
            case "wins": $table .= "<th>Victorias</th>"; break;
            case "level": $table .= "<th>Nivel</th>"; break;
            default: $table .= "<th>$key</th>";
        }
    }
    $table .= "</thead><tbody>"; // cierre del header y apertura del body

    do // llenar tabla con el contenido de la query
    {
        $table .= "<tr>"; // principio de fila
        foreach($row as $key => $value) // llenamos una fila
            $table .= "<td>$value</td>";
        $table .= "</tr>";
    } while ($row = mysqli_fetch_assoc($res));
    $table .= "</tbody></table>";
    echo $table;
}