
<?php
    # Classe que irá conter os metodos e atribuições da classe Produtos  
    class Produto{

        # Irá conter a conexão com o banco de dados.
        private $conexao;

        # Ira conter os nomes dos produtos que iremos cadastrar
        private string $nome_produto;

        # ira conter os  preços dos produtos que iremos cadastrar.
        private string $preco;

        # Ira conter as categorias do produtos cadastrados.
        private string $categoria;

        # Método construtor que irá nos conectar ao banco de dados. A função ira receber como argumento a variável conexão que irá
        # conter o valor retornado pelo método de conexão da classe
        # BancoDeDados.
        public function __construct($conexao){

            $this->conexao = $conexao;
        }

        # Metodos setters e getters que irão coletar e acessar os valores
        # passados pela página que iremos instanciar a classe de produtos.
        public function setnome_produto($nome_produto){

            $this->nome_produto = $nome_produto;
        }

        public function getnome_produto(){

            return $this->nome_produto;
        }

        public function setpreco($preco){

            $this->preco = $preco;
        }

        public function getpreco(){

            return $this->preco;
        }

        public function setcategoria($categoria){

            $this->categoria = $categoria;
        }

        public function getcategoria(){

            return $this->categoria;
        }

        # Função que irá cadastrar os produtos no banco de dados.
        public function cadastrarProduto(){

            # Irá inspecionar o bloco de código com o objetivo de 
            # capturar possiveis erros de execução.
            try{

                # Irá verificar se uma sessão foi ou não criada.
                # Basicamente, a estrutura irá verificar se a
                # superglobal existe ou se o seu valor é diferente
                # de true.  
                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                    # Se a condição do if for verdadeira, vamos imprimir
                    # essa mensagem e disponibilizar para o adm o link
                    # que o encaminhara para a página de login de 
                    # administrador.
                    die("<p>Por favor, realize o login para ver os produtos</p> <a href='index.php'> Voltar a página de login</a");

                }else{

                    # Se a sessão for criada, vamos iniciar o processo de
                    # inserção dos dados no banco. Dessa vez não será
                    # necessário realizar validações no método, pois,
                    # os inputs que iremos utilizar irão realizar essas
                    # verificações. Observação: Vamos utilizar rótulos
                    # que irão representar os valores que serão indseridos.
                    $comando_insercao = "INSERT INTO produtos (nome_produto, preco, categoria) VALUES(:nome_produto, :preco, :categoria)";

                    # Ira garantir que todo comando executado após
                    # o execute seja considerado como texto. Dessa forma
                    # o sistema irá executar apenas o comando especificado
                    # na variável comando_insercao.  
                    $resultado_insercao = $this->conexao->prepare($comando_insercao);

                    # Irá executar o comando de inserção usando os
                    # rótulos que definimos anteriormente.
                    $resultado_insercao->execute([':nome_produto'=>$this->getnome_produto(), ':preco'=>$this->getpreco(), ':categoria'=>$this->getcategoria()]);
                    
                    # Mensagem de sucesso da inserção
                    echo "Produto cadastrado com sucesso";
                }

                    
            }catch(PDOException $erro){ 

                # Exceção que irá lidar com erros relacionados a operações
                # no banco de dados. Nesse caso, iremos encerrar a execução e imprimir essa mensagem.
                die("Falha na inserção do produto: ".$erro->getMessage());
            }

        }

        # Função que ira mostrar para o administrador todos os produtos
        # disponiveis na lanchonete.
        public function listarProdutos(){

            # Irá inspecionar o bloco de código com o objetivo de capturar
            # possiveis erros de execução.
            try{

                # Ira verificar se uma sessão foi iniciada. Basicamente,
                # o if irá verificar se a superglobal existe ou se o
                # seu valor é diferente de true.
                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                    # Irá encerrar a execução do método e imprimirá
                    # essa mensagem que irá guiar o usuário de volta
                    # para a página de login de administrador.
                    die("<p>Por favor, realize um login para ver as informações dos produtos</p><a href='index.php'>Voltar a página de login</a>");

                }else{

                    # Se a sessão existir, vamos iniciar o processo
                    # que irá mostrar todos os produtos cadastrados.
                    $consulta_produtos = "SELECT * FROM produtos";

                    # Irá garantir que todo comando após o execute
                    # seja considerado como texto, dessa forma, iremos
                    # garantir que apenas o comando definido na variável
                    # $consulta_produtos seja executado.
                    $resultado_consulta = $this->conexao->prepare($consulta_produtos);

                    # Irá executar o comando de consulta.
                    $resultado_consulta->execute();

                    # Irá acessar todas as linhas encontradas pelo sistema
                    # e criará um array associativo que irá possibilitar 
                    # o acesso dos valores através do nome das colunas
                    # da tabela consultada. 
                    $produtos = $resultado_consulta->fetchAll(PDO::FETCH_ASSOC);

                    # Ira verificar se a consulta retornou dados.
                    if($produtos){

                        # Se a tabela possuir valores, vamos apenas
                        # retornar a lista de dados. Vamos fazer isso
                        # por que na página que irá conter as informações
                        # nós vamos criar um foreach que irá percorrer
                        # os valores retornados e ira exibi-los em uma
                        # div que estilizara a página de produtos.
                        return $produtos;

                    }else{

                        # Mensagem que a função irá retornar caso o 
                        # sistema não tenha dados registrados
                        return "Não há produtos cadastrados";
                    }
                }

            }catch(PDOException $erro){

                # Exceção que irá lidar com operações no banco de dados.
                # Nesse caso, iremos encerrar a execução do método
                # e imprimir essa mensagem.
                die("Falha na consulta dos dados: ".$erro->getMessage());
            }

        }

        # Função que irá excluir o produto e os pedidos entregues
        # relacionados aquele produto. A função irá receber como
        # argumento o id que foi coletado pelo input hidden da
        # página de produtos.
        public function excluirProduto($id_produto){
            # Ira inspecionar o bloco de código com o objetivo de capturar possiveis
            # erros de execução.
            try{

                # Irá verificar se uma sessão foi criada. Basicamente a estrutura irá verificar
                # se a superglobal $_SESSION existe ou se o seu valor é diferente de true.
                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){
                    
                    # Se a condição do if for verdadeira, vamos imprimir essa mensagem e encerrar a execução do método.
                    die("<p> Por favor, realize login para excluir um produto</p> <a href='index.php'>Voltar a página de login</a>");

                }else{

                    # Caso o usuário crie uma sessão vamos iniciar o processo de exclusão das tabelas pedidos (que possui uma coluna
                    # da tabela produtos como chave estrangeira) e produtos. Para evitar erros no historico de entregas a caminho,
                    # vamos verificar se o item que será excluido possui o seu status como 'Entregue', ou seja, se o pedido que envolve
                    # aquele produto ja foi finalizado.

                    # Ira conter o comando de consulta do dado. Observação: o ':id_produto' é um rótulo que representa o id que esta sendo
                    # passado para a consulta. A consulta irá buscar os pedidos que possuem o id do produto excluido e o seu status de
                    # entrega igual a 'Pedido a caminho'.
                    $consulta_pedidos = "SELECT * FROM pedidos WHERE produto_pedido = :id_produto AND status_entrega ='Pedido a caminho'";

                    # Ira garantir que todo comando após o execute seja interpretado como texto. Dessa forma,
                    # evitaremos que o sistema execute comandos que não foram especificados na variável
                    # consulta_pedidos
                    $resultado_consulta = $this->conexao->prepare($consulta_pedidos);

                    # Ira executar o comando de consulta utilizando o id passado como argumento.
                    $resultado_consulta->execute([':id_produto' =>$id_produto]);

                    # Ira contar a quantidade de linhas encontradas
                    # pelo banco.
                    $pedidos_a_caminho = $resultado_consulta->rowCount();

                    # Ira verificar se há algum registro de entregas a caminho existe no banco do sistema.
                    if($pedidos_a_caminho > 0){
                        
                        # Se essa condição for verdadeira, vamos imprimir essa mensagem e encerrar a execução do
                        # método.
                        die("Você não pode apagar produtos que estão a caminho para entregas");

                    }else{

                        # Caso o pedido nao tenha aquele produto como 'entrega a caminho', vamos iniciar o processo
                        # de exclusão dos dados.

                        # Ira conter o comando que exclui pedidos relacionados ao produto
                        $exclusao_pedidos = "DELETE FROM pedidos WHERE produto_pedido = :id_produto";

                        # Ira conter o comando que exclui o produto do sistema
                        $exclusao_produtos = "DELETE FROM produtos WHERE id_produto = :id_produto";

                        # Prepares que evitarão que outros comandos sejam executados no sistema.
                        $resultado_exclusao_pedidos = $this->conexao->prepare($exclusao_pedidos);

                        $resultado_exclusao_produtos = $this->conexao->prepare($exclusao_produtos);

                        # Irão executar os comandos de exclusão do sistema
                        $resultado_exclusao_pedidos->execute([':id_produto'=>$id_produto]);

                        $resultado_exclusao_produtos->execute([':id_produto'=>$id_produto]);
                        
                    }
                }

            }catch(PDOException $erro){
                
                # Ira lidar com erros relacionados as operações com o banco de dados. Nesse caso
                # iremos encerrar a execução do método e imprimiremos essa mensagem.
                die("Falha na exclusão do produto: ".$erro->getMessage());
            }

        }

        public function editarProduto($id_produto){

            try{

                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                    die("<p>Por favor, realize login para editar um produto</p><a href='index.php'>Voltar a página de login</a>");

                }else{

                    $comando_atualizacao = "UPDATE produtos SET nome_produto = :nome_produto, preco = :preco,
                    categoria = :categoria  WHERE id_produto = :id_produto";

                    $resultado_atualizacao = $this->conexao->prepare($comando_atualizacao);

                    $resultado_atualizacao->execute([':nome_produto'=>$this->getnome_produto(), ':preco'=>$this->getpreco(), ':categoria'=>$this->getcategoria(),
                    ':id_produto'=>$id_produto]);

                    echo "Produto Atualizado";
                }


            }catch(PDOException $erro){

                die("Falha na atualização dos produtos: ".$erro->getMessage());

            }

        }

    }

?>