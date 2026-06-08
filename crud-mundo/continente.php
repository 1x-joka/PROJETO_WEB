<?php
$host = "localhost";
$banco = "bd_mundo";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados");
}

// 2. Verifica se a ação enviada pelo formulário é de cadastrar
if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    
    // 3. Recebe e limpa as variáveis vindas do HTML
    $nome = $_POST['nome'];
    $populacao = $_POST['populacao'];
    $area = $_POST['area'];

    // 4. Prepara a query SQL de inserção
    $sql = "INSERT INTO continente (nome_continente, populacao_continente, area_km2_continente) 
            VALUES (:nome, :populacao, :area)";
    
    $stmt = $pdo->prepare($sql);

    // 5. Vincula os parâmetros de forma segura contra SQL Injection
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':populacao', $populacao);
    $stmt->bindParam(':area', $area);

    // 6. Executa e avisa se deu certo
    if ($stmt->execute()) {
        echo "<script>alert('Continente cadastrado com sucesso!'); window.location.href='../index.php';</script>";
    } else {
        echo "Erro ao cadastrar continente.";
    }
}
?>