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
        $tipo = $_POST['tipo'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];

        $formatos = array("png", "jpg", "jpeg", "gif", "jfif");
        $extencao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

        if(in_array($extencao, $formatos)){
            $pasta = '../public/img/produtos/';
            $temp = $_FILES['foto']['tmp_name'];
            //print_r($_FILES['foto']);
            $newname = uniqid().'.'.$extencao;

            if(move_uploaded_file($_FILES['foto']['tmp_name'], $pasta.$newname)){
                echo('upload feito com sucesso');
                $caminho = $pasta.$newname; 


                //$caminho = "../public/img/produtos/bomba.jpg";

                if(!isset($nome) or $nome == null){
                    echo('nome invalido');
                }
                else{
                    if(!isset($tipo) or $tipo == null){
                        echo("tipo invalido");
                    }
                    else{
                        if(!isset($descricao) or $descricao == null){
                            echo("descricao invalido");
                        }
                        else{
                            if(!isset($preco) or $preco == null){
                                echo("preco invalido");
                            }
                            else{
                                $sql = "INSERT INTO tbitens(nome, tipo, descricao, preco, img) VALUES('$nome', '$tipo', '$descricao', '$preco', '$caminho');";

                                if($db->query($sql) === TRUE){
                                    
                                }else {
                                    echo($db->error);
                                }
                            }
                        }
                    }
                }
                
            }
            else{
                echo("falha no upload");
            }
        }
        else{
            echo('formato negado');
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
    <title>CADASTRO DE PRODUTOS</title>
    <style>
        .container{
            text-align: center;
            font-size: large;
        }
        .container form{
            min-width: 500px;
            width: 50%;
            margin: auto;
            padding-top: 5%;
        }
        .container label{
            text-align: left;
            padding-left: 4%;
        }
        .container input{
            width: 80%;
            height: 1.2rem;

            border-radius: 10px;
        }
        .container button{
            position: absolute;
            bottom: 40%;
            right: 40%;

            width: 20%;
            height: 1.5rem;
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
        <div class="container">
            <form action="cadastro_produtos.php" method="post" enctype="multipart/form-data">

                <input type="file" name="foto" id="foto">

                <label for="tipo"><p>tipo</p></label>
                <select name="tipo" id="tipo_dropbox">
                    <option value="acessorios"><p>acessorios</p></option>
                    <option value="game playstation 3"><p>jogos de playstation 3</p></option>
                    <option value="game playstation 4"><p>jogos de playstation 4</p></option>
                    <option value="game playstation 5"><p>jogos de playstation 5</p></option>
                    <option value="videogames"><p>videogames</p></option>
                </select>

                <label for="nome"><p>nome</p></label>
                <input type="text" name="nome" id="nome">

                <label for="descricao"><p>descricao</p></label>
                <input type="text" name="descricao" id="descricao">

                <label for="preco"><p>preco</p></label>
                <input type="text" name="preco" id="preco">

                <button type="submit" name="btn" value="cadastrado"><p>cadastrar</p></button>
            </form>
        </div>
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