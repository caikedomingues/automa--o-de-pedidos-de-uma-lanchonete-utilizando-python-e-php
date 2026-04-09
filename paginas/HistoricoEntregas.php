<!DOCTYPE HTML>
<html lang="pt-br">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title>Lanchonete</title>
    </head>

    <body class="bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark fw-bold">
                            Histórico de Entregas Realizadas
                        </div>
                        <div class="card-body">
                            <div class="p-3 bg-white border rounded">

                                <?php
                                    
                                    # Ira permitir que o sistema acesse os dados da superglobal $_SESSION de
                                    # entregadores.
                                    session_start();

                                    # Ira importar para o arquivo as classes que serão utilizadas nessas
                                    # páginas
                                    require_once '../classes/BancoDeDados.php';
                                    require_once '../classes/pedidos.php';
                                    
                                    # Ira instanciar a classe banco de dados que possui a conexão
                                    # com o servidor.
                                    $banco = new BancoDeDados();
                                    
                                    # Ira conter a conexão com o banco de dados.        
                                    $conexao = $banco->conexaoBanco();
                                    
                                    # Ira instanciar a classe de Pedidos    
                                    $pedidos = new Pedidos($conexao);
                                    
                                    # Irá verificar se o cpf do usuário
                                    # logado existe
                                    if(isset($_SESSION['cpf_entregador'])){     
                                        # Se essa condição for verdadeira, vamos atribuir
                                        # o valor do cpf no setter de
                                        # cpfs de entregador da classe 
                                        # pedidos.
                                        $pedidos->setcpf_entregador($_SESSION['cpf_entregador']);
                                    }

                                    
                                    # Ira chamar o método que imprimi
                                    # os dados
                                    $pedidos->historicoEntregas();
                                ?>

                                
                            </div>  
                            </div>
                        </div>

                        <div class="card-footer text-muted small">

                            Página de uso exclusivo de entregadores autorizados.
                        </div>
                    </div>
                </div>
                        


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

</html>