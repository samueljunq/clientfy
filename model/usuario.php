<?php
require_once('./config/conexao.php');

class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha;

    // Getters e Setters
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    public function setNome($nome) { $this->nome = $nome; }
    public function getNome() { return $this->nome; }

    public function setEmail($email) { $this->email = $email; }
    public function getEmail() { return $this->email; }

    public function setSenha($senha) { $this->senha = $senha; }
    public function getSenha() { return $this->senha; }

    // Métodos de banco
    public function salvar() {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->nome, $this->email, $this->senha);
        return $stmt->execute();
    }

    public function atualizar() {
        global $conn;
        $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $this->nome, $this->email, $this->id);
        return $stmt->execute();
    }

    public function excluir() {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function listar() {
        global $conn;
        $result = $conn->query("SELECT * FROM usuarios");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorEmail($email) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
