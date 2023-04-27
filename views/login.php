<?php
require_once('config/db.php');

if(isset($_SESSION['login'])){
    header('../index.php');
}



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<body>
    <main class="container">
        <div class="img-container">
            <img src="" alt="">
        </div>
        <div class="form-container">
            <h1>Bem vindo <span>Usuario</span></h1>

            <p>Entre agora para receber novidades e promoções de jogos e acessorios incriveis.</p>

            <form action="login.php" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
    
                <label for="pass">Senha</label>
                <input type="password" name="pass" id="pass">
    
                <button type="submit">login</button>
            </form>
            <nav>
                <a href="#">Esqueci minha senha</a>
                <a href="cadastro.php">Cadastro</a>
            </nav>
        </div>
    </main>
</body>
</html>