<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit();
}

// Verifica se veio o ID do cliente pela URL
if (!isset($_GET['cliente_id'])) {
    echo "Cliente não especificado.";
    exit();
}

$cliente_id = $_GET['cliente_id'];
$mensagem = "";

// Cadastrar nova anotação
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $texto = $_POST['texto'];

    $stmt = $conn->prepare("INSERT INTO anotacoes (cliente_id, texto) VALUES (?, ?)");
    $stmt->bind_param("is", $cliente_id, $texto);

    if ($stmt->execute()) {
        $mensagem = "✅ Anotação salva com sucesso!";
    } else {
        $mensagem = "❌ Erro ao salvar anotação.";
    }

    $stmt->close();
}

// Buscar anotações do cliente
$stmt = $conn->prepare("SELECT * FROM anotacoes WHERE cliente_id = ? ORDER BY data_criacao DESC");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Anotações do Cliente</title>
    <link rel="stylesheet" href="css/consulta.css">
</head>
<body>
    <header>
        <h1>Anotações do Cliente #<?php echo $cliente_id; ?></h1>
        <a href="consulta.php" style="color: white; font-weight: bold;">← Voltar</a>
    </header>

    <main>
        <form method="post" style="margin-bottom: 2rem;">
            <textarea name="texto" rows="4" placeholder="Digite uma nova anotação..." required></textarea><br>
            <button type="submit">Adicionar Anotação</button>
            <?php if (!empty($mensagem)) : ?>
                <p style="margin-top: 10px;"><?php echo $mensagem; ?></p>
            <?php endif; ?>
        </form>

        <h2>Histórico de Anotações</h2>
        <ul>
            <?php while ($linha = $resultado->fetch_assoc()) : ?>
                <li>
                    <strong><?php echo date("d/m/Y H:i", strtotime($linha["data_criacao"])); ?>:</strong>
                    <?php echo htmlspecialchars($linha["texto"]); ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </main>

    <footer>
        Desenvolvido por Samuel Junqueira & Esau Paiva
    </footer>
</body>
</html>
