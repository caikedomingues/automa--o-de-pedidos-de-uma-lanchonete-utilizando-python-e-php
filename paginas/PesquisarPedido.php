
<?php

    # Ira possibilitar que o sistema acesse os valores da
    # superglobal SESSION, ou seja, o tipo de sessão que 
    # queremos acessar.  
    session_start();
    
    # Irá importar as classes que serão utilizadas no arquivo.
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Pedidos.php';

    # Ira instanciar a classe de banco de dados
    $banco = new BancoDeDados();

    # Ira conter a conexao com o banco de dados.
    $conexao = $banco->conexaoBanco();

    # Irá instanciar a classe Pedidos que recebe como argumento
    # a conexão com o banco de dados. 
    $pedidos = new Pedidos($conexao);

    # Lista que irá conter os valores retornados pela consulta.
    $resultado = [];

    # Ira verificar se a requisição enviada ao servidor é do
    # tipo POST('envio de dados'), dessa maneira, o sistema
    # só processara os dados do formulário se houver o envio
    # dos dados.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # superglobal que irá coletar os dados através dos names
        # definidos nos inputs do formulário.
        $codigo_pedido = $_POST['codigo_pedido'];

        # Ira atribuir na lista os valores retornados pelo método
        # de pesquisar pedidos.
        $resultado = $pedidos->buscarPedidos($codigo_pedido);

        # Irá verificar a quantidade de itens presentes na lista
        if(count($resultado) == 0){

            # Se a lista estiver vázia, significa que o método
            # não encontrou dados e retornou uma lista vázia. 
            echo "Não há pedidos com esse código";
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
<body class="bg-light">
    <div class="container py-5">
        
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-search text-warning display-4 mb-3"></i>
                        <h2 class="h4 fw-bold mb-3">Buscar Pedidos</h2>  
                        <form action="" method="post" class="row g-2">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-card-text"></i></span>
                                    <!--input que irá receber o codigo do pedido.-->
                                    <input type="text" name="codigo_pedido" required placeholder="Informe o codigo do pedido" class="form-control">
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
                    <?php foreach($resultado as $pedido): ?>
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 bg-warning text-center py-4">
                                    <i class="bi bi-person-badge display-1 text-white"></i>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <!--Após percorrer a lista, vamos imprimir os valores em cada div que organiza os dados dentro do card-->
                                            <span class="badge bg-success rounded-pill">Produto Pedido: <?php echo $pedido['produto_pedido'];?></span>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Código</small>
                                                <span class="fw-semibold"><?php echo $pedido['codigo_pedido'];?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">Dono do pedido</small>
                                                <span class="fw-semibold"><?php echo $pedido['dono_pedido'];?></span>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <small class="text-muted d-block">status da entrega</small>
                                                <span class="fw-semibold"><?php echo $pedido['status_entrega'];?></span>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Data do Pedido</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido['data_pedido'];?></span>
                                            </div>
                                             <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Endereço</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido['endereco'];?></span>
                                            </div>
                                             <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Preço</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido['preco_pedido'];?></span>
                                            </div>
                                             <div class="col-12 mt-2">
                                                <small class="text-muted d-block">Entregador</small>
                                                <span class="fw-semibold text-warning"><?php echo $pedido['cpf_entregador'];?></span>
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