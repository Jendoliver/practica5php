<?php
/*
*
*   errors.php: Librería de errores de la aplicación
*
*/
require_once "constants.php";

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
function permisionDenied()
{
    global $index;
    alertError("No tienes acceso", $index);
}

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

function errorBadPassword()
{
    global $home;
    alertError("Contraseña actual incorrecta", $home);
}

function errorChangePassword()
{
    global $home;
    alertError("Las contraseñas no coinciden o has introducido la misma que ya tenías", $home);
}

function errorUserAlreadyExists()
{
    global $index;
    alertError("El usuario ya existe", $index);
}