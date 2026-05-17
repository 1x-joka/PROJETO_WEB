<?php

/* Transformando os dados que o usuário coloca nos campos HTML em PHP para manipulação */
$turma = $_POST['turma'];
$alunos = $_POST['aluno'];
$notas1 = $_POST['nota1'];
$notas2 = $_POST['nota2'];
$notasTrab = $_POST['notaTrabalho'];

$qtd = count($alunos);
$aprovados = 0;
$recuperacao = 0;
$reprovados = 0;
$somaMedias = 0;
$todasNotas = 0;
$maiorMedia = -1; // Usando uma nota impossível para comparação já que um aluno não pode tirar -1
$menorMedia = 999;

for ($i = 0; $i < $qtd; $i++) {
    $n1 = (float) str_replace(',', '.', $notas1[$i]);
    $n2 = (float) str_replace(',', '.', $notas2[$i]);
    $nt = (float) str_replace(',', '.', $notasTrab[$i]);

    $media = ($n1 + $n2 + $nt) / 3;
    $raiz = sqrt($n1 + $n2 + $nt);
    $diferenca = abs(max($n1, $n2, $nt) - min($n1, $n2, $nt));

    if ($media >= 7){
        $situacao = 'Aprovado';
        $aprovados++;
    }
    elseif ($media >= 5){
        $situacao = 'Recuperação';
        $recuperacao++;
    }
    else {
        $situacao = 'Reprovado';  
        $reprovados++;
    }

    $somaMedias += $media;
    $todasNotas += $n1 + $n2 + $nt;
    if ($media > $maiorMedia){
        $maiorMedia = $media;
    }
    if ($media < $menorMedia){
        $menorMedia = $media;
    }

    $dados[] = [$alunos[$i], $n1, $n2, $nt, $media, $raiz, $diferenca, $situacao]; // Joga os dados numa lista para administrar com [] de posição
}

$mediaGeral = $somaMedias / $qtd;
$percentual = ($aprovados / $qtd) * 100;

$mediaGeral = $somaMedias / $qtd;

$percentual = ($aprovados / $qtd) * 100;
if ($percentual >= 70) {
    $classeMensagem = 'boa';
} elseif ($percentual >= 50) {
    $classeMensagem = 'media';
} else {
    $classeMensagem = 'baixa';
}

?>

<!-- CÓDIGO HTML !-->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="relatorio">
<div class="container-relatorio">

    <h1>Relatório da Turma <?= $turma ?></h1>

    <div>
        <h2>Dados Individuais dos Alunos</h2>
        <table class="tabela-alunos">
            <!-- Criando os cabeçalhos !--> 
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                    <th>Trabalho</th>
                    <th>Média</th>
                    <th>√(Soma)</th>
                    <th>|Máx−Mín|</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $d): ?> <!-- começa a iniciar(analisar) aluno por aluno !-->
                <tr>
                    <td><?= $d[0] ?></td> <!-- simplifica <pho echo .. ?> !-->
                    <td><?= $d[1] ?></td>
                    <td><?= $d[2] ?></td>
                    <td><?= $d[3] ?></td>
                    <td><?= round($d[4], 2) ?></td> <!-- round arredonda para até 2 casas decimais !-->
                    <td><?= round($d[5], 2) ?></td>
                    <td><?= round($d[6], 2) ?></td>
                    <td class="situacao-<?= $d[7] ?>"><?= $d[7] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="dados">
        <h2>Estatísticas da Turma</h2>
        <p class="dados-aluno">Média Geral:
            <span><?= round($mediaGeral, 2) ?></span>
        </p>
        <p class="dados-aluno">Maior Média:
            <span><?= round($maiorMedia, 2) ?></span>
        </p>
        <p class="dados-aluno">Menor Média:
            <span><?= round($menorMedia, 2) ?></span>
        </p>
        <p class="dados-aluno">Total de Alunos:
            <span><?= $qtd ?></span>
        </p>
        <p class="dados-aluno">Aprovados:
            <span><?= $aprovados ?></span>
        </p>
        <p class="dados-aluno">Em Recuperação:
            <span><?= $recuperacao ?></span>
        </p>
        <p class="dados-aluno">Reprovados:
            <span><?= $reprovados ?></span>
        </p>
        <p class="dados-aluno">Percentual Aprovação:
            <span><?= round($percentual, 1) ?>%</span>
        </p>
        <p class="dados-aluno">Soma Total de Notas:
            <span><?= $todasNotas ?></span>
        </p>
    </div>

    <div class="mensagem <?= $classeMensagem ?>">
            <?php
            if ($percentual >= 70){
                echo "Maior parte da turma aprovada!";
            }
            elseif ($percentual >= 50){
                echo "Mais da metade da turma foi aprovada";
            }
            else {
                echo "Turma com desempenho baixo";
            }
            ?>
    </div>
    <div><a href="index.html" class="voltar">Voltar</a></div>
</div>
</body>
</html>