
<?php

    # Ira possibilitar que o sistema acesse os valores da superglobal
    # SESSION (a sessão que queremos acessar, como por exemplo, a sessão
    # de administrador). 
    session_start();

    # Irá importar as classes que serão utilizadas no arquivo.
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Produto.php';

    # Instância da classe BancoDeDados que contém a conexão com
    # o banco de dados. 
    $banco = new BancoDeDados();

    # Irá conter a conexão com o banco de dados
    $conexao = $banco->conexaoBanco();

    # Irá instanciar a classe Produtos que recebe como argumento 
    # a conexão com o banco de dados.
    $produto = new Produto($conexao);

    # Lista que irá conter os valores retornados pela consulta.
    $resultado = [];

    # Ira verificar as requisições do botão de pesquisa. Basicamente,
    # o if irá verificar se a requisição é do tipo POST (envio de dados
    # ao servidor) e se o botao de name de igual a 'pesquisa' existe.
    # Dessa forma, iremos garantir que o sistema só processe os valores
    # Se houver algum envio de valor. 
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pesquisar'])){

        # Se essa condição for verdadeira, vamos iniciar o processo
        # de consulta dos dados

        # POST que irá coletar os dados do formulário através dos names
        # definidos nos inputs.
        $id_produto = $_POST['id_produto'];

        # Chamada da função usando o id do produto como argumento.
        $resultado = $produto->pesquisaProduto($id_produto);

        # Ira verificar a quantidade de itens da lista.
        if(count($resultado) == 0){
        
        # Se não houver valores na lista, iremos imprimir essa mensagem.
        echo "Não há produto com esse id";
        }

    }

    # Irá verificar as requisições do botão de excluir. O if irá verificar
    # se a requisição é do tipo POST e se o botão de name 'excluir' existe
    # no sistema.
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir'])){

        # Se essa condição for verdadeira, vamos iniciar o processo de
        # exclusão dos dados.

        # Ira coletar o id informado pelo usuário
        $id_produto = $_POST['id_produto'];
        
        # Ira excluir o produto com base no id informado
        $produto->excluirProduto($id_produto);

        # Ira retornar para a página de pesquisa atualizada
        header('Location:PesquisarProduto.php');

        # ira encerrar a execução do script.
        exit();
    }



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchonete</title>
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
                        <h2 class="h4 fw-bold mb-3">Buscar Produto</h2>  
                        <form action="" method="post" class="row g-2">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="id_produto" required placeholder="Informe o id do produto" class="form-control">
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
                    <?php foreach($resultado as $produto): ?>
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 bg-warning text-center py-4">
                                    <i class="bi bi-person-badge display-1 text-white"></i>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <!--Após percorrer a lista, vamos imprimir os valores em cada div que organiza os dados dentro do card-->
                                            <h4 class="card-title fw-bold mb-0"><?php echo $produto['nome_produto'];?></h4>
                                            <span class="badge bg-success rounded-pill">Produto</span>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Id</small>
                                                <span class="fw-semibold"><?php echo $produto['id_produto'];?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Preço</small>
                                                <span class="fw-semibold"><?php echo $produto['preco'];?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">categoria</small>
                                                <span class="fw-semibold"><?php echo $produto['categoria'];?></span>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Quantidade de vendas</small>
                                                <span class="fw-semibold text-warning"><?php echo $produto['quantidade_vendas'];?></span>
                                            </div>
                                        </div>

                                        <div class="mt-3 pt-3 border-top d-flex gap-2">
                                            <!--Link que irá redirecionar para a página de edição de produtos.-->
                                            <a href="EditarProduto.php?id=<?php echo $produto['id_produto'];?>"  class="btn btn-outline-primary btn-sm px-3">Editar Produto</a>
                                             <i class="bi bi-info-circle me-1"></i>
                                            <!--Form que irá conter e processar os valores do botão de exclusão.-->
                                            <form action="" method="post">

                                                <!--Input do tipo hidden que tem como objetivo coletar valores de inputs através dos names 
                                                definidos.
                                                value: Define o valor do input.-->
                                                <input type="hidden" name="id_produto" value="<?php echo $produto['id_produto'];?>">
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
