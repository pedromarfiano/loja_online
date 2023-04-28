<?php
session_start();
require_once('../config/db.php');

if(isset($_SESSION['login'])){
    header('../index.php');
}
else{
    if(isset($_POST['btn'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = md5($_POST['pass']);
        $cpf = $_POST['cpf'];

        if(!isset($email) or $email == null){
            echo("email invalido");
        }
        else{
            if(!isset($senha) or $senha == null){
                echo("senha invalida");
            }
            else{
                if(!isset($nome) or $nome == null){
                    echo("nome invalido");
                }
                else{
                    if(!isset($cpf) or $cpf == null){
                        echo("cpf invalido");
                    }
                    else{
                        $sql = "INSERT INTO tbusers(nome, email, cpf, senha) VALUES('$nome', '$email', '$cpf', '$senha');";
                        // $result = $db->query($sql)

                        if($db->query($sql)){
                            echo("cadastrado");
                        }
                    }
                }
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CADASTRO</title>
</head>
<body>
    <main class="container">
        <div class="img-container">
            <img src="" alt="">
        </div>
        <div class="form-container">
            <h1>Bem vindo <span>Usuario</span></h1>

            <p>Cadastre-se agora para receber novidades e promoções de jogos e acessorios incriveis.</p>

            <form action="cadastro.php" method="post">

                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="cpf">Cpf</label>
                <input type="text" name="cpf" id="cpf" required>
    
                <label for="pass">Senha</label>
                <input type="password" name="pass" id="pass" required>
    
                <button type="submit" name="btn" value="true">cadastrar</button>
            </form>
            <nav>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </main>
</body>
</html>