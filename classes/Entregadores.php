

<?php

    # Classe que irá conter os métodos e atributos dos entregadores do sistema.
    class Entregadores{

        # Atributos da classe: conexao (ira conter a conexão com o banco de dados), cpf_entregador(primary key), nome_entregador, telefone_entregador,senha_entregador, quantidade_pedidos_feitos.

        private $conexao;

        private string $cpf_entregador;

        private string $nome_entregador;

        private string $telefone_entregador;

        private string $senha_entregador;

        private string $veiculo;

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

        public function setveiculo($veiculo){

            $this->veiculo = $veiculo;

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

        public function getveiculo(){

            return $this->veiculo;
        }

        public function getquantidade_pedidos_feitos(){

            return $this->quantidade_pedidos_feitos;
        }

        # Método que irá cadastrar novos entregadores.
        public function cadastrarEntregador(){
            # Ira verificar se a sessão possui um valor diferente de 
            # true ou se a variável global deixou de existir
            if ( !isset($_SESSION['login_adm'])||$_SESSION['login_adm'] != true){

                # Se essa condição for verdadeira, iremos enceerrar
                # a execução do método e imprimir essa mensagem.
                die('Acesso negado, só o administrador pode cadastrar entregadores');

                }else{

                # Se a sessão estiver sido criada, vamos iniciar
                # o processo de cadastro

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

                    if(!ctype_alpha($this->getnome_entregador()) ){
                        
                        # Se o valor informado tiver a existência de
                        # números, vamos encerrar a execução do
                        # método e imprimir essa mensagem. O ctype_alpha
                        # tem como objetivo verificar se 100% da string
                        # é composta apenas por letras. Observação:
                        # Ele também não aceita espaços, acentos e 
                        # caracteres especia
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
                        
                        # Primeiro, vamos trabalhar a criptografia da senha.
                        # Armazenando a senha em uma variável
                        $senha = $this->getsenha_entregador();

                        # Ira conter o resultado (senha criptografada) da função passwordhash
                        # que tem como objetivo gerar hashs que mascaram o valor real da
                        # senha. Ela recebe como argumento a senha que sera criptografada
                        # e o tipo de criptografia. No nosso caso usaremos o PASSWORD_DEFAULT
                        # que sempre utilizara o modelo padrão de hash no momento, ou seja,
                        # se o padrão for trocado ou atualizado, o pasword default mudará 
                        # automaticamente o seu padrao de criptografia. 
                        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

                        # Ira conter o comando de inserção com os rótulos que irão representar os valores que serão inseridos
                        $comando_insercao = "INSERT INTO entregadores (cpf_entregador, nome_entregador, telefone_entregador, senha_entregador, veiculo) VALUES(:cpf_entregador, :nome_entregador, :telefone_entregador, :senha_entregador, :veiculo)";

                        # Ira filtrar os valores evitando a execução do comando (prevenção contra sql injection)
                        $insercao = $this->conexao->prepare($comando_insercao);

                        # Após o filtro dos valores, iremos executar o comando atribuindo a cada rótulo, o valor que deve ser inserido.
                        $insercao -> execute([':cpf_entregador'=>$this->getcpf_entregador(), ':nome_entregador'=>$this->getnome_entregador(), ':telefone_entregador'=>$this->gettelefone_entregador(),':senha_entregador'=>$senha_criptografada, 'veiculo'=>$this->getveiculo()]);

                        echo "Entregador cadastrado com sucesso";

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
        }

        # Método que irá realizar o login do entregador na página
        # de status de entregas.
        public function loginEntregador(){
            # Irá inspecionar o bloco de código com o objetivo de 
            # capturar possiveis erros de execução do trecho
            try{

                # Irá verificar a quantidade de caracteres do cpf
                if(strlen($this->getcpf_entregador()) != 11){
                    
                    # Se a quantidade de caracteres for maior ou
                    # menor que 11, iremos encerrar a execução
                    # do método e imprimir essa mensagem.
                    die("O cpf deve conter apenas 11 digitos");

                }else if(is_numeric($this->getcpf_entregador()) == False){

                    # Se o cpf não for composto apenas por numeros, vamos
                    # encerrar a execução do método e imprimir essa mensagem.
                    die("O cpf não deve conter letras");
                }

               # Ira consultar a senha do cpf informado no ato do
               # login. Observação: ":cpf_entregador" representa
               # o rótulo do valor que iremos passar para a consulta
               # no execute, ou seja, o valor do cpf do entregador.
               $consulta_senha = "Select senha_entregador FROM entregadores WHERE cpf_entregador = :cpf_entregador";

               # Ira filtrar os valores da consulta com o objetivo
               # de evitar o SQL INJECTION já que o prepare apenas
               # coleta os valores da query e não os executa. Dessa
               # forma, caso o usuário digite comandos, o sistema ira
               # apenas armazenar o comando e não executa-lo.
               $resultado_consulta = $this->conexao->prepare($consulta_senha);

               # Após o filtro, vamos executar a consulta substituindo
               # o rótulo pelo valor do cpf informado.
               $resultado_consulta->execute([':cpf_entregador'=>$this->getcpf_entregador()]);

               # Após a consulta, vamos criar um array associativo
               # usando a função fetch com o objetivo de possibilitar
               # o acesso aos dados através do nome das colunas 
               # selecionadas.
               $usuario_encontrado = $resultado_consulta->fetch(PDO::FETCH_ASSOC);

                # Irá verificar se algum registro foi encontrado na consulta.
               if($usuario_encontrado){

                    # Se uma senha for encontrada, significa que o cpf
                    # informado existe no sistema, já que a consulta 
                    # encontrou o hash da senha do usuário. Após validar
                    # o cpf através da consulta do hash, vamos iniciar
                    # a verificação da senha informada pelo usuário.

                    # password_verify:Função que tem como objetvo gerar um hash que será comparado com o hash da senha criptografa com o objetivo de validar se a senha informada condiz com a senha criptografada.A função
                    # recebe como argumento a senha que será verificada
                    # (senha digitada pelo usuário) e o hash da senha
                    # (senha consultada no começo do método). 
                    $verificacao = password_verify($this->getsenha_entregador(), $usuario_encontrado['senha_entregador']);

                    # Irá verificar o resultado da função password_verify. Esse resultado será análisado
                    # na estrutura condicional da pagina de login que
                    # ira possibilitar (ou não, se o login estiver
                    # incorreto) a criação de sessão do usuário(login)
                    if($verificacao){

                            # Se a senha informada for correta, vamos
                            # retornar true que indicara para a estrutura
                            # da página de login que os dados estão
                            # corretos para a realização do login.
                            return true;

                    }else{

                            # Se a senha informada não for correta,
                            # vamos retornar false que indicara para
                            # a estrutura da pagina de login que 
                            # os dados informados não estão corretos.
                            return false;
                    }


               }else{
                    
                        # Se o cpf não for encontrado,
                        # vamos retornar false que indicara para
                        # a estrutura da pagina de login que 
                        # os dados informados não estão corretos.
                        return false;
               }

            }catch(PDOException $erro){
                # Exceção que lida com erros relacionados a operações nos
                # banco de dados. Nesse caso, iremos interromper
                # a execução do método e imprimir essa mensagem.
                die("Falha na consulta dos dados: ". $erro->getMessage());
            }


        }

        # Função que irá mostrar para o adminsitrador do sistema
        # as informações dos entregadores cadastrados no sistema.
        public function listarEntregadores(){

            # Irá inspecionar o bloco de código com o objetivo
            # de capturar possiveis erros de execução.
            try{
                
                # Irá verificar se uma sessão foi criada. Basicamente
                # a estrutura irá verificar se a superglobal $_SESSION
                # existe ou se o seu valor é diferente de true.
                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                    # Se essa condição for verdadeira, vamos encerrar
                    # a execução do método e imprimir essa mensagem
                    # que contém o link que guiara o usuário para
                    # a página de login de administrador.
                    die("<p>Por favor realize login para ver os entregadores</p> <a href='index.php'>Voltar a página de login</a>");

                }else{

                    # Se uma sessão for criada, vamos iniciar o processo
                    # de consulta dos dados.

                    # Comando que irá conter a consulta dos dados
                    # dos entregadores.
                    $consulta_entregadores = "SELECT cpf_entregador, nome_entregador, telefone_entregador, veiculo, quantidade_pedidos_feitos FROM entregadores";

                    # Ira garantir que todo comando executado após
                    # o execute seja considerado como texto. Dessa 
                    # forma, iremos garantir que o sistema execute
                    # apenas o comando definido na variável $consulta_entregadores. 
                    $resultado_consulta = $this->conexao->prepare($consulta_entregadores);

                    # Irá executar o comando de consulta.
                    $resultado_consulta->execute();

                    # Ira acessar todas as linhas do banco de dados
                    # e criará um array associativo que nos possibilita acessar os dados através dos nomes das colunas.
                    $entregadores = $resultado_consulta->fetchAll(PDO::FETCH_ASSOC);
                    
                    # Ira verificar se a consulta encontrou registros.
                    if($entregadores){

                        # Se essa condição for verdadeira, vamos retornar os dados que serão percorridos pelo foreach 
                        # na página de informações de produtos
                        return $entregadores;

                    }else{
                        
                        # Caso o banco não tenha registros, vamos retornar essa mensagem
                        return "Não há entregadores cadastrados";
                    }
                }

            }catch(PDOException $erro){

                # Ira lidar com erros relacionados a operações no 
                # banco de dados. Nesse caso, iremos imprimir essa 
                # mensagem e encerrar a execução do sistema.
                die("Falha na consulta dos dados: ".$erro->getMessage());
            }

        }

        # Método que irá excluir os entregadores do sistema.
        public function excluirEntregador(){
            # Irá inspecionar o  bloco de código com o objetivo de
            # capturar possiveis erros de execução do sistema.
            try{

                # Ira verificar se uma sessão foi criada antes de
                # iniciar o processo de exclusão. Basicamente
                # a estrutura irá verificar se o valor da $_SESSION
                # é diferente de true ou se ela existe no sistema 
                if(!isset($_SESSION['login_adm']) || $_SESSION['login_adm'] != true){

                    # Se essa condição for verdadeira, vamos imprimir
                    # essa mensagem e encerrar a execução do sistema.
                    die("<p>Por favor, realize login para excluir entregadores</p><a href='index.php'> Voltar a página de login</a>");

                }else{

                    # Se uma sessão for criada, vamos iniciar o processo
                    # de exclusão.

                    # Ira conter o comando de exclusão dos dados.
                    $exclusao_entregador = "DELETE FROM entregadores WHERE cpf_entregador = :cpf_entregador";

                    # Ira garantir que todo comando executado após o
                    # execute seja considerado como texto. Dessa forma,
                    # iremos garantir que o sistema só execute o
                    # comando especificado na variável passada como
                    # argumento do prepare.
                    $resultado_exclusao = $this->conexao->prepare($exclusao_entregador);

                    # Ira executar a exclusão do entregador usando
                    # o rótulo definido anteriormente e o valor
                    # acessado pelo getter.
                    $resultado_exclusao->execute([':cpf_entregador'=>$this->getcpf_entregador()]);


                }

            }catch(PDOException $erro){

                # Ira lidar com excessões relacionadas a operações
                # realizadas no banco de dados. Nesse caso, iremos encerrar a execução do método e exibir essa mensagem 
                die("Falha na exclusão dos dados: ".$erro->getMessage());
            }            

        }

        

    }


?>