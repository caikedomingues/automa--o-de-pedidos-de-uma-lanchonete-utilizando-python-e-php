
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

        # 
        public function __construct($conexao){

            $this->conexao = $conexao;
        }

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

        public function cadastrarProduto(){

            try{

                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                    echo "<p>Por favor, realize um login para cadastrar produtos</p>";

                    echo "<a href='index.php'>Voltar a página de login</a>";

                }else{

                    $comando_insercao = "INSERT INTO produtos (nome_produto, preco, categoria) VALUES(:nome_produto, :preco, :categoria)";

                    $resultado_insercao = $this->conexao->prepare($comando_insercao);

                    $resultado_insercao->execute([':nome_produto'=>$this->getnome_produto(), ':preco'=>$this->getpreco(), ':categoria'=>$this->getcategoria()]);
                    
                    echo "Produto cadastrado com sucesso";
                }

                    
            }catch(PDOException $erro){ 

                die("Falha na inserção do produto: ".$erro->getMessage());
            }

        }
    }

?>