<?php
require_once('classes/usuarios.php');
require_once('conexao/db.php');

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $nasc = $_POST['nasc'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confsenha = $_POST['confsenha'];

    if ($usuario->cadastrar($nome,$apelido,$nasc, $email, $senha, $confsenha)) {
        echo "Cadastro realizado com sucesso";
    } else {
        echo "ERRO ao cadastrar!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
</head>

<body>
    <form method="POST">
        <label for="Nome">Nome</label>
        <input type="text" name="nome">

        <label for="apelido">Apelido</label>
        <input type="text" name="apelido">

        <label for="email">E-mail</label>
        <input type="email" name="email">

        <label for="nasc">Nascimento</label>
        <input type="date" name="nasc">

        <label for="senha">Senha</label>
        <input type="password" name="senha">

        <label for="confsenha">Confirmar Senha</label>
        <input type="password" name="confsenha">

        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>
    <a href="index.php">Voltar para tela de login</a>
</body>

</html>