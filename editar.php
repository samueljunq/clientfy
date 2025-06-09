<?php
include 'conexao.php';
session_start();
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: consulta.php");
    exit();
}

$id = $_GET['id'];
$mensagem = "";


// Buscar dados do cliente
$sql = "SELECT * FROM clientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();
$stmt->close();

// Atualizar dados se enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];

    $sql = "UPDATE clientes SET nome = ?, email = ?, telefone = ?, endereco = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $endereco, $id);

    if ($stmt->execute()) {
        $mensagem = "✅ Cliente atualizado com sucesso!";
    } else {
        $mensagem = "❌ Erro ao atualizar cliente.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <header>
        <h1>Editar Cliente</h1>
    </header>

    <main>
        <form method="post" action="">
            <h2>Atualizar Dados</h2>
            <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>" required>
            <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required>
            <input type="text" name="telefone" value="<?php echo $cliente['telefone']; ?>">
            <input type="text" name="endereco" value="<?php echo $cliente['endereco']; ?>">
            <button type="submit">Salvar Alterações</button>

            <?php if (!empty($mensagem)) : ?>
                <p><?php echo $mensagem; ?></p>
                <a href="consulta.php">
                    <button type="button" style="margin-top: 10px;">Voltar à Lista</button>
                </a>
            <?php endif; ?>
        </form>
    </main>

    <footer>
        Desenvolvido por Samuel Junqueira & Esau Paiva
    </footer>
</body>
</html>
