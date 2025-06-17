<?php
include('../conexao.php');
session_start();

// if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true || $_SESSION["nivel"] !== 'admin') {
//     header("Location: login.php");
//     exit;
// }


$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];

    $stmt = $conn->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $telefone, $endereco);

    if ($stmt->execute()) {
        $mensagem = "✅ Cliente cadastrado com sucesso!";
    } else {
        $mensagem = "❌ Erro ao cadastrar cliente.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
    <header>
        <h1 class="titulo-page">📋 Cadastro de Cliente</h1>
    </header>

    <main>
        <form action="cadastro.php" method="post">
            <h2>Inserir novo cliente</h2>
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="telefone" placeholder="Telefone">
            <input type="text" name="endereco" placeholder="Endereço completo">
            <button type="submit">Cadastrar</button>

            <?php if (!empty($mensagem)) : ?>
                <p><?php echo $mensagem; ?></p>
            <?php endif; ?>
        </form>
    </main>

    <div class="botoes-extra">
        <a href="consulta.php" class="btn-secundario">Consulta de Clientes</a>
        <a href="logout.php" class="btn-secundario">Sair do sistema</a>
    </div>

    <footer>
        Desenvolvido por Samuel Junqueira & Esau Paiva
    </footer>
</body>
</html>