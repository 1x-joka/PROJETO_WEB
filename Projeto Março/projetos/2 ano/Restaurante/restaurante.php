<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Total de Gasto</title>
    <style>
        body {
            display: flex; /* container flexível, faz com que seus elementos sejam organizados em linha e coluna */
            justify-content: center; /* Alinha os elementos horizontalmente no centro */
            align-items: center; /* Alinha os itens */
            height: 100vh; /* 100vh = 100% da altura da tela */
            background-color: white;
            font-family: Arial, sans-serif;
        }

        .caixa {
            display: flex;
            flex-direction: column; /* Empilhados na vertical */
            padding: 30px; /* Espaça de 30px de todos os lados da página */
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            gap: 10px; /* Espaça entre os itens */
        }

        .caixa h2 {
            margin: 0;
            color: #333;
        }

        .caixa p {
            margin: 0;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="caixa">
    <h2>Resumo da Compra</h2>

    <?php
    // Receber as quantidades
    $refriQuantidade = $_GET["a"]; // $_GET pega o valor da variável que está entre os colchetes e aspas
    $sucoQuantidade = $_GET["b"];
    $saladaQuantidade = $_GET["c"];
    $burgerQuantidade = $_GET["d"];
    $eggQuantidade = $_GET["e"];
    $calabresaQuantidade = $_GET["f"];
    $baconQuantidade = $_GET["g"];
    $tudoQuantidade = $_GET["h"];

    // Preços dos produtos
    $refriValor = 3.00;
    $sucoValor = 5.50;
    $saladaValor = 5.50;
    $burgerValor = 4.00;
    $eggValor = 4.90;
    $calabresaValor = 8.00;
    $baconValor = 9.00;
    $tudoValor = 12.00;

    // Cálculos por item
    $refriTotal = $refriQuantidade * $refriValor;
    $sucoTotal = $sucoQuantidade * $sucoValor;
    $saladaTotal = $saladaQuantidade * $saladaValor;
    $burgerTotal = $burgerQuantidade * $burgerValor;
    $eggTotal = $eggQuantidade * $eggValor;
    $calabresaTotal = $calabresaQuantidade * $calabresaValor;
    $baconTotal = $baconQuantidade * $baconValor;
    $tudoTotal = $tudoQuantidade * $tudoValor;

    // Soma total
    $total = $refriTotal + $sucoTotal + $saladaTotal + $burgerTotal + $eggTotal + $calabresaTotal + $baconTotal + $tudoTotal;

    // Imprimir resultado
    echo "<p>Total de gasto: <strong>R$ " . number_format($total, 2, ',', '.') . "</strong></p>"; /* number_format($total, 2, ',', '.') formata o número $total com: 
        2 casas decimais, virgula como separador decimal e ponto como separador de milhar */
    ?>
</div>

</body>
</html>
