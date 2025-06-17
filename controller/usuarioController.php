<?php
require_once('./model/usuario.php');

class UsuarioController {

    public function criar($nome, $email, $senha) {
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha(password_hash($senha, PASSWORD_DEFAULT));

        return $usuario->salvar();
    }

    public function editar($id, $nome, $email) {
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNome($nome);
        $usuario->setEmail($email);

        return $usuario->atualizar();
    }

    public function excluir($id) {
        $usuario = new Usuario();
        $usuario->setId($id);
        return $usuario->excluir();
    }

    public function listar() {
        $usuario = new Usuario();
        return $usuario->listar();
    }

    public function autenticar($email, $senha) {
        $usuario = new Usuario();
        $dados = $usuario->buscarPorEmail($email);

        if ($dados && password_verify($senha, $dados['senha'])) {
            session_start();
            $_SESSION['usuario'] = $dados;
            return true;
        }
        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: view/login.php');
    }
}
?>

