


<?php
    
    # Ira conectar o sistema ao arquivo de sessões
    session_start();

    # Ira importar para o arquivo as classes que serão utilizadas
    # no sistema.
    require_once '../classes/BancoDeDados.php';

    require_once '../classes/Entregadores.php';

    # Ira instanciar a classe Banco de dados que contém a conexão
    # com o banco de dados.
    $banco = new BancoDeDados();

    # Ira conter o metodo de conexão da classe banco de dados
    $conexao = $banco->conexaoBanco();

    # Instância da classe Entregador que irá receber como argumento
    # a conexão com o banco de dados.
    $entregador = new Entregadores($conexao);

    # Ira verificar se a requisição enviada ao servidor é do tipo
    # POST (envio de dados ao servidor) com o objetivo de possibilitar
    # que o sistema só processe os dados do form se ele for preenchido,
    # ou seja, se houver o envio dos dados 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # Se a requisição for um post, vamos iniciar o processo
        # de coleta de dados e criação de sessões.

        # Ira coletar os dados do form usando a superglobal post
        # que acessa os dados através dos names definidos nos
        # campos (inputs) dos formulários.
        $cpf = $_POST['cpf_entregador'];

        $senha = $_POST['senha_entregador'];

        # Ira inserir os dados nos setters da classe com o objetivo
        # de possibilitar que os getters acessem os valores que
        # serão utilizados na execução do metodo de login dos
        # entregadores.
        $entregador->setcpf_entregador($cpf);

        $entregador->setsenha_entregador($senha);

        # Ira verificar o resultado da chamada da função login de 
        # entregadores
        if($entregador->LoginEntregador()){

            # Se o retorno da função for true, vamos criar uma
            # sessão especifica para login de entregadores. 
            # O nome atribuido a sessão serve para diferenciar
            # os tipos de usuários que estão acessando o sistema
            # (um cliente, um usuário ou um administrador).
            $_SESSION['login_entregador'] = true;

            # Vamos transferir o entregador para a pagina de status
            # de entregas
            header("Location: StatusEntrega.php");

        }else{

            # Se o retorno da função for false, vamos imprimir essa mensagem.
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
        <!--Link do Boostrap que é o framework que irá estilizar a página do sistema-->
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

        <!--Ira criar o formulário de login do entregador.
            action: Define para onde os dados irão após clicarmos no botão. No nosso caso, iremos enviar os dados para a 
            própria página.

            method: Método de envio dos dados do formulário
        -->
        <form action="" method="post">
            
            <!--
                Label: Ira conter os rótulos dos campos

                for: Associa o rótulo ao campo do formulário

                input: Define os campos dos formulários.

                type: Define o tipo do dado que o campo deve
                receber

                name: Nome de identificação do campo do formulário, vamos usar esse name para acessar os valores usando
                a variável global POST.

                required: Define que os campos são obrigatórios
                
                placeholder: Instruções de como preencher cada campo
                do formulário.

                autocomplete=off: Desabilita os autocompletes dos campos.
            -->
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
        <!--Link do javascript do bootstrap, que tem como objetivo fazer funcionar objetos animados da estilização do bootstrap.-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    </body>
</html>