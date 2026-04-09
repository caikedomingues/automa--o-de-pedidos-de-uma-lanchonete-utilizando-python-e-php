


<?php

    # Ira possibilitar o acesso ao valor (tipo de sessão
    # como a de um usuário ou de um entregador, por exemplp) das sessões criadas.
    session_start();

    # Irá importar as classes que serão utilizadas no arquivo 
    require_once '../classes/BancoDeDados.php';
    require_once '../classes/Entregadores.php';

    # Ira instanciar a classe de banco de dados.
    $banco = new BancoDeDados();

    # Ira conter a conexão da classe banco de dados.
    $conexao = $banco->conexaoBanco();

    # Ira instanciar a classe entregadores que recebe
    # como argumento em seu construtor a conexão
    # com o banco de dados.
    $entregador = new Entregadores($conexao);

    # Ira verificar se a requisição enviada ao servidor é do tipo POST
    # ou seja, se o botão de tipo submit foi apertado. Dessa forma só
    # processaremos o formulário se houver dados.
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        # Ira coletar o cpf do entregador logado
        $cpf = $_SESSION['cpf_entregador'];

        # Ira coletar os dados inseridos no formulário
        $nome_entregador = $_POST['nome_entregador'];
        $telefone_entregador = $_POST['telefone_entregador'];
        $veiculo = $_POST['veiculo'];
        $senha_entregador = $_POST['senha_entregador'];

        # Irá settar os valores do formulário na classe de entregadores. 
        $entregador->setcpf_entregador($cpf);
        $entregador->setnome_entregador($nome_entregador);
        $entregador->settelefone_entregador($telefone_entregador);
        $entregador->setveiculo($veiculo);
        $entregador->setsenha_entregador($senha_entregador);

        # Ira chamar a função de edição de entregadores.
        $entregador->editarEntregador();

    }

?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <title>Lanchonete</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    </head>
    <body class="bg-light">

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow border-0 rounded-4 overflow-hidden">
                        <div class="position-relative" style="height: 160px;">
                            <img src="../imagens/entregadoredicao.avif" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.5);">
                            <div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3">
                                <h2 class="h4 fw-bold text-white mb-0">Atualizar Cadastro</h2>
                                <p class="text-white-50 small">Mantenha seus dados de entregador em dia</p>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form action='' method="post" class="needs-validation">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary" for="nome_entregador">Altere o nome</label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-person text-warning"></i></span>
                                        
                                       <input type="text" class="form-control" name="nome_entregador" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary" for="telefone_entregador">Altere o telefone</label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-whatsapp text-warning"></i></span>

                                         <input type="text" class="form-control" name="telefone_entregador" autocomplete="off" required>
                                    </div>
                                   </div>

                                <div class="mb-3">

                                    <label class="form-label fw-semibold text-secondary" for="veiculo">Altere o veiculo</label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white"><i class="bi bi-bicycle text-warning"></i></span>

                                        <input type="text" class="form-control" name="veiculo" autocomplete="off" required>
                                     </div>
                                </div>

                                <div class="mb-4">

                                    <label class="form-label fw-semibold text-secondary" for="senha_entregador">Altere a sua senha</label>

                                    <div class="input-group">
                                         <span class="input-group-text bg-white"><i class="bi bi-lock text-warning"></i></span>

                                         <input type="text" class="form-control"name="senha_entregador" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">

                                    <button type="submit" class="btn btn-warning fw-bold py-2 rounded-pill shadow-sm"><i class="bi bi-check-lg me-2"></i>Salvar Alterações</button>
                                    
                                    <a href="StatusEntrega.php" class="btn btn-outline-secondary py-2 rounded-pill">Cancelar</a>
                              </div>

                            </form>
                           </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
  
</html>