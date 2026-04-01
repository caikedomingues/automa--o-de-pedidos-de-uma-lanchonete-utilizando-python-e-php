
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
                    echo "<p>Por favor, realize um login para cadastrar produtos</p>";

                    echo "<a href='index.php'>Voltar a página de login</a>";

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

        public function listarProdutos(){

            try{

                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                    echo "<p>Por favor, realize um login para ver as informações dos produtos</p>";

                    echo "<a href='index.php'> Voltar a página de login</a>";

                }else{

                    $consulta_produtos = "SELECT * FROM produtos";

                    $resultado_consulta = $this->conexao->prepare($consulta_produtos);

                    $resultado_consulta->execute();

                    $produtos = $resultado_consulta->fetchAll(PDO::FETCH_ASSOC);

                    if($produtos){

                        return $produtos;

                    }else{

                        return "Não há produtos cadastrados";
                    }
                }

            }catch(PDOException $erro){

                die("Falha na consulta dos dados: ".$erro->getMessage());
            }

        }

       
    }

?>