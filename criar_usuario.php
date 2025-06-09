<?php
include 'conexao.php';
session_start();
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: login.php");
    exit;
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = hash('sha256', $_POST["senha"]);
    $senha_hash = hash('sha256', $senha);

    // Verifica se o usuário já existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $check->bind_param("s", $usuario);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mensagem = "❌ Usuário já existe.";
    } else {
        // Insere novo usuário
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $senha_hash);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Usuário cadastrado com sucesso!";
        } else {
            $mensagem = "❌ Erro ao cadastrar usuário.";
        }

        $stmt->close();
    }

    $check->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Usuário</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <h1>Novo Usuário</h1>
    </header>

    <main>
        <form action="criar_usuario.php" method="post">
            <h2>Cadastrar Novo Usuário</h2>
            <input type="text" name="usuario" placeholder="Nome de usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>

            <?php if (!empty($mensagem)) : ?>
                <p style="margin-top: 10px;"><?php echo $mensagem; ?></p>
            <?php endif; ?>
        </form>
    </main>

    <footer>
        Desenvolvido por aluno1 e aluno2
    </footer>
</body>
</html>