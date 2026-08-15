<?php
// 1. Conexão ao banco para alimentar os formulários[cite: 16]
$host = "localhost";
$banco = "bd_mundo";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// 2. Buscando dados para os selects[cite: 16]
$continentes = $pdo->query("SELECT id_continente, nome_continente FROM continente")->fetchAll(PDO::FETCH_ASSOC);
$paises = $pdo->query("SELECT id_pais, nome_pais FROM pais")->fetchAll(PDO::FETCH_ASSOC);
$cidades = $pdo->query("SELECT id_cidade, nome_cidade FROM cidade")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração Global</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Administração Global</h1>
    </header>
    <main class="main-container">
        <!-- Seção de Continentes -->
        <section class="crud-section">
            <h2>Cadastrar Continente</h2>
            <form action="backend/continente.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>População:</label><input type="number" name="populacao" required></div>
                <div class="form-group"><label>Área (km²):</label><input type="number" step="0.01" name="area" required></div>
                <button type="submit" class="salvar">Salvar Continente</button>
            </form>
        </section>

        <!-- Seção de Países[cite: 16] -->
        <section class="crud-section">
            <h2>Cadastrar País</h2>
            <form action="backend/pais.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome do País:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>População:</label><input type="number" name="populacao" required></div>
                <div class="form-group"><label>Área (km²):</label><input type="number" step="0.01" name="area" required></div>
                <div class="form-group"><label>Idioma:</label><input type="text" name="idioma" required></div>
                <div class="form-group"><label>Clima:</label><input type="text" name="clima" required></div>
                <div class="form-group"><label>Regime Político:</label><input type="text" name="regime_politico" required></div>
                <div class="form-group"><label>Moeda:</label><input type="text" name="moeda" required></div>
                <div class="form-group">
                    <label>Continente:</label>
                    <select name="continente_id" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($continentes as $c): ?>
                            <option value="<?php echo $c['id_continente']; ?>"><?php echo htmlspecialchars($c['nome_continente']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="salvar">Salvar País</button>
            </form>
        </section>

        <!-- Seção de Cidades -->
        <section class="crud-section">
            <h2>Cadastrar Cidade</h2>
            <form action="backend/cidade.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome da Cidade:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>População:</label><input type="number" name="populacao" required></div>
                <div class="form-group"><label>Área (km²):</label><input type="number" step="0.01" name="area" required></div>
                <div class="form-group"><label>Clima:</label><input type="text" name="clima" required></div>
                <div class="form-group"><label>Data de Fundação:</label><input type="date" name="data_fundacao" required></div>
                <div class="form-group">
                    <label>País:</label>
                    <select name="pais_id" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($paises as $p): ?>
                            <option value="<?php echo $p['id_pais']; ?>"><?php echo htmlspecialchars($p['nome_pais']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="salvar">Salvar Cidade</button>
            </form>
        </section>

        <!-- Seção de Governantes -->
        <section class="crud-section">
            <h2>Cadastrar Governante</h2>
            <form action="backend/governante.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>Partido Político:</label><input type="text" name="partido_politico" required></div>
                <div class="form-group"><label>Data de Nascimento:</label><input type="date" name="data_nascimento" required></div>
                <div class="form-group"><label>Idade:</label><input type="number" name="idade" required></div>
                <div class="form-group"><label>Início do Mandato:</label><input type="date" name="data_inicio_mandato" required></div>
                <div class="form-group"><label>Final do Mandato (opcional):</label><input type="date" name="data_final_mandato"></div>
                
                <div class="form-group">
                    <label>Este governante governa um:</label>
                    <select id="gov_vinculo_tipo" onchange="alternarCamposVinculo()">
                        <option value="pais">País</option>
                        <option value="cidade">Cidade</option>
                    </select>
                </div>

                <div class="form-group" id="grupo_vinculo_pais">
                    <label>País Governado:</label>
                    <select name="pais_id">
                        <option value="">Nenhum / Selecione...</option>
                        <?php foreach ($paises as $p): ?>
                            <option value="<?php echo $p['id_pais']; ?>"><?php echo htmlspecialchars($p['nome_pais']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" id="grupo_vinculo_cidade" style="display:none;">
                    <label>Cidade Governada:</label>
                    <select name="cidade_id">
                        <option value="">Nenhum / Selecione...</option>
                        <?php foreach ($cidades as $c): ?>
                            <option value="<?php echo $c['id_cidade']; ?>"><?php echo htmlspecialchars($c['nome_cidade']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="salvar">Salvar Governante</button>
            </form>
        </section>
    </main>
</body>
</html>