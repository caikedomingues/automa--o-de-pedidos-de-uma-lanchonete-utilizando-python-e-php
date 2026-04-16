

<?php

    # Ira permitir o acesso ao valor definido na superglobal
    # $_SESSION (se o usuário realizar um login)
    session_start();

    # Irá importar as classes que serão utilizadas no arquivo 
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Produto.php';

    # Irá instanciar a classe banco de dados que conterá a conexão
    # com o banco de dados.
    $banco = new BancoDeDados();

    # Ira conter a conexão com o banco de dados.
    $conexao = $banco->conexaoBanco();

    # Ira instanciar a classe produtos que recebe como argumento
    # a conexão com o banco de dados.
    $produto = new Produto($conexao);

    # Ira verificar se a requisição enviada ao servidor é igual a um
    # POST (envio de dados do servidor), ou seja, se o botão de tipo
    # submit foi apertado. Dessa forma, o sistema só processará os dados
    # do formulário se houver o envio dos valores.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # Se a requisição for um post, vamos iniciar o processo de edição
        # dos dados.

        # Ira usar a superglobal $_GET que irá coletar o valor do id
        # passado no link da página.
        $id_produto = $_GET['id'];

        # Ira coletar os dados informados no formulário usando os names
        # definidos nos inputs do formulário.
        $nome_produto = $_POST['nome_produto'];
        $preco = $_POST['preco'];
        $categoria = $_POST['categoria'];
        
        # Ira atribuir os valores coletados nos setters da classe
        # com o objetivo de acessar esses dados via métodos getters.
        $produto->setnome_produto($nome_produto);
        $produto->setpreco($preco);
        $produto->setcategoria($categoria);

        # Chamada do método usando como argumento o id passado no link
        # da página.
        $produto->editarProduto($id_produto);
    }


?>
<!DOCTYPE html>
<html lang = "pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport-content=width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <title>Lanchonete</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>    

    <body class="bg-light">

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow border-0">
                        <h4 class="text-center pt-4">Atualize os dados do produto</h4>
                    

        <div class="card-body p-4">
            <div class="text-center mb-4">

                <img src="../imagens/lanchesatualizados.jpg" alt="Imagem do lanche" class="img-fluid rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
            </div>

        <form action='' method="post">
            <div class="mb-3">
                <label for="nome_produto" class="form-label small fw-bold text-secondary">Nome do produto</label>
                <input type="text" class="form-control form-contro-lg" name="nome_produto" required placeholder="Informe o novo nome do produto" autocomplete="off">
            </div>
            
            <div class="mb-3">
                <label for="preco" class="form-label small fw-bold text-secondary">Preço</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">R$</span>
                    <input type="number" name="preco" required placeholder="Informe o novo preço do produto" autocomplete="off" class="form-control form-control-lg border-start-0">
                </div>
            </div>
            
            <div class="mb-4">
                <label for="categoria" class="form-label small fw-bold text-secondary">Categoria do produto(lanches, salgados, porções, bebidas ou sobremesas)</label>
                <select class="form-select form-select-lg" name="categoria" id="categoria" required>
                    <option value="" selected disabled>Escolha uma opção...</option>
                    <option value="lanches">Lanches</option>
                    <option value="salgados">Salgados</option>
                    <option value="porções">Porções</option>
                    <option value="bebidas">Bebidas</option>
                    <option value="sobremesas">Sobremesas</option>
                </select>
            </div>
           
            <div class="d-grid">
                <button type="submit" class="btn btn-warning btn-lg fw-bold shadow-sm">Atualizar Informações</button>
                <a href="InformacoesProdutos.php" class="btn btn-outline-secondary py-2 rounded-pill">Cancelar</a>
        </div>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>