<?php
/*
*
*   bbdd.php: Librería de funciones de gestión de la BBDD
*
*/
require "errors.php";

function connect($database)
{
    global $dburl, $dbuser, $dbpass;
    $con = mysqli_connect($dburl, $dbuser, $dbpass, $database) or
        die("No se ha podido conectar a la BBDD");
    mysqli_set_charset($con, "utf8");
    return $con;
}

function disconnect($db)
{
    mysqli_close($db);
}

function createTable($res) // Crea una tabla genérica automáticamente con el resultado de una query
{
    if($row = mysqli_fetch_assoc($res)) //comprobamos que hay algo para evitar warning
    {
        $table = "<table class='table table-hover'>"; // ese bootstrap joder
        $table .= "<thead>";
        foreach($row as $key => $value) // header tabla
        {
            switch($key)
            {
                case "name": $table .= "<th>Nombre</th>"; break;
                case "type": $table .= "<th>Tipo</th>"; break;
                case "ability": $table .= "<th>Habilidad</th>"; break;
                case "attack": $table .= "<th>Ataque</th>"; break;
                case "defense": $table .= "<th>Defensa</th>"; break;
                case "speed": $table .= "<th>Velocidad</th>"; break;
                case "life": $table .= "<th>Vida</th>"; break;
                case "level": $table .= "<th>Nivel</th>"; break;
                case "trainer": $table .= "<th>Entrenador</th>"; break;
                case "pokeballs": $table .= "<th>Pokéballs</th>"; break;
                case "potions": $table .= "<th>Pociones</th>"; break;
                case "points": $table .= "<th>Puntos</th>"; break;
                case "winner": $table .= "<th>Pokémon</th>"; break;
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
    else
        errorNoResults();
}