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
    
}



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/base.css">
    <title>HOME</title>
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
        <?php
            if(!isset($_SESSION['login'])){
                echo('
                <nav>
                    <div>
                        <a href="login.php"><p>login</p></a>
                        <a href="cadastro.php"><p>cadastro</p></a>
                    </div>
                </nav>
                ');
            }
        
        ?>
    </header>


    <main>
        <div class="container">
            <h1>Resultado da pesquisa</h1>
            <?php
                $pesquisa = $_GET['search'];
                $sql = "SELECT id, img, nome, descricao, preco FROM tbitens WHERE nome LIKE '%$pesquisa%';";
        
                $result = $db->query($sql);
                if($result->num_rows > 0){
                    while($row_item = $result->fetch_assoc()) {
                        if(isset($_SESSION['login'])){
                            if($row['permicao'] == 'administrador' or $row['permicao'] == 'super administrador'){
                                echo('<li>
                                        <section>
                                            <img src="'.$row_item["img"].'" alt="capa do jogo">
                                            <h3>'.$row_item["nome"].'</h3>
                                        </section>
                                        <section>
                                            <p>'.$row_item["descricao"].'</p>
                                            <h2>'.$row_item["preco"].'</h2>
                                            <button><a href="itens.php?id='.$row_item["id"].'">comprar</a></button>
                                            <a href="alterar_produtos.php?id='.$row_item['id'].'"><p>alterar</p></a>
                                        </section>
                                    </li>');
                            }
                            else{
                                echo('<li>
                                        <section>
                                            <img src="'.$row_item["img"].'" alt="capa do jogo">
                                            <h3>'.$row_item["nome"].'</h3>
                                        </section>
                                        <section>
                                            <p>'.$row_item["descricao"].'</p>
                                            <h2>'.$row_item["preco"].'</h2>
                                            <button><a href="itens.php?id='.$row_item["id"].'">comprar</a></button>
                                        </section>
                                    </li>');
                            }
                        }
                    }
                    
                }

            ?>
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