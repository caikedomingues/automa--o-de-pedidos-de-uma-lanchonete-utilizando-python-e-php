

<?php
    #Ira possibilitar o acesso a sessões.
    session_start();

    # Ira importar para o arquivo as classes que serão utilizadas
    # no sistema.  
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Entregadores.php';

    # Instância da classe Banco de Dados
    $banco = new BancoDeDados();

    # Ira conter a conexão com o banco de dados 
    $conexao = $banco->conexaoBanco();

    # Instância da classe entregador que irá receber como argumento em 
    # seu construtor, a conexão com o banco de dados que irá
    # possibilitar que o método cadastrar entregadores insira dados
    # no banco
    $entregador = new Entregadores($conexao);

    # Ira verificar se a requisição enviada ao servidor é do tipo
    # POST. Dessa forma o sistema não ira processar o formulário
    # vázio.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # Se a requisição for um post(envio de dados para o servidor),
        # vamos iniciar o processo de coleta dos dados dos formulários
        # e inserção no banco

        # POST: Variável global do PHP que tem como objetivo coletar os
        # valores presentes em formulários através dos names definidos 
        # nos campos.
        $cpf_entregador = $_POST['cpf_entregador'];

        $nome_entregador = $_POST['nome_entregador'];

        $telefone_entregador = $_POST['telefone_entregador'];

        $senha_entregador = $_POST['senha_entregador'];

        $veiculo = $_POST['veiculo'];

        # Ira inserir os valores coletados nos setters dos entregadores, dessa forma
        # a função cadastrarEntregador conseguira acessar os valores através dos getters
        # que também foram definidos das classes.
        $entregador->setcpf_entregador($cpf_entregador);

        $entregador->setnome_entregador($nome_entregador);

        $entregador->settelefone_entregador($telefone_entregador);

        $entregador->setsenha_entregador($senha_entregador);

        $entregador->setveiculo($veiculo);

        # Irá chamar a função de cadastro de entregadores
        $entregador->cadastrarEntregador();

    }

    


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <title>Lanchonete</title>

        <!--Link do Boostrap que é o framework que irá estilizar a página do sistema-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>


    <body class="bg-light vh-100 d-flex align-items-center justify-content-center">

        <div class="card shadow-lg border-0 p-4" style="max-width: 450px; width=100%;">
            <div class="text-center mb-4">
                <img src="../imagens/ImagemEntregador.webp" alt="Entregador" class="rounded-circle img thumbnail shadow-sm mb-3" width="100" height="100">

                <h2 class="h4 fw-bold text-dark">Cadastro de Entregadores</h2>

                <p class="text-muted small">Preencha os dados para registrar entregadores no sistema</p>
                
            </div>

        <!--Irá construir o formulario de cadastro de entregadores

            action: Define para onde os dados irão após clicarmos no botão. No 
            nosso caso, iremos enviar os dados para a nossa própria página.
            
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
                
                id: Também é um identificador dos campos dos formulários.

                required: Define que os campos são obrigatórios

                placeholder: Instruções de como preencher cada campo
                do formulário.

                autocomplete=off: Desabilita os autocompletes dos campos.
            -->
            <div class="mb-3">
                <label for="cpf_entregador" class="form-label small fw-bold text-secondary">CPF</label>
                <input type="text" name="cpf_entregador" id="cpf_entregador" required placeholder="Informe o cpf do entregador" autocomplete="off" class="form-control form-control-lg bg-light">
            </div>

            <div class="mb-3">
                <label for="nome_entregador" class="form-label small fw-bold text-secondary">Nome</label>
                <input type="text" name="nome_entregador" id="nome_entregador" required placeholder="Informe o nome do entregador" autocomplete="off" class="form-control form-control-lg bg-light">
            </div>

            <div class="mb-3">
                <label for="telefone_entregador" class="form-label fw-bold text-secondary">Telefone</label>
                <input type="text" name="telefone_entregador" id="telefone_entregador" required placeholder="Informe o telefone do entregador" autocomplete="off" class="form-control form-control-lg bg-light">
            </div>
            
            <div class="mb-4">
                <label for="senha_entregador" class="form-label small fw-bold text-secondary">Senha do Entregador</label>
                <input type="text" name="senha_entregador" id="senha_entregador" required placeholder="Crie uma senha para o entregador" autocomplete="off" class="form-control form-control-lg bg-light">
            </div>

            <div class="mb-4">
                <label for="veiculo" class="form-label small fw-bold text-secondary">Veiculo do Entregador</label>
                <input type="text" name="veiculo" id="veiculo" required placeholder="Informe o veiculo do entregador" autocomplete="off" class="form-control form-control-lg bg-light">
            </div>

            <!--Ira criar o botão que envia os dados--->
            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold"> Cadastrar Entregador</button>

        </form>

        <!--Javascript que manipula elementos animados da estilização do bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>