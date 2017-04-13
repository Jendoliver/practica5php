<?php
/*
*
*   cards.php: Librería de funciones relacionadas con las cartas del usuario
*
*/
require_once "bbdd.php";
require_once "inserts.php";

/******* GETTERS *******/
function getAllCards() // Devuelve todos los `name` de las cartas registradas en la BBDD en forma de array
{
    $cards = array();
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT name FROM card;");
    while($row = mysqli_fetch_row($res))
        $cards[] = $row[0];
    disconnect($con);
    return $cards;
}

function getNCards() // Devuelve el numero de cartas
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT name FROM card;");
    disconnect($con);
    return mysqli_num_rows($res);
}

function getCardsFrom($user)
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT card FROM deck WHERE user = '$user';");
    disconnect($con);
    return mysqli_fetch_row($res);
}

function getCardInfo($cardname) // Devuelve la información de una carta en forma de array
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT * FROM card WHERE name = '$cardname';");
    disconnect($con);
    return mysqli_fetch_assoc($res);
}

function getCardLvl($cardname, $username) // Devuelve el nivel de una carta
{
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT level FROM deck WHERE user = '$username' AND card = '$cardname';");
    $row = mysqli_fetch_row($res);
    return $row[2];
}

function getCardStats($cardname, $username) // Devuelve la info de la carta de un usuario (afecta lvl usuario)
{
    global $HP_RATIO, $DMG_RATIO;
    $stats = getCardInfo($cardname);
    $lvl = getCardLvl($cardname, $username);
    $stats["hitpoints"] += $lvl*$HP_RATIO;
    $stats["damage"] += $lvl*$DMG_RATIO;
    return $stats;
}

/******* METHODS *******/
function giveCardTo($card, $user) // Da una carta a un usuario e imprime sus características actuales
{
    $cardinfo = getCardInfo($card);
    extract($cardinfo);
    if(insertNewCardTo($card, $user)) // Si el usuario no tiene la carta
        $message = "¡NUEVA CARTA AÑADIDA A TU COLECCIÓN!\n";
    else
    {
        global $HP_RATIO, $DMG_RATIO;
        require_once "updates.php";
        lvlUpCard($card, $user);
        $lvl = getCardLvl($card, $user);
        $hitpoints += $lvl*$HP_RATIO;
        $damage += $lvl*$DMG_RATIO;
        $message = "¡NUEVO NIVEL DE CARTA!\n";
    }
    $message .= "Nombre: $name\n
                Tipo: $type\n
                Rareza: $rarity\n
                Vida: $hitpoints\n
                Daño: $damage\n
                Coste de elixir: $cost";
    return $message;
}

function reward($user)
{
    global $REWARD;
    $cards = getAllCards();
    $messages = array();
    for($i=0; $i<$REWARD; $i++)
    {
        $cardgiven = rand(0, getNCards()-1);
        $messages[] = giveCardTo($cards[$cardgiven], $user);
    }
    return $messages;
}

function cardTable($user)
{
    global $HP_RATIO, $DMG_RATIO;
    $con = connect($GLOBALS['db']);
    $res = mysqli_query($con, "SELECT card, level FROM deck WHERE user = '$user';");
    $row = mysqli_fetch_assoc($res);
    $table = "<table class='table table-hover'>"; // ese bootstrap joder
    $table .= "<thead>";
    foreach($row as $key => $value) // header tabla
    {
        switch($key)
        {
            case "card": $table .= "<th>Nombre</th>"; break;
            case "level": $table .= "<th>Nivel</th>"; break;
            default: $table .= "<th>$key</th>";
        }
    }
    $table .= "<th>Tipo</th><th>Calidad</th><th>Coste</th><th>Vida</th><th>Daño</th></thead><tbody>"; // cierre del header y apertura del body

    do // llenar tabla con el contenido de la query
    {
        $table .= "<tr>"; // principio de fila
        foreach($row as $key => $value) // llenamos una fila
            $table .= "<td>$value</td>";
        $cardinfo = getCardInfo($row["card"]); extract($cardinfo);
        $hitpoints += $row["level"]*$HP_RATIO;
        $damage += $row["level"]*$DMG_RATIO;
        $table .= "<td>$type</td><td>$rarity</td><td>$cost</td><td>$hitpoints</td><td>$damage</td></tr>";
    } while ($row = mysqli_fetch_assoc($res));
    $table .= "</tbody></table>";
    echo $table;
}

?>