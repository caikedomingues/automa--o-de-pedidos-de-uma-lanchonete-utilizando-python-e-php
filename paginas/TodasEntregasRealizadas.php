<!DOCTYPE HTML>
<html lang="pt-br">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title>Lanchonete</title>
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
                            <li><a class="dropdown-item" href="EntregasaCaminho.php">A Caminho</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Consultas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="PesquisarEntregador.php">Entregadores</a></li>
                            <li><a class="dropdown-item" href="PesquisarPedido.php">Pedidos</a></li>
                            <li><a class="dropdown-item" href="PesquisarPedidosClientes.php">Pedidos dos clientes</a></li>
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
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark fw-bold">
                            Entregas Realizadas.
                        </div>
                        <div class="card-body">
                            <div class="p-3 bg-white border rounded">

                                <?php
                                    # Ira Permitir o acesso ao valor da
                                    # da variável $_SESSION que conterá
                                    # as informações da sessão.
                                    session_start();

                                    # Ira importar as classes que serão
                                    # utilizadas no sistema.
                                    require_once '../classes/BancoDeDados.php';
                                    require_once '../classes/Pedidos.php';

                                    # Ira instanciar o banco que irá conter a conexão com o banco de dados 
                                    $banco = new BancoDeDados();
                                    
                                    # Ira conter a conexão com o banco de dados.
                                    $conexao = $banco->conexaoBanco();
                                    
                                    # Ira instanciar a classe de Pedidos que receberá como argumento em seu
                                    # construtor a conexão com o banco
                                    # de dados.  
                                    $pedidos = new Pedidos($conexao);

                                    # Ira chamar o método que irá consultar os pedidos entregues no sistema.
                                    $pedidos->todosPedidosEntregues();

                                ?>

                                
                            </div>  
                            </div>
                        </div>

                        <div class="card-footer text-muted small">

                            Página de uso exclusivo do administrador 
                            do sistema.
                        </div>
                    </div>
                </div>
                        


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

</html>