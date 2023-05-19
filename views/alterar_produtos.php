<?php
session_start();
require('../config/db.php');

if(isset($_SESSION['login'])){

    $id = $_SESSION['login'];
    $sql = "SELECT * FROM tbusers WHERE id = '$id';";
    $result = $db->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        if(isset($_GET['btn'])){
            $id = $_GET['btn'];
        }
        else{
            $id = $_GET['id'];
        }
        $sql = "SELECT * FROM tbitens WHERE id = '$id';";
        $result = $db->query($sql);
        if($result->num_rows > 0){
            $row_item = $result->fetch_assoc();
        }

        if($row['permicao'] != 'administrador' and $row['permicao'] != 'super administrador'){
            header("Location: ../index.php");
        }
    }


    if(isset($_GET['btn'])){
        $nome = $_GET['nome'];
        $tipo = $_GET['tipo'];
        $descricao = $_GET['descricao'];
        $preco = $_GET['preco'];

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
                        $sql = "UPDATE tbitens SET nome = '$nome', tipo = '$tipo', descricao = '$descricao', preco = '$preco' WHERE id = '$id';";

                        if($db->query($sql) === TRUE){
                            echo('<script>alert("item alterado")</script>');
                        }else {
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
    <title>ALTERAR PRODUTOS</title>
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
                <a href="cadastro_produtos.php">
                    <p>cadastro de produtos</p>
                </a>    
            </div>
        </nav>
    </header>


    <main>
        <div class="container">
            <form action="alterar_produtos.php" method="get">
                <label for="tipo"><p>tipo</p></label>
                <select name="tipo" id="tipo_dropbox" value="<?php echo($row_item['tipo']);?>">
                    <option value="acessorios"><p>acessorios</p></option>
                    <option value="game playstation 3"><p>jogos de playstation 3</p></option>
                    <option value="game playstation 4"><p>jogos de playstation 4</p></option>
                    <option value="game playstation 5"><p>jogos de playstation 5</p></option>
                    <option value="videogames"><p>videogames</p></option>
                </select>

                <label for="nome"><p>nome</p></label>
                <input type="text" name="nome" id="nome" value="<?php echo($row_item['nome']);?>">

                <label for="descricao"><p>descricao</p></label>
                <input type="text" name="descricao" id="descricao" value="<?php echo($row_item['descricao']);?>">

                <label for="preco"><p>preco</p></label>
                <input type="text" name="preco" id="preco" value="<?php echo($row_item['preco']);?>">

                <button type="submit" name="btn" value="<?php echo($row_item['id']);?>"><p>alterar</p></button>
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