<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
    <title>STUCOM ROYALE!</title>
</head>
<body>
    <?php if(!empty($_POST)) { require "libs/inserts.php";
        if(isset($_POST["login"]))
        {
            switch(checkLogin($_POST["username"], $_POST["password"]))
            {
                case 0: header("Location: $userhome"); break;
                case 1: header("Location: $adminhome"); break;
                case 2: errorBadLogin();
            }
        }
        else
        {
            if($_POST["password"] == $_POST["password-confirm"])
            {
                if(insertUser($_POST["username"], $_POST["password"]))
                    header("Location: $userhome");
                errorUserAlreadyExists();
            }
            else
                errorPasswordConfirm();
        }
        
    } else { ?>
    <div class="container-fluid">
        <?php include "header.php"; ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 id="form-type">Iniciar sesión</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" class="form-control" name="username" placeholder="clashofcode" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" placeholder="007" maxlength="10" required>
                    </div>
                    <div id="confirm-register" class="form-group"></div>
                    <input id="submit-type" type="submit" class="btn btn-success btn-block" name="login" value="¡Inicia sesión!">
                </form>
                <a id="change" href="#">¡Regístrate!</a>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <?php } ?>
</body>
</html>