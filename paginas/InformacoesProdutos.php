


<?php

    session_start();

    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Produto.php';

    $banco = new BancoDeDados();

    $conexao = $banco->conexaoBanco();

    $produto = new Produto($conexao);


    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id_produto_excluido = $_POST['id_produto'];

        $produto->excluirProduto($id_produto_excluido);

        header('Location: InformacoesProdutos.php');

        exit();
    }

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

    <body>

        <div class="container py-5">
            <div class="position-relative mb-5 rounded-4 overflow-hidden shadow-sm" style="height: 200px;">
                <img src="../imagens/alimentos.jpg" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);">
                <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                    <h1 class="display-5 fw-bold text-white">Produtos Disponiveis</h1>
                    <p class="text-white-50">Visualize os itens da lanchonete</p>
                </div>
        </div>
        <div class="row g-4">
            <?php foreach($listaprodutos as $item_lanchonete):?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-warning text-dark mb-2 px-3"><?php echo $item_lanchonete['categoria'];?></span>
                                <h5 class="card-title fw-bold text-dark mb-0">Produto: <?php echo $item_lanchonete['nome_produto'];?></h5>
                                <small class="text-muted">ID:<?php echo " ".$item_lanchonete['id_produto'];?></small> </small><br>
                                <small class="text-muted">Preço:<?php echo " ". $item_lanchonete['preco']?> </small><br>
                                <small class="text-muted">Quantidade de vendas: <?php echo " ".$item_lanchonete['quantidade_vendas'];?> </small><br>
                        </div>
                      </div>
                      <hr class="text-light">
                      <div class="d-flex justify-content-end gap-2">
                        <a href="EditarProduto.php?id=<?php echo $item_lanchonete['id_produto'];?>" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                            <i class="bi bi-info-circle me-1"></i> Editar Produto
                        </a>
                        <form action='' method="post">
                            <input type="hidden" name="id_produto" value="<?php echo $item_lanchonete['id_produto']?>">

                          <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-pill"><i class="bi bi-trash me-1"></i>Excluir</button>
                     </form>
                     </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            </div>
            
        </div>

        


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>