<?php
// CONECTANDO AO BANCO DE DADOS
$host = "localhost";
$banco = "bd_mundo";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha); // pdo = nome da variável que guarda a conexão; new PDO = cria um novo objeto de conexão; mysql:host=$host;dbname=$banco;charset=utf8mb4 = quero me conectar num banco de dados SQL, no servidor $host (localhost), com o nome de $banco (bd_mundo) e usar utf8mb4 para utilizar acentos e cedilhas
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Caso ocorra um erro (nome de tabela, etc.) dispare um aviso visual
} catch (PDOException $e) { // Se o "new PDO" falhar...
    die("Erro ao conectar"); // Exibe um aviso na tela e cancela as tentativas de conexão
}

if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    $nome = $_POST['nome'];
    $populacao = $_POST['populacao'];
    $area = $_POST['area'];
    $idioma = $_POST['idioma'];
    $clima = $_POST['clima'];
    $regime = $_POST['regime_politico'];
    $moeda = $_POST['moeda'];
    $id_continente = $_POST['continente_id']; // ID vindo do <select>

    $sql = "INSERT INTO pais (nome_pais, populacao_pais, area_km2_pais, idioma_pais, clima_pais, regime_politico_pais, moeda_pais, id_continente) 
            VALUES (:nome, :populacao, :area, :idioma, :clima, :regime, :moeda, :id_continente)";
    
    $stmt = $pdo->prepare($sql); // Faz o sistema apenas ver que eu vou fazer um insert, mas sem aplicar realmente, isso para fica pré entendido na memória
    
    $stmt->bindParam(':nome', $nome); // Ligando os dados que o usuário digitou àquela query no banco de dados
    $stmt->bindParam(':populacao', $populacao);
    $stmt->bindParam(':area', $area);
    $stmt->bindParam(':idioma', $idioma);
    $stmt->bindParam(':clima', $clima);
    $stmt->bindParam(':regime', $regime);
    $stmt->bindParam(':moeda', $moeda);
    $stmt->bindParam(':id_continente', $id_continente);

    if ($stmt->execute()) { // Agora execute o INSERT de verdade (execute devolve uma resposta binária)
        echo "<script>alert('País cadastrado com sucesso!'); window.location.href='../index.php';</script>"; // Assim que o usuário clicar em OK na caixa de alert o navegador volta para o index.php
    } else {
        echo "Erro ao cadastrar país";
    }
}
?>