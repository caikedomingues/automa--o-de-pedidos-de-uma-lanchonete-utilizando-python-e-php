
# Import da classe connect da biblioteca mysql que tem como objetivo 
# criar conexões com o banco de dados.
import mysql.connector

# Função que ira conectar o python ao banco de dados com o objetetivo
# de permitir que a linguagem realize operações no banco de dados.
def conectarBancoAutomacao():
    
    # Connect: Função da classe connector que irá criar a conexão com
    # o banco de dados
    conexao = mysql.connector.connect(
    
    # Ira conter o endereço do servidor que irá guardar os nossos dados
    host = 'localhost',
    
    # Usuário administrador do banco de dados
    user = 'root',
    
    # Senha do usuário administrador do banco de dados
    password = '',
    
    # Banco de dados que iremos usar no projeto
    database = 'lanchonete'
    
    )
    
    # Retorno da conexão realizada.
    return conexao


# Função que irá buscar os produtos cadastrados no banco de dados.
def consultarprodutos():
    
    # Ira se conectar ao banco de dados
    conexao = conectarBancoAutomacao()
    
    # Sera responsável por enviar as requisições ao servidor
    cursor = conexao.cursor()
    
    # Ira conter o comando que realiza a consulta ao banco de dados.     
    consulta = "SELECT id_produto, nome_produto, preco from produtos"
    
    # Ira executar o comando de consulta
    cursor.execute(consulta)
    
    # Ira retornar uma lista com todos os valores do banco de dados
    lista_produtos = cursor.fetchall()
    
    # Irá conter a mensagem que iremos enviar para o usuário
    # no arquivo bot. ele tera o 'vázio' como valor padrão.
    mensagem = ""
    
    # Irá percorrer a lista de produtos retornada pelo banco com o
    # o objetivo de acessar cada valor da lista para montar a mensagem.
    for produto in lista_produtos:
        
        # Ira retornar o id do produto (1° coluna retornada pelo banco)      
        id_produto = produto[0]
        
        # Ira retornar o nome do produto (2° coluna retornada pelo banco)
        nome_produto = produto[1]
        
        # Ira retornar o preço do produto (3° coluna retornada pelo banco).
        preco = produto[2]
        
        # Ira conter a mensagem com todos os elementos consultados.
        # Observação: Como não queremos substituir os valores da
        # variável vamos atribuir eles usando um +=, dessa forma,
        # ele ira adicionar os dados ao invés de substitui-los pelo
        # próximo valor encontrado na lista
        mensagem += f"\n{id_produto} - {nome_produto}  {preco}\n"
        
    
    # A função ira retornar a mensagem formatada com os valores
    # do banco de dados.
    return mensagem
    
# Função que ira retornar a lista de ids dos prosutos cadastrados no sistema.
# Vamos usar essa função para consultar todos os ids com o objetivo de 
# verificar se o pedido do cliente possui as instruções válidas para  
# a realização do pedido.
def lista_ids():
    
    # Irá se conectar ao servidor do banco de dados.
    conexao = conectarBancoAutomacao()
    
    # Sera responsável por enviar as requisições ao servidor.
    cursor = conexao.cursor()
    
    # Ira conter o comando que consultara os ids dos produtos.
    consulta_id = "SELECT id_produto from produtos"
    
    # Ira executar o comando de consulta.
    cursor.execute(consulta_id)
    
    # Ira retornar todos os ids encontrados na consulta.
    ids = cursor.fetchall()
    
    # Ira conter uma lista com os ids encontrados na consulta.
    lista_ids = []
    
    # Ira percorrer a lista com o objetivo de adicionar os ids
    # na lista.
    for itens in ids:
        
        # Como o fetchall retorna uma lista de tuplas, onde cada
        # tupla representa uma linha da tabela (dentro da tupla,
        # cada item corresponde a uma coluna que você pediu no
        # SELECT, como pedimos apenas o id do produto, a tupla terá 
        # apenas um elemento no indice, ou seja, apenas uma coluna).
        # Dito isso, seria interessante adicionar os valores em uma
        # lista que tera os seus dados numericos convertidos para 
        # string com o objetivo de facilitar a comparação dos valores
        # com a mensagem recebida
        lista_ids.append(str(itens[0]))
    
    # Ira retorna a lista com os ids encontrados   
    return lista_ids


# Função que irá adicionar os pedidos dos clientes no banco de dados.
# A função irá receber como argumento o id do priduto pedido, o cpf
# do cliente e o endereço da entrega.
def criarpedidos(id_produto, cpf_cliente, endereco_entrega):
    
    # Tera como objetivo inspecionar o bloco de codigo com o objetivo
    # de capturar possiveis erros de execução do código  
    try:
        
        # Ira se conectar ao servidor do banco de dados.
        conexao = conectarBancoAutomacao()
        
        # Será responsável por enviar requisições ao servidor.
        cursor = conexao.cursor()
        
        # ira selecionar aleatóriamente um entregador (um dos
        # cpfs de entregadores cadastrados no sistema) com
        # o objetivo de escolher o entregador da entrega.
        consulta_entregador = "SELECT cpf_entregador from entregadores ORDER BY RAND() LIMIT 1"
        
        # Ira executar o comando de consulta.
        cursor.execute(consulta_entregador)
        
        # Ira conter a unica linha selecionada pelo banco
        resultado = cursor.fetchone()
        
        # Ira acessar o valor (cpf) presente na unica linha
        # retornada pela consulta
        cpf_entregador = resultado[0]
        
        # Ira conter o valor total do pedido do cliente, esse valor
        # será exibido no final do atendimento.
        valor_total_exibir = 0
        
        # Ira percorrer a lista de ids escolhidos com o objetivo
        # de realizar consultas e inserções no banco.
        for lista_id in id_produto:
            
            # Ira consultar o preço dos ids informados com o objetivo
            # de inserir os preços na tabela de pedidos e calcular
            # o valor total do pedido. (comando realizado da maneira
            # segura que evita injeções sql no banco).
            consulta_preco = "SELECT preco from produtos WHERE id_produto = %s"
            
            # Ira executar o comando de consulta.
            cursor.execute(consulta_preco, (lista_id,))
            
            # Ira retornar o preço de cada id encontrado na consulta
            resultado = cursor.fetchone()
            
            # Ira acessar o unico valor encontrado pelo
            # banco (um pra cada id encontrado)          
            preco_pedido = resultado[0]
            
            # Ira somar o preço de cada id.
            valor_total_exibir = valor_total_exibir + preco_pedido

            # Ira conter o comando que insere os dados na tabela de pedidos.
            insercao_pedido = "INSERT INTO pedidos(produto_pedido, dono_pedido, cpf_entregador, preco_pedido, endereco) Values(%s, %s, %s, %s, %s)"
            
            # Ira executar o comando de inserção.
            cursor.execute(insercao_pedido, (lista_id, cpf_cliente, cpf_entregador, preco_pedido, endereco_entrega))
            
            # Mensagem que indica o sucesso da execução do trecho de código.
            print("Pedido realizado com sucesso")
        
        # Função da classe connector que irá gravar a inserção no servidor.         
        conexao.commit()
        
        # Retorno do total do valor que será exibido no fim da mensagem
        return valor_total_exibir
        
    except mysql.connector.ProgrammingError as erro:
        
        # Exceção que representa os erros de "programador" como por
        # exemplo executar um comando em um cursor fechado, nome
        # de coluna inexistente ou numero errado de argumentos no
        # execute.
        print("Erro de inserção, por favor verifique se a coluna existe no banco de dados", erro)
    
    except mysql.connector.DatabaseError as erro:
        
        # Exceção que ira retornar os erros de servidor como erro
        # de sintaxe SQL errada, tabela não encontrada, erro de permissão.
        print("Erro de servidor, por favor verifique a sintaxe, a existência da tabela ou  a permissão do usuário: ", erro)
    
    except mysql.connector.OperationalError as erro:
        
        # Exceção que retorna erros que acontecem durante a operação
        # no servidor, como por exemplo falhas na conexão ou queda 
        # do banco.
        
        print("Falha na conexão com o banco de dados: ", erro)
    
    except mysql.connector.IntegrityError as erro:
        
        # Exceção que retorna erros relacionados aos dados inseridos
        # no banco como por exemplo, um CPF que não possui o formato
        # válido definido na chave primária
        print("Erro de integridade dos dados, por favor, verifique o valor inserido na chave estrangeira: ", erro)
    
    finally:
        
        # Trecho que sempre será executado, independente da situação
        
        # Ira fechar a conexão com o banco de dados com o objetivo
        # de facilitar o processamento do programa, já que não há
        # necessidade de continuar conectado ao banco após o fim
        # do processo. 
        conexao.close()


# Função que ira retornar uma com os codigos de pedidos dos clientes.
# A função ira receber como argumento o cpf do cliente que terá os
# códigos retornados.
def consultar_codigo_pedido(cpf_cliente):
    
    # Ira se conectar ao banco de dados
    conexao = conectarBancoAutomacao()
    
    # Ira ser responsável pelo envio de requisições ao servidor
    # do banco.
    cursor = conexao.cursor()
    
    # Comando de consulta dos codigos de pedidos.
    consulta_codigo = "SELECT codigo_pedido from pedidos WHERE dono_pedido = %s AND status_entrega = 'Pedido a caminho'"
    
    # Ira executar o comando da consulta
    cursor.execute(consulta_codigo, (cpf_cliente,))
    
    # Ira retornar uma lista de tuplas com todos os valores (codigos)
    # do cliente
    resultado = cursor.fetchall()
    
    # Vamos criar uma lista que ira conter os valores dos códigos
    # retornados pela consulta. Dessa forma ao percorrer a tupla
    # de resultados, a variável codigo irá armazenar os valores
    # ao invés de substituir os valores.
    codigo = []
    
    # Ira percorrer a tupla de dados retornados.
    for dado in resultado:
        
        # Ira adicionar os dados convertidos em string na lista de
        # códigos. observação: Resolvi transformar os dados em string
        # para facilitar a impressão dos dados na mensagem.
        codigo.append(str(dado[0]))
    
    # Ira retornar a lista de codigos de pedidos.
    return codigo



        