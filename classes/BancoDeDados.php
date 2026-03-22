


<?php

    #Este aequivo ira conter a conexão com o banco de dados que iremos utilizar em outras
    # classes com o objetivo de conectar os métodos de cada objeto ao banco de dados.
    # Vamos usar essa classe parav realizar a injeção de dependência que basicamente 
    # consiste em tornar os códigos das outra classes mais adaptavel a mudanças no
    # código da classe Banco de Dados, já que elas necessitaram de receber apenas
    # a conexão.
    
    # Criação da classe banco de dados que conterá o método de conexão.
    class BancoDeDados{

        # método que irá criar a conexão com o banco de dados
        public function conexaoBanco(){

        # Ira inspecionar o bloco de código com o objetivo de capturar possiveis
        # erros de execução do código. 
        try{

            # dsn é o link que contém as informações necessárias do banco de dados
            # como o endereço do servidor e o nome do banco de dados.
            $dsn = "mysql:host=localhost;dbname=lanchonete;charset=utf8mb4";

            # Ira conter o usuário que administra o banco de dados.
            $usuario = "root";

            # Ira conter a senha do banco de dados.
            $senha = "";

            # Ira instanciar a classe PDO que cria a conexão com um banco de dados mysql.
            # A classe recebe em seu construtor o dsn(link com os dados do servidor), o
            # usuario e a senha do banco.
            $conexao = new PDO($dsn, $usuario, $senha);

            # Ira retornar a conexão com o banco de dados (valores que irão
            # conectar as classes ao banco).
            return $conexao;

        }catch(PDOException $erro){
                
                # Ira lidar com erros relacionados as operações realizadas no banco de dados.
                # O getMessage é uma função que tem como objetivo retornar a mensagem do erro
                # gerado pela exceção
                echo "erro na conexao: " . $erro->getMessage();
        }
      }
    }

?>
