<?php
/*
*
*   errors.php: Librería de errores de la aplicación
*
*/
require "constants.php";

/********** MODELOS DE ERROR **********/
function alertError($message, $newlocation)
{
    echo "<script type='text/javascript'>
    alert('$message');
    window.location = '$newlocation';
    </script>";
}

/********** ERRORES GRAVES **********/
function errorQuery($con)
{
    echo "<h1>ERROR EN LA CONSULTA: ".mysqli_error($con)."</h1>";
}

/********** ERRORES COMUNES **********/
function errorBadLogin()
{
    global $index;
    alertError("Credenciales incorrectas", $index);
}

function errorPasswordConfirm()
{
    global $index;
    alertError("Las contraseñas no coinciden", $index);
}

function errorUserAlreadyExists()
{
    global $index;
    alertError("El usuario ya existe", $index);
}