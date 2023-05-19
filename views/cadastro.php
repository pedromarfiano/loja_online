<?php
session_start();
require_once('../config/db.php');

if(isset($_SESSION['login'])){
    header('location: ../index.php');
}
else{
    if(isset($_POST['btn'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = md5($_POST['pass']);
        $cpf = $_POST['cpf'];
        $img = "https://api.dicebear.com/5.x/initials/svg?seed=". $nome;

        $sql = "SELECT * FROM tbusers WHERE email = '$email';";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            echo('<div class="alert-danger"><p>email já logado</p></div>');
        }
        else{
            if(!isset($email) or $email == null or strlen($email) > 140){
                echo("email invalido");
            }
            else{
                if(!isset($senha) or $senha == null or strlen($senha) < 8){
                    echo("senha invalida");
                }
                else{
                    if(!isset($nome) or $nome == null or strlen($nome) > 120){
                        echo("nome invalido");
                    }
                    else{
                        if(!isset($cpf) or $cpf == null or strlen($cpf) != 11){
                            echo("cpf invalido");
                        }
                        else{
                            $sql = "INSERT INTO tbusers(nome, email, cpf, senha, img) VALUES('$nome', '$email', '$cpf', '$senha', '$img');";

                            if($db->query($sql)){
                                echo("cadastrado");
                                $sql = "SELECT * FROM tbusers WHERE email = '$email' and senha = '$senha';";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();

                                    $_SESSION['login'] = $row['id'];
                                    header('location: ../index.php');
                                }
                            }
                            else {
                                echo($db->error);
                            }
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
    <link rel="stylesheet" href="../public/css/cadastro.css">
    <title>CADASTRO</title>
</head>
<body>
    <main class="container">
        <div class="img-container">
            <img src="https://img.freepik.com/fotos-premium/icone-de-botao-de-geometria-de-jogo-flutuando-na-ilustracao-3d-de-fundo-renderizando-o-resumo-do-papel-de-parede-para-o-jogador_42100-4243.jpg" alt="">
        </div>
        <div class="form-container">
            <h1>Bem vindo <span>Usuario</span></h1>

            <p>Cadastre-se agora para receber novidades e promoções de jogos e acessorios incriveis.</p>

            <form action="cadastro.php" method="post" class="form-inputs">

                <div class="input-box">
                    <input type="text" name="nome" id="nome" required>
                    <label for="nome">Nome</label>
                </div>
                <div class="input-box">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                </div>
                <div class="input-box">
                <label for="cpf">Cpf</label>
                <input type="text" name="cpf" id="cpf" required>
                </div>
                <div class="input-box">
                <label for="pass">Senha</label>
                <input type="password" name="pass" id="pass" required>
                </div>
                <div class="button-box">
                <button type="submit" name="btn" value="true">cadastrar</button>
                </div>
            </form>
            <nav>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </main>
</body>
</html>