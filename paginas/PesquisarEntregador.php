


<?php

    # Ira garantir que o sistema acesse os valores da variável
    # $_SESSION (o tipo de sessão que o sistema quer acessar).
    session_start();

    # Ira importar para o arquivo as classes que iremos utilizar no
    # arquivo.
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Entregadores.php';

    # Ira instanciar a classe BancoDeDados que possibilita o
    # acesso ao banco de dados.
    $banco = new BancoDeDados();

    # Ira conter a conexão com o banco de dados.
    $conexao = $banco->conexaoBanco();

    # Ira instanciar a classe Entregadores que recebe como
    # argumento a conexão com o banco de dados.
    $entregadores = new Entregadores($conexao);
    
    # Lista que irá conter os valores retornados pelo método pesquisaEntregadores.
    $resultado = [];
    
    # Ira verificar se a requisição enviada ao servidor é do tipo POST
    # (envio de dados). Dessa forma, garantimos que  o sistema só processe
    # os dados do formulário se o botão de pesquisa for pressionado.
    # Como dessa vez vamos utilizar 2 botões que enviam dados ao
    # servidor, vamos especificar no if o name do botão que queremos
    # verificar a requisição com o objetivo de mostrar ao sistema, qual
    # botão estamos pressionando

    # Ira verificar as requisições do botão de pesquisa.
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pesquisar'])){
        
        # Se essa condição for verdadeira, vamos coletar os dados
        # usando a superglobal $_POST que coleta dados atraves dos
        # names definidos nos inputs.
        $cpf_entregador = $_POST['cpf_entregador'];

        # Ira settar os dados no getter da classe de entregadores
        $entregadores->setcpf_entregador($cpf_entregador);

        # Ira chamar a função de pesquisa de entregadores.
        $resultado = $entregadores->pesquisaEntregadores();

        # Irá verificar se a lista possui valores
        if(count($resultado) == 0){

            # Caso não exista itens na lista, significa que a
            # consulta não retornou dados e sim uma lista vázia.
            # Nesses casos, iremos imprimir essa mensagem
            echo "Não entregadores com esse cpf";
       }
    }

    # Irá verificar as requisições do botão de excluir entregadores
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir'])){

        # Ira conter o cpf digitado no campo de pesquisa (lógica
        # da superglobal $_POST explicada anteriormente).
        $cpf_entregador = $_POST['cpf_entregador'];

        # Ira settar o cpf informado na classe.
        $entregadores->setcpf_entregador($cpf_entregador);

        # Ira chamar a função de exclusão de entregadores.
        $entregadores->excluirEntregador();

        # Ira retornar para a pagina de pesquisa atualizada
        header("Location: PesquisarEntregador.php");
        # Ira encerrar a execução do script.
        exit();
    }



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchonete - Pesquisar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-search text-warning display-4 mb-3"></i>
                        <h2 class="h4 fw-bold mb-3">Buscar Entregador</h2>  
                        <form action="" method="post" class="row g-2">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="cpf_entregador" required placeholder="Informe o CPF" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3 d-grid">
                                <button class="btn btn-warning fw-bold" type="submit" name="pesquisar">Pesquisar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                    <!--Como precisamos que os resultados fiquem dentro do card definido no boostrap, vamos percorrer
                    a lista de resultados dentro da div que cria os
                    cards-->
                    <?php foreach($resultado as $entregador): ?>
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 bg-warning text-center py-4">
                                    <i class="bi bi-person-badge display-1 text-white"></i>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <!--Após percorrer a lista, vamos imprimir os valores em cada div que organiza os dados dentro do card-->
                                            <h4 class="card-title fw-bold mb-0"><?php echo $entregador['nome_entregador'];?></h4>
                                            <span class="badge bg-success rounded-pill">Entregador</span>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">CPF</small>
                                                <span class="fw-semibold"><?php echo $entregador['cpf_entregador'];?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Telefone</small>
                                                <span class="fw-semibold"><?php echo $entregador['telefone_entregador'];?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Veículo</small>
                                                <span class="fw-semibold"><?php echo $entregador['veiculo'];?></span>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Quantidade de entregas</small>
                                                <span class="fw-semibold text-warning"><?php echo $entregador['quantidade_pedidos_feitos'];?> entregas</span>
                                            </div>
                                        </div>

                                        <div class="mt-3 pt-3 border-top d-flex gap-2">
                                            <form action="" method="post">
                                                <input type="hidden" name="cpf_entregador" value="<?php echo $entregador['cpf_entregador'];?>">
                                                <button type="submit" name="excluir" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash me-1"></i>Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--Representa o fim do foreach criado anteriormente-->
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
