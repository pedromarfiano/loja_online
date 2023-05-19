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
else{
    header("Location: login.php");
}

if(isset($_GET['adicionar'])){

    $sql = "SELECT * FROM tbitens WHERE id = '". $_GET['adicionar']. "'";
    $result = $db->query($sql);

    if($result->num_rows > 0){
        $row_car = $result->fetch_assoc();

        if(!empty($_SESSION['carrinho'])){
            for($i = 0; $i <= count($_SESSION['carrinho']) -4; $i++)
            {
                if($_SESSION['carrinho'][$i]['nome'] == $row_car['nome']){
                    echo('este item já esta no carrinho');
                    break;
                }
                else{
                    array_push(
                        $_SESSION['carrinho'],
                        array(
                            'id' => $row_car['id'],
                            'nome' => $row_car['nome'],
                            'descricao' => $row_car['descricao'],
                            'preco' => $row_car['preco'],
                            'img' => $row_car['img'],
                            'quantidade' => 1
                        )
                    );
                    break;
                }
            }
            
        }else{
            $_SESSION['carrinho'] = array(
                'id' => null,
                'nome' => null,
                'descricao' => null,
                'preco' => null,
                'img' => null,
                'quantidade' => null
            );
            array_push(
                $_SESSION['carrinho'],
                array(
                    'id' => $row_car['id'],
                    'nome' => $row_car['nome'],
                    'descricao' => $row_car['descricao'],
                    'preco' => $row_car['preco'],
                    'img' => $row_car['img'],
                    'quantidade' => 1
                )
            );
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
    </header>


    <main>
        <div class="container">
            <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbitens WHERE id = '$id';";
                $result = $db->query($sql);

                if($result->num_rows > 0){

                    while($row = $result->fetch_assoc()){
                        echo('
                        <div>
                            <h1>'.$row["nome"].'</h1>
                            <img src="'.$row["img"].'" alt="imagem do jogo">
                            <h3>'.$row["tipo"].'<h3>
                            <p>'.$row["descricao"].'</p>
                            <h2>'.$row["preco"].'<h2>
                        </div>

                        <button class="btn_comprar"><a href="compra.php?item='.$row['id'].'"><p>comprar</p></a></button>
                        <button class="btn_add_car"><a href="?adicionar='.$row['id'].'&id='.$row['id'].'"><p>adicionar ao carrinho</p></a></button>
                            
                        ');
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