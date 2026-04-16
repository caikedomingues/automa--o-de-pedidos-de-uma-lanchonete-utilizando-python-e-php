


<?php

    # Ira acessar o valor da superglobal $_SESSION (caso
    # uma sessão for criada).
    session_start();

    # Ira importar as classes que serão utilizadas nesse arquivo.
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Produto.php';

    # Irá instanciar a classe banco de dados que possui o método de
    # conexão com o banco de dados.
    $banco = new BancoDeDados();

    # Ira conter a conexão com o banco de dados.
    $conexao = $banco->conexaoBanco();

    # Ira instanciar a classe produto que recebe como argumento
    # a conexão com o banco de dados.
    $produto = new Produto($conexao);

    # Irá verificar a se a requisição enviada ao servidor é do tipo
    # post(envio de dados ao servidor). Dessa forma os valores do
    # formulário só serão processados se houver o envio dos dados
    # ao servidor. 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # Se a requisição for um post, vamos inciar o processo de 
        # exclusão dos produtos.
        #Ira coletar o id do botão pressionado
        $id_produto_excluido = $_POST['id_produto'];

        # Ira chamar a função usando como argumento o id do botão
        # pressionado.
        $produto->excluirProduto($id_produto_excluido);

        # Irá retornar para página de informações de produtos.
        header('Location: InformacoesProdutos.php');

        # Ira encerrar a execução do trecho, ou seja, a execução
        # da exclusão do dado.
        exit();
    }

    # Irá listar os produtos cadastrados no sistema.
    $listaprodutos = $produto->listarProdutos();

?>
<!DOCTYPE html>
<html lang="pt-br">

    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <title>Lanchonete</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"> 
    </head>

    <body class="bg-light vh-100 d-flex align-items-center justify-content-center">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="#">
                <i class="bi bi-shop me-2"></i>Lanchonete 
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="CadastroEntregador.php">Cadastro de Entregadores</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="CadastroProduto.php">Cadastro de Produtos</a></li>

                    <li class="nav-item"><a class="nav-link" href="InformacoesEntregadores.php">Entregadores</a></li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Entregas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="TodasEntregasRealizadas.php">Concluídas</a></li>
                            <li><a class="dropdown-item" href="EntregasaCaminho.php">A Caminho</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Consultas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="PesquisarEntregador.php">Entregadores</a></li>
                            <li><a class="dropdown-item" href="PesquisarPedido.php">Pedidos</a></li>
                            <li><a class="dropdown-item" href="PesquisarPedidosClientes.php">Pedidos dos Clientes</a></li>
                            <li><a class="dropdown-item" href="PesquisarProduto.php">Produtos</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <span class="text-light me-3 small">
                        <i class="bi bi-person-circle me-1"></i>Admin
                    </span>
                    <a href="LogoutAdm.php" class="btn btn-outline-danger btn-sm">Sair</a>
                </div>
            </div>
        </div>
    </nav>

        <div class="container py-5">
            <div class="position-relative mb-5 rounded-4 overflow-hidden shadow-sm" style="height: 200px;">
                <img src="../imagens/alimentos.jpg" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);">
                <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                    <h1 class="display-5 fw-bold text-white">Produtos Disponiveis</h1>
                    <p class="text-white-50">Visualize os itens da lanchonete</p>
                </div>
        </div>
        <div class="row g-4">
            <!--Foreach que ira percorrer os valores retornados pela função de listar produtos. Fizemos dessa maneira para
            garantir que os valores sejam mostrados dentro dos
            divs definidos pelo bootstrap.-->
            <?php foreach($listaprodutos as $item_lanchonete):?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>   
                                <!--Nessa etapa iremos acessar os valores usando os nomes de cada coluna do item que esta sendo percorrido pelo foreach-->
                                <span class="badge bg-warning text-dark mb-2 px-3"><?php echo $item_lanchonete['categoria'];?></span>
                                <h5 class="card-title fw-bold text-dark mb-0">Produto: <?php echo $item_lanchonete['nome_produto'];?></h5>
                                <small class="text-muted">ID:<?php echo " ".$item_lanchonete['id_produto'];?></small> </small><br>
                                <small class="text-muted">Preço:<?php echo " ". $item_lanchonete['preco']?> </small><br>
                                <small class="text-muted">Quantidade de vendas: <?php echo " ".$item_lanchonete['quantidade_vendas'];?> </small><br>
                        </div>
                      </div>
                      <hr class="text-light">
                      <div class="d-flex justify-content-end gap-2">
                        <!--Link que irá para a página de edição de produtos. Vamos definir no link o valor do id
                        do produto que será editado.-->
                        <a href="EditarProduto.php?id=<?php echo $item_lanchonete['id_produto'];?>" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                            <i class="bi bi-info-circle me-1"></i> Editar Produto
                        </a>
                        <!--Form que irá enviar os dados para a própria
                         página.-->
                        <form action='' method="post">
                            <!--Input que irá ter o id do produto que será excluido como valor (que será coletado pelo $_POST posteriormente).-->
                            <input type="hidden" name="id_produto" value="<?php echo $item_lanchonete['id_produto']?>">

                            <!--Botão que irá enviar as informações da página para o servidor.-->
                          <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-pill"><i class="bi bi-trash me-1"></i>Excluir</button>
                     </form>
                     </div>
                    </div>
                </div>
            </div>
            <!--Fim do foreach-->
            <?php endforeach;?>
            </div>
            
        </div>

        


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>