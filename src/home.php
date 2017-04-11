<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>STUCOM ROYALE!</title>
</head>
<body>
    <?php session_start(); 
    if(empty($_SESSION["username"])) { // Are you logged in
        include "libs/errors.php";
        permisionDenied();
    } else {
    if(isset($_POST["changepass"])) // Password change maybe
    {
        require_once "libs/updates.php"; require_once "libs/selects.php";
        if($_POST["password-act"] == getPassword($_SESSION["username"]))
        {
            if($_POST["password"] == $_POST["password-confirm"] && $_POST["password"] != $_POST["password-act"])
                updatePassword($_SESSION["username"], $_POST["password"]);
            else
                errorChangePassword();
        }
        else
            errorBadLogin();
    }
    else
    {
    include "header.php"; ?>
    <h1 style="text-align: center;">¡Bienvenido, <?php echo $_SESSION["username"]; ?>!</h1>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- PERSONAL INFO -->
            <article id="info" class="well">
                <h2>Información personal</h2>
                <?php session_start(); extract($_SESSION); ?>
                <h3><span class="glyphicon glyphicon-user"></span> Nombre: <?php echo $username; ?></h3>
                <h3><span class="glyphicon glyphicon-flash"></span> Número de victorias: <?php echo $wins; ?></h3>
                <h3><span class="glyphicon glyphicon-star"></span> Nivel: <?php echo $level; ?></h3>
            </article>
            <!-- CHANGE PASSWORD -->
            <article id="changepass" class="well">
                <h2>Modificar contraseña</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="password-act"><span class="glyphicon glyphicon-chevron-right"></span> Contraseña actual:</label>
                        <input type="password" class="form-control" name="password-act" placeholder="007" maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><span class="glyphicon glyphicon-chevron-right"></span> Nueva contraseña:</label>
                        <input type="password" class="form-control" name="password" placeholder="007" maxlength="10" required>
                    </div>
                    <div id="confirm-register" class="form-group">
                        <label for="password-confirm"><span class="glyphicon glyphicon-chevron-right"></span> Confirmar nueva contraseña:</label>
                        <input type="password" class="form-control" name="password-confirm" placeholder="007" maxlength="10">
                    </div>
                    <input id="submit-type" type="submit" class="btn btn-primary btn-block" name="changepass" value="Cambiar contraseña">
                </form>
            </article>
            <!-- CARDS COLLECTION -->
            <article id="collection" class="well">
                <?php require "libs/cards.php"; ?>
                <h2>Tu colección de cartas</h2>
                <?php cardTable($username); ?>
            </article>
            <!-- BATTLE -->
            <article id="battle" class="well">
                <h2>¡BATALLA!</h2>
                <a href="battle.php" class="btn btn-block btn-danger">¡BATALLA!</a>
            </article>
        </div>
        <div class="col-md-1"></div>
    </div>
    <?php } if($_SESSION["usertype"] == 1) { ?> <!-- ADMIN SECTION -->
    
    <?php } }  ?>
</body>
</html>