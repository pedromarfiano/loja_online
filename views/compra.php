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

if(isset($_GET['item'])){
    $sql = "SELECT * FROM tbitens WHERE id = '".$_GET['item']."';";
    $result = $db->query($sql);
    if($result->num_rows > 0){
        $row_item = $result->fetch_assoc();
    }

    $valor_itens = $row_item['preco'];
    $imposto = 15;
    $valor_total = $imposto + $valor_itens;
}



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/base.css">
    <title>COMPRA</title>
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
            <h1>Formas de pagamento</h1>
            <div class="container-pagamento">
                <ul>
                    <li>
                        <img src="" alt="">
                        <a href="">
                            <p>boleto</p>
                        </a>
                    </li>
                    <li>
                        <img src="" alt="">
                        <a href="">
                            <p>cartão</p>
                        </a>
                    </li>
                    <li>
                        <img src="" alt="">
                        <a href="">
                            <p>pix</p>
                        </a>
                    </li>
                    <li>
                        <img src="" alt=""> 
                        <a href="">
                            <p>paypal</p>
                        </a>
                    </li>
                </ul>                
            </div>
            <section>
                <div>
                <button>
                    <a href="">
                        <p>efetuar pagamento</p>
                    </a>
                </button>
                <p>Escolha um método de pagamento para continuar. 
                    Você ainda terá uma chance de revisar e alterar seu pedido antes que ele seja finalizado.</p>
                </div>
                <hr>
                <div>
                    <h2>Resumo do pedido</h2>
                    <div>
                        <p>Valor dos itens:</p> <p><? echo($valor_itens.'R$') ?></p>
                        <p>Impostos estimados a serem coletados:</p> <p><? echo($imposto .'%') ?></p>
                    </div>
                </div>
                <hr>
                <div>
                    <h1>Total a pagar<? echo($valor_total.'R$') ?></h1> 
                </div>
            </section>
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