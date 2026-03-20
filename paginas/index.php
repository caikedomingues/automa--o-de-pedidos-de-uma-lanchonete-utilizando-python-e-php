
<?php
         # Esse arquivo irá conter o formulário de login do administrador.

         # Irá permitir que o sistema inicie uma sessão. Observação:
         # iniciar uma sessão não significa que o usuário já está 
         # logado, esse atp só é realizado após a especificação do
         # nome do login. De forma resumida, o session start apenas
         # inicia a abertura de sessão e não cria uma sesssão.   
          session_start();
          
          # Ira acessar a pasta que contém a classe que será utilizada
          # no sistema.
          require_once '../classes/Administrador.php';

          # Instância/criação do objeto Administrador.
           $adm = new Administrador();

           # Esse if irá verificar o tipo de requisição que o servidor esta recebendo, essa ação
           # é necessária para evitar erros ao iniciar a página, pois, sem a verificação o php
           # irá procurar os valores inseridos no formulário que no momento da inicialização da
           # página não existem, além disso, o if também possibilita que o usuário tenha o tempo que
           # achar necessário para preencher os campos, já que a validação dos dados e criação da
           # sessão só serão realizados se o tipo de requisição for POST (envio de dados ao servidor).
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                # Se essa condição for verdadeira, vamos criar as variáveis
                # que irá conter os dados que serão enviados ao servidor.
                # $_POST: Variável global que tem como objetivo coletar dados
                # que serão enviados para servidores (dados inseridos nos formulários).
                # usuario: Ira conter o nome do usuário
                # senha: Ira conter a senha do usuário.
                $usuario = $_POST['usuario'];
           
                $senha = $_POST['senha'];

                # Ira inserir os dados coletados nos setters que atribuem dados nas 
                # variáveis privadas da classe.
                $adm->setUsuarioInformado($usuario);

                $adm->setSenhaInformada($senha);

                # Ira verificar se o retorno da função loginadm é True (caso
                # as credenciais estejam corretas) ou False (caso as credenciais
                # estejam incorretas).
                if($adm->loginadm()){

                    # Se o retorno for true, vamos dar inicio ao processo de criação da sessão
                    # do usuário.

                    # Ira conter o nome da sessão que será criada no session_start. As sessões devem
                    # conter nomes para diferenciarmos os tipos de usuários que estão acessando um sistema
                    # (um administrador, um cliente, etc).
                    $_SESSION['login_adm'] = true;

                    # Após a criação da sesssão vamos coletar o nome de usuário que esta associado
                    # a sessão criada.
                    $_SESSION['usuario'] = $adm->getUsuarioInformado();

                    # Após o login, vamos transferir o adm para a página de pedidos.
                    header("Location: Pedidos.php");

                    # Garante que a página encerre a execução após o redirecionamento,
                    # dessa forma, o sistema não processara mais a pagina e a tornara
                    # livre para a criação da proxima sessão.
                    exit();

           }else{

                    # Se o retorno da função for False, vamos imprimir essa mensagem.
                    echo "Usuário ou senha inválidos";
           }
           }
    
    ?>


<!DOCTYPE html>
<html lang="pt-br">

<!--Trecho padrão de um documento HTML-->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lanchonete</title>
    <!--Link do bootstrap, framework que irá estilizar a nossa página.-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light vh-100 d-flex align-items-center justify-content-center">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                <div class="card border-0 shadow rounded-4 p-4">
                    <div class="text-center mb-4">
                        <img src="../imagens/login.jpg" alt="Login" class="img-fluid mb-3" style="max-height:100px;">
                        <h3 class="fw-bold text-secondary">Acesso Restrito</h3>
                    </div>
            
        <!--Ira criar o formulário de login do administrador.-->
        <!--Action: Ira definir para onde os dados irão ser enviados-->
        <!--method: Define o método de envio de dados, no nosso caso usaremos
        o metodo post de envio de dados para servidores.-->

        <form action="" method="post">
            
            <!--label: Rótulos dos campos de login. Os fors tem como objetivo associar os rótulos
            aos campos do formulário.
            
            Inputs: Campos que irão coletar os dados informados pelos usuários

            Type: Ira definir o tipo do dado que deve ser inserido no campo.

            id e name: São identificadores dos campos que vamos associar aos rótulos.

            placeholder: Define as instruções dos campos
            
            required: Define que os campos devem ser preenchidos obrigatoriamente.

            autocomplete = "off": Desabilita os autocompletes dos campos.
            .-->
            <div class="mb-3">

                <label class="form-label fw-semibold" for="usuario">Usuário</label>

                <input type="text" class="form-control form-control-lg" id = "usuario" name="usuario" placeholder="Digite o seu nome de usuário" required autocomplete="off"><br>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold" for="senha">Senha</label>

                <input type="password" class="form-control form-control-lg" id="senha" name="senha" placeholder="Digite a sua senha" required autocomplete="off"><br>
            </div>
            
            <div class="d-grid">
                <button class="btn btn-primary btn-lg" type="submit">Entrar</button>
            </div>
        </form>
 </div>
 <p class="text-center mt-4 text-muted small">
    &copy; 2026 Siistema de Gestão - Lanchonete

</p>
</div>
</div>
</div>

<!--Link do javascript do bootstrap, que tem como objetivo fazer funcionar objetos animados da estilização do bootstrap.-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>

</html>