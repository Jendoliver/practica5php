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
    <?php session_start(); require "libs/cards.php";
    if(empty($_SESSION["username"]) || $_SESSION["reward"] == 1) {
        include "libs/errors.php";
        permisionDenied();
    } else { $chest = createChest(3); ?>
    <h1 style="text-align: center;">¡Es un cofre!</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="well">
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="well">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-2"><a href="home.php" class="btn btn-success">Volver a mi perfil</a></div>
            <div class="col-md-5"></div>
        </div>
    </div>
    <?php } ?>
</body>
</html>