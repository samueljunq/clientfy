<?php
session_start();
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $senha_hash = hash('sha256', $senha);

    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $senha_hash);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $dados = $resultado->fetch_assoc(); // <-- pega os dados do usuário
        $_SESSION["logado"] = true;
        $_SESSION["nivel"] = $dados["nivel"]; // <-- salva o nível na sessão

        header("Location: consulta.php");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <div class="login-container">
         <div class="login-left">
        <img src="../img/fundo-img.png" alt="Imagem de boas-vindas" class="fundo-img" />
        
        <div class="logo-clientfy">
          <img src="../img/logo.png" alt="Logo ClientFy" />
        </div>
      </div>
      <div class="login-right">
        <form action="login.php" method="post">
          <h2>Login</h2>
          <input type="text" name="usuario" placeholder="Nome de usuário" required>
          <input type="password" name="senha" placeholder="Senha" required>
          <button type="submit">Entrar</button>
          <!-- Mensagem de erro, se necessário -->
          <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
        </form>
        <footer>
            Desenvolvido por
            Client•Fy todos os direitos reservados © 
        </footer>
      </div>
  </div>
</body>
</html>
