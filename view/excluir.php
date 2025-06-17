<?php
include '../conexao.php';

session_start();
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: consulta.php");
        exit();
    } else {
        echo "Erro ao excluir cliente.";
    }

    $stmt->close();
} else {
    header("Location: consulta.php");
    exit();
}
?>
