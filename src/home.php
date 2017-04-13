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
    } else { require_once "libs/updates.php"; require_once "libs/selects.php"; require_once "libs/inserts.php"; require_once "libs/deletes.php";
    if(isset($_POST["changepass"])) // Password change maybe
    {
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
    else if(isset($_POST["newcard"])) // Newcard u admint
    {
        extract($_POST);
        if(insertCard($name, $type, $rarity, $hp, $dmg, $cost)) // TODO
            cardCreated();
        errorCardAlreadyExists();
    }
    else if(isset($_POST["deluser"])) // Dewa
    {
        extract($_POST);
        if(deleteUser($user)) // TODO
            userDeleted();
    }
    else if(isset($_POST["givecard"])) // Noice
    {
        extract($_POST);
        if(giveCardAdmin($card, $user))
            cardGiven();
    }
    else
    {
    getSession($_SESSION["username"]);
    include "header.php"; ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><h1 style="text-align: center;">¡Bienvenido, <?php echo $_SESSION["username"]; ?>!</h1></div>
        <div class="col-md-4">
            <div class="col-md-6"></div>
            <div class="col-md-3"><a href="logout.php" class="btn btn-block btn-danger">Cerrar sesión</a></div>
            <div class="col-md-3"></div>
        </div>
    </div>
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
    <?php } if($_SESSION["usertype"] == 1) { ?> <!-- ADMIN SECTION -->
            <!-- CARD ADDITION -->
            <article id="newcard" class="well">
                <h2>Crear nuevas cartas</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name"><span class="glyphicon glyphicon-chevron-right"></span> Nombre de la carta:</label>
                        <input type="text" class="form-control" name="name" maxlength="30" required>
                    </div>
                    <div class="form-group">
                        <label for="type"><span class="glyphicon glyphicon-chevron-right"></span> Tipo de carta:</label>
                        <select class="form-control" name="type" required>
                            <option value="Tropa">Tropa</option>
                            <option value="Estructura">Estructura</option>
                            <option value="Hechizo">Hechizo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rarity"><span class="glyphicon glyphicon-chevron-right"></span> Calidad de la carta:</label>
                        <select class="form-control" name="rarity" required>
                            <option value="Común">Común</option>
                            <option value="Especial">Especial</option>
                            <option value="Épica">Épica</option>
                            <option value="Legendaria">Legendaria</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hp"><span class="glyphicon glyphicon-chevron-right"></span> Vida de la carta:</label>
                        <input type="number" class="form-control" name="hp" min="1" max="20" required>
                    </div>
                    <div class="form-group">
                        <label for="dmg"><span class="glyphicon glyphicon-chevron-right"></span> Daño de la carta:</label>
                        <input type="number" class="form-control" name="dmg" min="1" max="20" required>
                    </div>
                    <div class="form-group">
                        <label for="cost"><span class="glyphicon glyphicon-chevron-right"></span> Coste de la carta:</label>
                        <input type="number" class="form-control" name="cost" min="1" max="10" required>
                    </div>
                    <input id="submit-type" type="submit" class="btn btn-primary btn-block" name="newcard" value="¡Crear carta!">
                </form>
            </article>
            <!-- BEST PLAYERS -->
            <article id="bestplayers" class="well">
                <h2>Los mejores jugadores</h2>
                <?php tableBestPlayers(); ?>
            </article>
            <!-- DELETE USER -->
            <article id="deleteuser" class="well">
                <h2>Eliminar a un usuario</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name"><span class="glyphicon glyphicon-chevron-right"></span> Nombre del usuario:</label>
                        <select class="form-control" name="user">
                            <?php selectAllUsers(); ?>
                        </select>
                    </div>
                    <input id="submit-type" type="submit" class="btn btn-danger btn-block" name="deluser" value="ELIMINAR USUARIO">
                </form>
            </article>
            <!-- GIVE CARD -->
            <article id="givecard" class="well">
                <h2>Dar carta a un jugador</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name"><span class="glyphicon glyphicon-chevron-right"></span> Nombre del usuario:</label>
                        <select class="form-control" name="user">
                            <?php selectAllUsers(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name"><span class="glyphicon glyphicon-chevron-right"></span> Nombre de la carta:</label>
                        <select class="form-control" name="card">
                            <?php selectAllCards(); ?>
                        </select>
                    </div>
                    <input id="submit-type" type="submit" class="btn btn-success btn-block" name="givecard" value="¡Regalar carta!">
                </form>
            </article>
    <?php } ?> </div><div class="col-md-1"></div></div> <?php }  ?>
</body>
</html>