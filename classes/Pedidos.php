
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
                        die("Realize o login para ver as suas entregas");

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
            public function atualizarStatus($codigo_pedido){

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

                    # Mensagem de sucesso da execução do código.
                    echo "Status atualizado com sucesso, o pedido será
                    atualizado em breve";


                }catch(PDOException $erro){
                    # Exceção que irá lidar com operações no banco de dados. Nesse caso, ele ira encerrar a execução do
                    # método e imprimir mensagens.
                    die("Falha na atualização do status: ".$erro->getMessage());

                }

            }


}

?>