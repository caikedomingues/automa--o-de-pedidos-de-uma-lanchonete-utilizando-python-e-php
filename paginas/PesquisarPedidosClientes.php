
<?php

    # Ira possibilitar que o sistema acesse os valores da superglobal $_SESSION
    # que armazena diferentes valores de sessões, como por exemplo, uma sessão
    # de administrador e uma sessão de entregadores.
    session_start();

    # Ira importar as classes que serão utilizadas no arquivo.
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Pedidos.php';

    # Ira instanciar a classe BancoDeDados que possui a conexão
    # com o banco do sistema.
    $banco = new BancoDeDados();
    
    # Ira conter a conexão com o banco de dados.
    $conexao = $banco->conexaoBanco();

    # Irá conter a conexão com o banco de dados.
    $pedidos = new Pedidos($conexao);

    # Ira conter os resultados retornados pela consulta
    $resultado = [];

    # Ira verificar o tipo de requisição antes de processar os valores do formulário
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # Ira coletar o cpf do cliente informado no form
        $dono_pedido = $_POST['dono_pedido'];

        # Ira atribuir na lista o resultado da consulta
        $resultado = $pedidos->buscarPedidosClientes($dono_pedido);

        # Ira verificar se a lista possui valores
        if(count($resultado) == 0){
            # Caso a lista esteja vázia, vamos imprimir essa mensagem.
            echo "Esse cliente não possui pedidos ou não existe";
        }
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
                    <li class="nav-item"><a class="nav-link" href="InformacoesProdutos.php">Cardápio</a></li>
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
        
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-search text-warning display-4 mb-3"></i>
                        <h2 class="h4 fw-bold mb-3">Buscar Pedidos dos clientes</h2>  
                        <form action="" method="post" class="row g-2">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-card-text"></i></span>
                                    <!--input que irá receber o codigo do pedido.-->
                                    <input type="text" name="dono_pedido" required placeholder="Informe o cpf do cliente" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3 d-grid">
                                <!--Botão que irá enviar a requisição para o servidor-->
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
                    <?php foreach($resultado as $pedido_cliente): ?>
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 bg-warning text-center py-4">
                                    <i class="bi bi-person-badge display-1 text-white"></i>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <!--Após percorrer a lista, vamos imprimir os valores em cada div que organiza os dados dentro do card-->
                                            <span class="badge bg-success rounded-pill">Cliente: <?php echo $pedido_cliente['dono_pedido'];?></span>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Produto Pedido</small>
                                                <span class="fw-semibold"><?php echo $pedido_cliente['produto_pedido'];?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Código do Pedido</small>
                                                <span class="fw-semibold"><?php echo $pedido_cliente['codigo_pedido'];?></span>
                                            </div>
                                        
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">status da entrega</small>
                                                <span class="fw-semibold"><?php echo $pedido_cliente['status_entrega'];?></span>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Data do Pedido</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido_cliente['data_pedido'];?></span>
                                            </div>
                                             <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Endereço</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido_cliente['endereco'];?></span>
                                            </div>
                                             <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Preço</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido_cliente['preco_pedido'];?></span>
                                            </div>
                                             <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Entregador</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido_cliente['cpf_entregador'];?></span>
                                            </div>
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