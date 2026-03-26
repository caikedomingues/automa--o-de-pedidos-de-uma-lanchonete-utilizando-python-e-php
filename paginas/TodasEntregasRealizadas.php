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
                            Entregas Realizadas.
                        </div>
                        <div class="card-body">
                            <div class="p-3 bg-white border rounded">

                                <?php
                                    session_start();

                                    require_once '../classes/BancoDeDados.php';
                                    require_once '../classes/Pedidos.php';

                                    $banco = new BancoDeDados();

                                    $conexao = $banco->conexaoBanco();

                                    $pedidos = new Pedidos($conexao);

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