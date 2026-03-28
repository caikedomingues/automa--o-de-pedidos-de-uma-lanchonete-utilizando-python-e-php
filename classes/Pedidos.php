
<?php

# Classe que irá conter os métodos e atributos da classe Pedidos 
class Pedidos{

    # Ira conter a conexão com o banco de dados, como não iremos 
    # utilizar essa variável em outras classes, ele não precisará
    # ser encapsulada
    private $conexao;

    # Nessa classe, boa parte dos nossos métodos serão de realizações de 
    # consultas usando o cpf do entregador, logo como não lidaremos com
    # inserções, vamos encapsular apenas a variável de cpf do entregador(
    # a unica variável que irá receber valores).
    private string $cpf_entregador;

    # Metodo construtor que ira conter a conexão com o banco de dados
    public function __construct($conexao){

        $this->conexao = $conexao;
    }

    # Encapsulamento da variável de cpf dos entregadores.

    public function setcpf_entregador($cpf_entregador){

        $this->cpf_entregador = $cpf_entregador;
    }

    public function getcpf_entregador(){

        return $this->cpf_entregador;
    }


    # Função que será responsavel por consultar no banco de dados, os pedidos pendentes dos entregadores.
    public function visualizarPedidos(){

                # Ira inspecionar o bloco de código com o objetivo de capturar possiveis erros de execução.
                try{

                    # Ira verificar a existência de uma sessão (criação de um login no sistema) através
                    # da verificação da existência da variável superglobal SESSION['login_entregador'] ou
                    # da verificação do valor recebido pela variável superglobal ($_SESSION).
                    if(!isset($_SESSION['login_entregador']) || $_SESSION['login_entregador'] != true){

                        # Se a vraiável não existir ou tiver o false como valor, vamos encerrar a execução
                        # do sistema e imprimir essa mensagem.
                        echo("Realize o login para ver as suas entregas");

                        echo "<br><a href='loginEntregador.php'>Voltar a página de login</a>";

                    }else{

                        # Se uma sessão for criada, vamos iniciar o processo de consulta dos dados e criação de botões de atualizações de status das 
                        # entregas.

                        # Ira conter o comando que ira consultar as informações das entregas pendentes usando o cpf do entregador logado no sistema.
                        # Observação: ":cpf_entregador" é um rótulo que irá representar o cpf do entregador que iremos utilizar na consulta.
                        $consulta_entregas = "SELECT codigo_pedido, produto_pedido, dono_pedido, data_pedido, endereco, preco_pedido, status_entrega FROM pedidos WHERE status_entrega = 'Pedido a caminho' AND cpf_entregador = :cpf_entregador";

                        # Prepare que irá indicar tudo que vem após o execute é apenas texto, dessa forma, o sistema
                        # executará apenas o comando que definimos anteriormente.
                        $resultado_consulta = $this->conexao->prepare($consulta_entregas);

                        # Após o filtro dos dados, iremos executar o script de consulta dos dados.
                        $resultado_consulta->execute(['cpf_entregador'=>$this->getcpf_entregador()]);

                        # Iremos acessar todas as linhas encontradas e criaremos um array associativo
                        # (PDO::FETCH_ASSOC) que possibilita o acesso dos valores através dos nomes
                        # das colunas definidas no SELECT.
                        $entregas = $resultado_consulta->fetchAll(PDO::FETCH_ASSOC);

                        # Ira verificar se há a existência de registros na consulta.
                        if($entregas){

                            # Caso exista registros na tabela, vamos percorrer a lista de valores com o objetivo
                            # de imprimir os valores e criar os botões
                            for($i = 0; $i < count($entregas); $i++){

                                # Ira acessar os valores através dos nomes das colunas e criara o código html que contera os botões de atualização de status. O input
                                # hidden ira coletar os valores definidos no value (valor da coluna codigo_pedido) que iremos utilizar para realizar as atualizações
                                # no sistema. O name serve para indicar para o post o nome do campo definido no value.

                                # Criação do formulário.
                                echo "<form action='' method='post'>"."<input type='hidden' value='".$entregas[$i]['codigo_pedido']."'  name='codigo_pedido'>". 
                                
                                # Impressão dos valores consultados.
                                "codigo: ".$entregas[$i]['codigo_pedido']. " | produto: ".$entregas[$i]['produto_pedido']. " | dono do pedido: ".$entregas[$i]['dono_pedido']." | data: ".$entregas[$i]['data_pedido']. " | endereco: ".$entregas[$i]['endereco']." | preco: ". $entregas[$i]['preco_pedido']. " | status: ".$entregas[$i]['status_entrega']."<br>"
                                
                                # Criação do botão de atualização de status.
                                ."<button type='submit' class='btn btn-success btn-sm'>Atualizar Status</button>
                                            </form>"."<br><hr>";

                            }

                        }else{

                            # Caso não exista registros, vamos apenas imprimir essa mensagem.
                            echo "você ainda não tem entregas  pendentes registradas";
                        }
                    }
                }catch(PDOException $erro){

                    # Ira lidar com erros relacionados as operações realizadas no banco de dados. Nesse caso
                    # iremos encerrar a execução do método e imprimir essa mensagem.
                    die("Falha na consulta dos dados: ".$erro->getMessage());
                }
            }

            # Função que irá atualizar os status das entregas do entregador cadastrado.
            public function atualizarStatus(){

                # Irá inspecionar o bloco de código com o objetivo
                # de capturar possiveis erros de execução.
                try{

                    # Ira conter o comando que irá atualizar o
                    # status do pedido utilizando o código coletado
                    # pelo input hidden. 
                    $Atualizacao_status = "UPDATE pedidos SET status_entrega ='Entregue' WHERE codigo_pedido = :codigo_pedido AND status_entrega = 'Pedido a caminho'";

                    # Ira indicar para o sistema que tudo que for
                    # executado após o execute será considerado
                    # como texto e não comando, dessa forma, iremos
                    # garantir que o sistema execute apenas o SQL
                    # feito anteriormente.
                    $resultado_atualizacao_status = $this->conexao->prepare($Atualizacao_status);

                    # Ira executar o comando de atualização usando a
                    # variável superglobal POST que ira conter
                    # o valor coletado pelo input hidden.
                    $resultado_atualizacao_status->execute([':codigo_pedido'=>$_POST['codigo_pedido']]);

                    # Ira atualizar a quantidade de pedidos feitos
                    # pelos clientes usando o cpf do entregador logado.
                    # Observação O ":cpf_entregador" é o rótulo que irá
                    # representar o cpf do entregador.
                    $atualizacao_quantidade_entregas = "UPDATE entregadores SET quantidade_pedidos_feitos = quantidade_pedidos_feitos + 1 WHERE cpf_entregador = :cpf_entregador";

                    # Ira evitar os SQL Injection (como explicamos anteriormente).
                    $resultas_atualizacao_quantidade = $this->conexao->prepare($atualizacao_quantidade_entregas);

                    # Irá executar a atualização da coluna de quantidade
                    # de pedidos feitos usando o cpf do entregador logado. 
                    $resultas_atualizacao_quantidade->execute([':cpf_entregador'=>$this->getcpf_entregador()]);


                }catch(PDOException $erro){
                    # Exceção que irá lidar com operações no banco de dados. Nesse caso, ele ira encerrar a execução do
                    # método e imprimir mensagens.
                    die("Falha na atualização do status: ".$erro->getMessage());

                }

            }
            # Será responsável por mostrar o historico de entregas
            # do entregador.
            public function historicoEntregas(){

                # Ira verificar a existência da sessão. Basicamente,
                # ele irá verificar se a superglobal existe ou se
                # o seu valor é diferente de verdadeiro.
                if(!isset($_SESSION['login_entregador']) || $_SESSION['login_entregador'] != true){

                    # Se essa condição for verdadeira, vamos imprimir
                    # essa mensagem e disponibilizar para o usuário
                    # voltar a página de login de entregador..
                    echo("Realize o login para ver o seu historico de entregas");

                    echo "<br><a href='loginEntregador.php'>Voltar a página de login</a>";
                }else{

                    # Irá inspecionar o bloco de código com o objetivo
                    # de capturar possiveis erros de execução.
                    try{

                        # Ira conter a consulta das entregas realizadas
                        # pelo entregador cadastrado no sistema.
                         $consulta_entregas = "SELECT codigo_pedido, produto_pedido, dono_pedido, status_entrega, data_pedido, endereco, preco_pedido FROM pedidos WHERE cpf_entregador = :cpf_entregador AND status_entrega = 'Entregue'";
                        
                         # Ira garantir que tudo que for executado
                         # após o execute seja interpretado como texto,
                         # dessa forma, vamos garantir que o unico
                         # comando executado seja o que definimos
                         # anteriormente.
                         $resultado_consulta = $this->conexao->prepare($consulta_entregas);
                        
                        # Nessa etapa vamos executar o comando filtrado pelo prepare.
                         $resultado_consulta->execute([':cpf_entregador'=>$this->getcpf_entregador()]);
                          
                         # Ira acessar todas as linhas retornadas e criara um array associativo que possibilitara
                         # o acesso aos dados através dos nomes das colunas solicitadas no SELECT
                         $entregas = $resultado_consulta->fetchAll(PDO::FETCH_ASSOC);
                        
                         # Irá verificar se há existência de registros
                         # na consulta realizada.
                         if($entregas){

                            # Caso a consulta retorne registros, vamos
                            # criar um for que irá percorrer a lista
                            # de valores encontrados com o objetivo 
                            # de imprimir na página, os valores 
                            # encontrados.
                            for($i=0; $i < count($entregas); $i++){

                                # Impressão dos valores encontrados.
                                echo "Código: ".$entregas[$i]['codigo_pedido']." | Produto: ".$entregas[$i]['produto_pedido']." | Dono do pedido: ".$entregas[$i]['dono_pedido']." | Status: ".$entregas[$i]['status_entrega']." | Data: ".$entregas[$i]['data_pedido']. " | endereço: ".$entregas[$i]['endereco']." | preco: ".$entregas[$i]['preco_pedido']."<br><hr>";

                            }


                         }else{

                            # Caso o usuário não tenha entregas concluidas, vamos imprimir essa mensagem.
                            echo "Você ainda não realizou entregas";
                         }


                    }catch(PDOException $erro){

                        # Ira lidar com erros relacionados a operações no
                        # banco de dados. Nesse caso, vamos encerrar a 
                        # execução do método e imprimir essa mensagem.s
                        die("Falha na consulta dos dados: ".$erro->getMessage());

                    }
                   


                }
            }

            # Função que irá mostrar todas as entregas concluidas para
            # o administrador
            public function todosPedidosEntregues(){

                # Irá inspecionar o bloco de código com o objetivo de
                # capturar possiveis erros de execução do bloco.
                try{

                    # Ira verificar a existência da sessão do usuário. Para realizar a validação,
                    # o sistema ira verificar se a superglobal existe
                    # ou se o valor da superglobal é diferente de true.
                    if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                        # Se essa condição for verdadira, vamos
                        # imprimir essa mensagem e disponibilizar
                        # um link que guiara o usuário para a página
                        # de login.
                        echo "É necessário realizar login antes de visualizar os pedidos";

                        echo "<br><a href='index.php'>Voltar a página de login</a>";

                    }else{

                        # Se a sessão for criada corretamente, vamos 
                        # iniciar o processo de consulta no banco de
                        # dados.

                        # Irá conter o comando que irá consultar os dados.
                        $consulta_entregas = "SELECT * FROM pedidos WHERE status_entrega = 'Entregue'";

                        # Irá garantir que qualquer comando executado após o execute seja interpretado
                        # como texto, dessa forma, o sistema só ira
                        # executar o comando select que definimos
                        # anteriormente.
                        $resultado_consulta = $this->conexao->prepare($consulta_entregas);

                        # Irá executar apenas o SELECT definido na
                        # variável consulta.
                        $resultado_consulta->execute();

                        # Irá acessar todas as linhas encontradas e criará um array associativo que possibilitará
                        # o acesso dos dados através dos nomes das colunas
                        # definidas no banco.
                        $entregas_realizadas = $resultado_consulta->fetchAll(PDO::FETCH_ASSOC);

                        # Irá verificar se a consulta retornou registros.
                        if($entregas_realizadas){ 

                            # Se a consulta retornar registros, vamos percorrer a lista de dados usando um for
                            # com o objetivo de acessar e imprimir os dados.  
                            for($i=0; $i < count($entregas_realizadas); $i++){

                                echo "Código: ". $entregas_realizadas[$i]['codigo_pedido']." | Produto: ".$entregas_realizadas[$i]['produto_pedido']." | dono: ".$entregas_realizadas[$i]['dono_pedido']." | data: ".$entregas_realizadas[$i]['data_pedido']." | endereço: ".$entregas_realizadas[$i]['endereco']." | preço: ".$entregas_realizadas[$i]['preco_pedido']." | cpf do entregador: ".$entregas_realizadas[$i]['cpf_entregador']."<br><hr>";
                            }

                        }else{

                            # Caso a consulta não retorne nenhum dado,
                            # vamos imprimir essa mensagem.
                            echo "Não há entregas concluidas no momento";
                        }
                    }


                }catch(PDOException $erro){

                    # Ira lidar com erros nas operações com o banco de dados. Nesse caso, vamos encerrar a conexão com o
                    # banco e imprimir essa mensagem. 
                    die("Falha na consulta das entregas: ".$erro->getMessage());

                }

            }


}

?>