<?php
include('../conexao.php');
session_start();
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: login.php");
    exit;
}

// Busca todos os clientes (verifique se a coluna 'criado_em' existe)
$sql = "SELECT * FROM clientes ORDER BY criado_em DESC"; 
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Clientes</title>
    <link rel="stylesheet" href="../css/consulta.css">
</head>
<body>
    <header>
        <div class="header-left">
            <h1><span>Client</span>Fy</h1>
            <nav>
                <a href="index.php">Início</a>
                <a href="cadastro.php">Cadastrar</a>
                <a href="consulta.php" class="active">Consultar</a>
            </nav>
        </div>
        <div class="header-right">
            <a href="logout.php" class="btn-logout">Sair</a>
        </div>
    </header>

    <main>
        <h2>Clientes Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cliente = $resultado->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $cliente["nome"]; ?></td>
                        <td><?php echo $cliente["email"]; ?></td>
                        <td><?php echo $cliente["telefone"]; ?></td>
                        <td><?php echo $cliente["endereco"]; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($cliente["data_cadastro"])); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $cliente['id']; ?>">Editar</a> |
                            <a href="excluir.php?id=<?php echo $cliente['id']; ?>" onclick="return confirm('Deseja realmente excluir?')">Excluir</a> |
                            <a href="anotacoes.php?cliente_id=<?php echo $cliente['id']; ?>">Anotações</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <footer>
        Desenvolvido por Samuel Junqueira & Esau Paiva
    </footer>
</body>
</html>