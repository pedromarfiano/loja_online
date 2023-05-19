<?php
session_start();
require('../config/db.php');

if(isset($_SESSION['login'])){

    $id = $_SESSION['login'];
    $sql = "SELECT * FROM tbusers WHERE id = '$id';";
    $result = $db->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }

    if(isset($_POST['btn'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = md5($_POST['pass']);
        $cpf = $_POST['cpf'];

        if(isset($_FILES['foto'])){
            $formatos = array("png", "jpg", "jpeg", "gif", "jfif");
            $extencao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

            if(in_array($extencao, $formatos)){
                $pasta = '../public/img/usuarios/';
                $temp = $_FILES['foto']['tmp_name'];
                //print_r($_FILES['foto']);
                $newname = uniqid().'.'.$extencao;

                if(move_uploaded_file($_FILES['foto']['tmp_name'], $pasta.$newname)){
                    echo('upload feito com sucesso');
                    $caminho = $pasta.$newname;
                }
                else{
                    echo("falha no upload");
                }
            }
            else{
                echo('formato negado');
            } 
        }

        

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
                            if(isset($_FILES['foto']))
                                $sql = "UPDATE tbusers SET img='$caminho', nome='$nome', email='$email', cpf='$cpf', senha='$senha' WHERE id = '". $row["id"] ."';";
                            else
                                $sql = "UPDATE tbusers SET nome='$nome', email='$email', cpf='$cpf', senha='$senha' WHERE id = '". $row["id"] ."';";

                            if($db->query($sql)){
                                $sql = "SELECT * FROM tbusers WHERE email = '$email' and senha = '$senha';";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();

                                    $_SESSION['login'] = $row['id'];
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
else{
    header("Location: ../index.php");
}



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/base.css">
    <title>ACESSORIOS</title>
    <style>
        #myaccont form{
            min-width: 500px;
            width: 50%;
            margin: auto;
        }
        #myaccont button{
            width: 20%;
            height: 1.4rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="menu">
        <div class="logo"><a href="../index.php"><img src="https://i.pinimg.com/originals/f2/93/d4/f293d4ebcffcbfb9395ac8ca728c23ec.png" alt="logo"></a></div>
            <div class="search-bar">
                <form action="pesquisa.php" method="get">
                    <input type="search" name="search" id="search-bar" placerouder="Pesquisar...">
                    <button type="submit">pesquisar</button>
                </form>
            </div>
            <div class="user-accont">
                <?php 
                    if(isset($_SESSION['login'])){
                        echo('
                        <img class="img-accont" src="'.$row['img'].'" alt="imagem de usuario">
                        <div class="accont">
                            <img src="'.$row['img'].'" alt="imagem de usuario">
                            <ul>
                                <li><a href="myaccont.php"><p>minha conta</p></a></li>
                                <li><a href="carrinho.php"><p>carinho</p></a></li>
                                <li><a href="../config/sair.php"><p>sair</p></a></li>
                            </ul>
                        </div>');
                    } else{
                        echo('<img src="https://cdn-icons-png.flaticon.com/512/1946/1946429.png" alt="imagem de usuario">');
                    }
                ?>
            </div>
        </div>
        <nav>
            <div>
                <a href="novidades.php">
                    <p>novidades</p>
                </a>
                <a href="acessorios.php">
                    <p>acessorios</p>
                </a>
                <a href="jogos.php">
                    <p>jogos</p>
                </a>
                <?php
                    if(isset($_SESSION['login'])){
                    if($row['permicao'] == 'administrador' or $row['permicao'] == 'super administrador'){
                        echo('
                        <a href="cadastro_produtos.php">
                            <p>cadastro de produtos</p>
                        </a>
                        ');
                    }}
                ?>
            </div>
        </nav>
    </header>


    <main>
        <section id="myaccont">
        <form action="myaccont.php" method="post" class="form-inputs" enctype="multipart/form-data">
            <input type="file" name="foto" id="foto">            
            <div class="input-box">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" <?php echo('value="'.$row["nome"].'"') ?>>
            </div>
            <div class="input-box">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" <?php echo('value="'.$row["email"].'"') ?>>
            </div>
            <div class="input-box">
                 <label for="cpf">Cpf</label>
                <input type="text" name="cpf" id="cpf" <?php echo('value="'.$row["cpf"].'"') ?>>
            </div>
            <div class="input-box">
                 <label for="pass">Senha</label>
                <input type="password" name="pass" id="pass" <?php echo('value="'.$row["senha"].'"') ?>>
            </div>
            <div class="button-box">
                <button type="submit" name="btn" value="true">alterar</button>
            </div>
        </form>
        </section>
    </main>
    <footer>
        <div class="redes-sociais">
            <a href="">
                <p>instagram</p>
            </a>
            <a href="">
                <p>linkedin</p>
            </a>
            <a href="">
                <p>github</p>
            </a>
        </div>
        <div>
            <p>numero</p>
            <p>(88) 98888-8888</p>
        </div>
    </footer>
</body>
<script src="../public/js/menu_mobile.js"></script>
</html>