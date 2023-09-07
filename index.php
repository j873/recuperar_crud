<?php
session_start();

require_once('classes/usuarios.php');
require_once('conexao/db.php');

$database = new  Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

if (isset($_POST['logar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($usuario->logar($email, $senha)) {
        $_SESSION['email'] = $email;

        header("location: dashboard.php");
        exit();
    } else {
        print "<script>alert('login invalido')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Login</title>
</head>

<body>
    <form method="POST">

        <label for="">E-mail</label>
        <input type="email" name="email" placeholder="Coloque seu email" require>

        <label for="senha">Senha</label>
        <input type="password" name="senha" placeholder="Coloque sua senha aqui" require>

        <button type="submit" name="logar">Logar</button><br>
    </form>
    <a href="dashboard.php">aaa</a>
    <a href="cadastrar.php">aperte aqui para cadastrar</a>
</body>

</html>