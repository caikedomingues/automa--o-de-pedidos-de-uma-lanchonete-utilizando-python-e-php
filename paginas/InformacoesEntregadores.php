

<?php

    # Irá permitir o acesso aos valores definido na variável $_SESSION
    # (valor que identifica o tipo de sessão que está sendo criada)
    session_start();

    # Irá importar as classes que serão utilizadas no arquivo.
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Entregadores.php';

    # Ira instanciar a classe banco de dados que contém a conexão
    # com o banco de dados.
    $banco = new BancoDeDados();
    
    # Ira conter o valor retornado do metodo de conexão da classe 
    # Banco de dados. 
    $conexao = $banco->conexaoBanco();

    # Ira instanciar/criar a classe entregadores que recebe como
    # argumento do seu construtor a conexão com o banco de dados.
    $entregador = new Entregadores($conexao);

    # Ira verificar se a requisição enviada ao servidor é do tipo POST
    # (envio de dados ao servidor).
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # Se essa condição for verdadeira, significa que o usuário
        # clicou no botão de exclusão que irá realizar o processo
        # de exclusão do entregador.

        # SuperGlobal que irá coletar o valor do cpf presente no form
        # hidden. Observação: o $_POST identifica o valor atraves do name
        # definido na criação do input. 
        $cpf_entregador = $_POST['cpf_entregador'];

        # Ira passar para o setter da classe o valor coletado pelo
        # $_POST. Dessa forma poderemos acessar os valores usando os
        # getters definidos na classe.
        $entregador->setcpf_entregador($cpf_entregador);

        # Ira chamar o metodo de exclusão definido na classe,
        $entregador->excluirEntregador();

        # Ira voltar para a página de informações de entregadores atualizada.
        header("Location: InformacoesEntregadores.php");

        # Ira encerrar a execução do script(exclusão dos dados)
        exit();
    }

    # Ira listar os entregadores cadastrados no sistema.
    $listarentregadores = $entregador->listarEntregadores();

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
                <img src="../imagens/imageminformacao.jpg" alt="imagem do entregador" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);">
                <div class="position-absolute top-50 start-50 translate-middle text-center w-100">
                    <h1 class="display-5 fw-bold text-white">Entregadores</h1>
                    <p class="text-white-50">Visualize os entregadores da lanchonete</p>
                </div>
        </div>
        <div class="row g-4">
            <!--Foreach que ira percorrer os valores retornados pela função de listar entregadores. Fizemos dessa maneira para
            garantir que os valores sejam mostrados dentro das
            divs definidos pelo bootstrap.-->
            <?php foreach($listarentregadores as $entregador):?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>   
                                <!--Nessa etapa iremos acessar os valores usando os nomes de cada coluna do item que esta sendo percorrido pelo foreach-->
                                <span class="badge bg-warning text-dark mb-2 px-3"><?php echo  $entregador['nome_entregador'];?></span>
                                <h5 class="card-title fw-bold text-dark mb-0">cpf: <?php echo " ". $entregador['cpf_entregador'];?></h5>
                                <small class="text-muted">Telefone:<?php echo " ".$entregador['telefone_entregador'];?></small> </small><br>
                                <small class="text-muted">Preço:<?php echo " ". $entregador['veiculo']?> </small><br>
                                <small class="text-muted">Quantidade de pedidos realizados: <?php echo " ".$entregador['quantidade_pedidos_feitos'];?> </small><br>
                        </div>
                      </div>
                      <hr class="text-light">
                      <div class="d-flex justify-content-end gap-2">
                        <!--Link que irá para a página de edição de entregadores. Vamos definir no link o valor do cpf
                        do entregador que será editado.-->
                        <a href="EditarEntregadores.php?cpf=<?php echo $entregador['cpf_entregador'];?>" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                            <i class="bi bi-info-circle me-1"></i> Editar Entregador
                        </a>
                        <!--Form que irá enviar os dados para a própria
                         página.-->
                        <form action='' method="post">
                            <!--Input que irá ter o id do produto que será excluido como valor (que será coletado pelo $_POST posteriormente).-->
                            <input type="hidden" name="cpf_entregador" value="<?php echo $entregador['cpf_entregador'];?>">

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