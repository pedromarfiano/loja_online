<?php
session_start();
require_once('../config/db.php');

if(isset($_SESSION['login'])){
    header('location: ../index.php');
}
else{
    if(isset($_POST['btn'])){
        $email = $_POST['email'];
        $senha = md5($_POST['pass']);
        
        if(!isset($email) or $email == null){
            echo("email invalido");
        }
        else{
            if(!isset($senha) or $senha == null or strlen($senha) < 8){
                echo("senha invalida");
            }
            else{
                $sql = "SELECT * FROM tbusers WHERE email = '$email' and senha = '$senha';";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    $_SESSION['login'] = $row['id'];
                    header('location: ../index.php');
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
    <link rel="stylesheet" href="../public/css/cadastro.css">
    <title>LOGIN</title>
    
</head>
<body>
    <main class="container">
        <div class="img-container">
            <img src="https://img.freepik.com/fotos-premium/icone-de-botao-de-geometria-de-jogo-flutuando-na-ilustracao-3d-de-fundo-renderizando-o-resumo-do-papel-de-parede-para-o-jogador_42100-4243.jpg" alt="">
        </div>
        <div class="form-container">
            <h1>Bem vindo <span>Usuario</span></h1>

            <p>Entre agora para receber novidades e promoções de jogos e acessorios incriveis.</p>

            <form action="login.php" method="post" class="form-inputs">
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input-box">
                    <label for="pass">Senha</label>
                    <input type="password" name="pass" id="pass" required>
                </div>
                <div class="button-box">
                    <button type="submit" name="btn" value="true">login</button>
                </div>
            </form>
            <nav>
                <a href="#">Esqueci minha senha</a>
                <a href="cadastro.php">Cadastro</a>
            </nav>
        </div> 
    </main>
</body>
</html>