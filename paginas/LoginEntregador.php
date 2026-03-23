


<?php

    session_start();

    require_once '../classes/BancoDeDados.php';

    require_once '../classes/Entregadores.php';

    $banco = new BancoDeDados();

    $conexao = $banco->conexaoBanco();

    $entregador = new Entregadores($conexao);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $cpf = $_POST['cpf_entregador'];

        $senha = $_POST['senha_entregador'];

        $entregador->setcpf_entregador($cpf);

        $entregador->setsenha_entregador($senha);


        if($entregador->LoginEntregador()){

            $_SESSION['login_entregador'] = true;

            header("Location: StatusEntrega.php");

        }else{

            echo "Cpf ou senha inválidos";
        }
    }


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title>Lanchonete</title>
    </head>


    <body class="bg-light vh-100 d-flex align-items-center justify-content-center">

        <div class="card shadow-lg border-0 p-4" style="max-width: 400px; width: 100%;">

            <div class="text-center mb-4">

                <img src="../imagens/entregadorlogin.jpg" alt="Entregador" class ="rounded-circle img-thumbnail shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover;">

                <h2 class="h4 fw-bold text-dark">Área do Entregador</h2>

                <p class="text-muted small">Acesse para gerenciar o status das suas entregas</p>

            </div>


        <form action="" method="post">
            
            <div class="mb-3">
                <label for="cpf_entregador" class="form-label small fw-bold text-secondary">CPF</label>
                <input type = "text" name="cpf_entregador" required placeholder="Informe o seu cpf" autocomplete="off" class="form-control form-control-lg bg-light border-0 shadow-sm">
            </div>

            <div class="mb-4">
                <label for="senha_entregador" class="form-label small fw-bold text-secondary"> Senha</label>
                <input type="password" name="senha_entregador" required
                placeholder="Informe a sua senha" autocomplete="off" class="form-control form-control-lg bg-light border-0 shadow-sm">
            </div>

            <button type="submit" class="btn btn-warning btn-lg w-100 shadow-sm fw-bold text-white">Entrar</button>

        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    </body>
</html>