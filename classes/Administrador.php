

<?php

    # Esse aqruivo irá conter as funções do administrador do sistema.
    class Administrador{

       # Como nesse sistema teremos apenas um administrador do sistema, não será necessário
       # registra-lo no banco de dados, pois, ele tera apenas um nome e uma senha de usuário
       # (ambos imutaveis). Dito isso, vamos criar constantes que terão sempre o mesmo valor
       # dentro da classe.

       # Ira conter o nome de usuário do administrador
       private const USUARIO = "admin";
       
       # Ira conter o hash da senha definida no arquivo 'gerarhash.php'
       private const SENHA_HASH = '$2y$10$rbZsmSPkA7CDJyZ2g9jOQuP4QUV11XdVEhjQcCQW9IeUXeuQiXGfq';
       
       # Ira conter o nome do usuário informado pelo usuário
       private string $usuario_informado;
       
       # Ira conter a senha informada pelo usuário
       private string $senha_informada;


       # Encapsulamento: Como nessa classe definimos constantes, ou seja, valores que não serão 
       # alterados no decorrer do programa, devemos encapsular apenas as variáveis de entradas
       # do usuário (usuario_informado e senha_informada).

       public function setUsuarioInformado($usuario_informado){

            $this->usuario_informado = $usuario_informado;
       }

       
       public function getUsuarioInformado(){

            return $this->usuario_informado;
       }


       public function setSenhaInformada($senha_informada){

            $this->senha_informada = $senha_informada;
       }


       public function getSenhaInformada(){

            return $this->senha_informada;
       }

        # Função que irá verificar se o usuário e senha informado são válidos para a realização do login
        # do usuário
       public function loginadm(){

            # Primeiro, vamos verificar se o usuario informado é igual ao valor
            # da variável constante que definimos para o usuário.
            if($this->getUsuarioInformado() == self::USUARIO){

                # Password_verify: Função que tem como objetivo verificar se a senha informada
                # é igual a senha criptografada pelo hash. A função recebe como argumento 
                # a senha que sera verificada (getsenha) e o hash da senha (senha_hash).
                $verificacao = password_verify($this->getSenhaInformada(), self::SENHA_HASH);

                if($verificacao){

                    # Se o resultado da função for true, iremos retornar esse valor que na validação condicinal na pagina 
                    # index.php ira indicar que a sessão foi criada
                    return true;
                }else{

                    # Se o resultado da função for false, iremos imprimir essa mensagem e
                    # encerraremos a execução do método.
                    die("Usuario ou senha inválida");
                }

            }else{

                # Se o usuário não for valido, vamos retornar o false que indicara na validação do index.php que a sessão não foi criada.

                return false;
            }


       }

    }



?>