<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Recebendo os valores do formulário
    $comprimento = $_POST['comprimento'];
    $largura = $_POST['largura'];

    $perimetro = 2 * ($comprimento + $largura);
} else {
    $perimetro = null; // Caso o usuário não coloque valores
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Perímetro</title>
    <style>
        body {
            font: 20px Tahoma normal;
            background-color: white;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .result-container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px; /* Arredondamento da caixa */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* LED's em torno da caixa */
        }
        h2 {
            text-align: center;
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .result {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            font-size: 16px;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="result-container">
        <h2>Resultado do Cálculo</h2>
        <div class="result">
            <?php
            if ($perimetro !== null) {
                echo "O perímetro do retângulo é: <strong>" . $perimetro . "</strong> unidades.";
            } else {
                echo "Por favor, insira os valores no formulário.";
            }
            ?>
        </div>
        <a href="perimetroForm.html">Voltar</a>
    </div>

</body>
</html>
