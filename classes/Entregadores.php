

<?php

    # Classe que irá conter os métodos e atributos dos entregadores do sistema.
    class Entregadores{

        # Atributos da classe: conexao (ira conter a conexão com o banco de dados), cpf_entregador(primary key), nome_entregador, telefone_entregador,senha_entregador, quantidade_pedidos_feitos.

        private $conexao;

        private string $cpf_entregador;

        private string $nome_entregador;

        private string $telefone_entregador;

        private string $senha_entregador;

        private int $quantidade_pedidos_feitos;

        # Metodo construtor: Serve para definirmos valores que a classe deve 
        # receber ao ser instanciada, no nosso caso, vamos definir que a classe
        # deve receber a conexão com o banco de dados.
        
        public function __construct($conexao_banco){

            $this->conexao = $conexao_banco;
        }

        # Métodos de encapsulamento: Servem para permitir que o usuário acesse as variáveis
        # privadas da classe de forma segura. Observação: o unico atributo que não iremos
        # encapsular é o da conexão já que o usuário não ira acessa-lo de forma direta.

        # Setters: Servem para coletar os valores das variáveis privadas. Elas recebem como
        # argumento o valor que a variável privada ira receber. Esse argumento será atribuido
        # como valor da variável privada. 

        public function setcpf_entregador($cpf_entregador){

            $this->cpf_entregador = $cpf_entregador;
        }


        public function setnome_entregador($nome_entregador){

            $this->nome_entregador = $nome_entregador;
        }

        public function settelefone_entregador($telefone_entregador){

            $this->telefone_entregador = $telefone_entregador;
        
        }

        public function setsenha_entregador($senha_entregador){

            $this->senha_entregador = $senha_entregador;

        }

        public function setquantidade_pedidos_feitos($quantidade_pedidos_feitos){

            $this->quantidade_pedidos_feitos = $quantidade_pedidos_feitos;

        }

        # Getters: Tem como objetivo armazenar os valores coletados pelos setters.
        # O unico objetivo dessas funções é possibilitar que o usuário consiga 
        # acessar os valores armazenados pelos setters. 

        public function getcpf_entregador(){

            return $this-> cpf_entregador;
        }

        public function getnome_entregador(){

            return $this->nome_entregador;
        }

        public function gettelefone_entregador(){

            return $this->telefone_entregador;
        }

        public function getsenha_entregador(){

            return $this->senha_entregador;
        }

        public function getquantidade_pedidos_feitos(){

            return $this->quantidade_pedidos_feitos;
        }

        # Método que irá cadastrar novos entregadores.
        public function cadastrarEntregador(){

            # Ira inspecionar o bloco de código com o objetivo de capturar possiveis erros.
            try{

                # Vamos realizar um conjunto de validações que irão definir se os dados informados
                # são validos para salvar no banco de dados.
                if (strlen($this->getcpf_entregador()) != 11){

                    # Se o tamanho do cpf não for de 11 digitos vamos 
                    # encerrar a execução do método e imprimir essa mensagem.
                    # die: Função do php que tem como objetivo encerrar/interromper
                    # a execução de um metodo ou função. Ele pode receber como argumento
                    # uma string que representa a mensagem que justifica o encerramento
                    # da execução.
                    die("O cpf deve conter 11 digitos");

                }else if (is_numeric($this->getcpf_entregador()) == False){
                    
                    # Se o cpf tiver letras em seus digitos, vamos encerrar a execução do
                    # método e imprimir essa mensagem.
                    # is_numeric: Função do php que tem como objetivo verificar há existência
                    # de numeros em uma string. Ele recebe como argumento a string que está sendo
                    # verificada e retorna um valor booleano onde True representa a ausência de 
                    # letras e False representa a existència de letras na string
                    die("O cpf deve conter apenas numeros");

                }

                if(is_numeric($this->getnome_entregador()) == True ){
                    
                    # Se o nome do entregador tiver numeros em seu valor, vamos encerrar
                    # a execução do método e imprimir essa mensagem.
                    die("O nome não pode conter números");
                } 

                if (strlen($this->gettelefone_entregador()) != 11 && strlen($this->gettelefone_entregador()) != 8){

                    # Se a quantidade de digitos do telefone for diferente de 8 e 11, vamos encerrar o metodo
                    # e imprimir essa mensagem.
                    die("o telefone deve conter 8 (telefone fixo) ou 11 digitos (celular)");

                }else if(is_numeric($this->gettelefone_entregador()) == False){
                   
                    # Se o telefone tiver letras em seu valor, vamos encerrar a execução do método
                    # e imprimir essa mensagem.
                   die("O telefone não deve conter letras");
                }

                # Nessa etapa, vamos verificar se o cpf informado para cadastro ja existe no sistema. Vamos realizar essa ação
                # usando o modo seguro do prepare que tem como objetivo filtrar valores e não executar comandos sql (que evita
                # ataques de SQL injection).

                # Ira conter o comando de consulta do cpf. ":cpf_entregador": Reepresenta o rótulo que utilizaremos
                # para representar o dado que queremos procurar no banco.
                $consulta_cpf = "SELECT cpf_entregador FROM entregadores WHERE cpf_entregador = :cpf_entregador";

                # Função da classe PDO que tem como objetivo filtrar os valores do comando com o objetivo
                # de separa-los dos comandos requisitados, dessa forma, o sistema não excutara scripts maliciosos inseridos
                # pelo usuário.
                $resultado_consulta = $this->conexao->prepare($consulta_cpf);

                # Após o filtro podemos executar o comando com segurança atribuindo ao rótulo definido
                # na consulta o valor que deve ser encontrado.
                $resultado_consulta->execute([':cpf_entregador'=>$this->getcpf_entregador()]);

                if ($resultado_consulta->rowCount()== 0){

                    # se a quantidade de linhas encontradas pela consulta for igual a zero, vamos iniciar o processo de inserção do novo dado.

                    # Ira conter o comando de inserção com os rótulos que irão representar os valores que serão inseridos
                    $comando_insercao = "INSERT INTO entregadores (cpf_entregador, nome_entregador, telefone_entregador, senha_entregador) VALUES(:cpf_entregador, :nome_entregador, :telefone_entregador, :senha_entregador)";

                    # Ira filtrar os valores evitando a execução do comando (prevenção contra sql injection)
                    $insercao = $this->conexao->prepare($comando_insercao);

                    # Após o filtro dos valores, iremos executar o comando atribuindo a cada rótulo, o valor que deve ser inserido.
                    $insercao -> execute([':cpf_entregador'=>$this->getcpf_entregador(), ':nome_entregador'=>$this->getnome_entregador(), ':telefone_entregador'=>$this->gettelefone_entregador(),':senha_entregador'=>$this->getsenha_entregador()]);

                    # Mensagem de sucesso.
                    echo "Entregador cadastrado";

                }else{

                    # Se o cadastro for encontrado no sistema, vamos encerrar a execução do método
                    # e imprimir essa mensagem.
                    die("Entregador já cadastrado");
                }


            }catch(PDOException $erro){

                # Exceção da classe PDO que lida com erros de execução em operações no banco de dados.
                # O getMessage é uma função que tem como objetivo retornar a mensagem do erro gerado pela exceção.
                # o die ira encerrar a execução do método.
                 die("Erro na criação do cadastro do entregador: ".$erro->getMessage());

                
            }
        }



?>