<?php
session_start(); //essa funçãocria uma sessão ou resume a sessão atual baseado em um id  de sessão passado via GET ou POST,ou passado via cookie.
require_once('classes/usuarios.php');
require_once('conexao/db.php'); //o require_once verifica se o arquivo foi enviado e se enviado eles não enviarão novamente

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;
        case 'read':
            $rows = $crud->read();
            break;
        case 'update':
            if(isset($_POST['id'])){
                $crud->read();
                break;
            }
            $rows = $crud->read();
            break;
            case 'delete':
                $crud->delete($_GET['id']);
                $rows = $crud->read();
                break;
                default:
                $rows = $crud->read();
                break;
            }
            } else{
        $rows = $crud->read();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dash board</title>
    <style>

    </style>

</head>

<body>
    <h1>Painel de configuração</h1>
    <p>Seja bem vindo <?php echo $apelido; ?></p>
    
    <?php

    if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
        $id = $_GEET['id'];
        $result = $crud->readOne($id);

        if (!$resulte) {
            echo "Registro não encontrado";
            exit();
        }
        $nome = $result['nome'];
        $apelido = $result['apelido'];
        $email = $result['email'];
        $nasc = $result['nasc'];
        $senha = $result['senha'];

    ?>

        <form action="?action=update" method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>">


            <label for="nome">Nome</label>
            <input type="text" name="nome" value="<?php echo $nome ?>">

            <label for="apelido">Apelido</label>
            <input type="text" name="apelido" value="<?php echo $apelido ?>">

            <label for="email">E-mail</label>
            <input type="email" name="email" value="<?php echo $email ?>">

            <label for="nasc">Data de Nascimento</label>
            <input type="date" name="nasc" value="<?php echo $nasc ?>">

            <label for="senha">Senha</label>
            <input type="password" name="senha" value="<?php echo $senha ?>">

            <input type="submit" value="atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">
        </form>
    <?php

    } 
?>    
    <table>
        <tr>
            <td>id</td>
            <td>Nome</td>
            <td>Apelido</td>
            <td>E-mail</td>
            <td>Data de nascimento</td>
            <td>Senha</td>
        </tr>
        <?php
       if($rows->rowCount() == 0){
        echo "<tr>";
        echo "<td colspan='7'>Nenhhum dado encontrado</td>";
        echo "</tr>";
       } else{
        while($row = $rows->fetch(PDO::FETCH_ASSOC)){
            ECHO 
        }
       }
    </table>
</body>
</body>

</html>