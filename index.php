<?php
session_start();
require('./config/db.php');

if(isset($_SESSION['login'])){

    $id = $_SESSION['login'];
    $sql = "SELECT * FROM tbusers WHERE users_id = "."$id".";";
    $result = $db->query($sql);

    if($result->num_rows > 0){
        echo("logado!");
    }
}



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
</head>
<body>
    <a href="views/login.php">login</a>
    <a href="views/cadastro.php">cadastro</a>
</body>
</html>