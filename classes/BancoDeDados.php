


<?php

    # Este arquivo ira conter todas as operações que queremos realizar no banco de dados.    
    # Vamos usar  
    
    class BancoDeDados{

        public function conexaoBanco(){

        try{

            $dsn = "mysql:host=localhost;dbname=lanchonete;charset=utf8mb4";

            $usuario = "root";

            $senha = "";

            $conexao = new PDO($dsn, $usuario, $senha);

            echo "Conexão realizada";

            return $conexao;

        }catch(PDOException $erro){

                echo "erro na conexao: " . $erro->getMessage();
        }
      }
    }

?>
