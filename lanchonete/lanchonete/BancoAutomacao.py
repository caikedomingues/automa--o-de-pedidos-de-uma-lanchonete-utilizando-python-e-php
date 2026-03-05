
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


def criarpedidos(id_produto, cpf_cliente, endereco_entrega):
    try:
        
        conexao = conectarBancoAutomacao()
        
        cursor = conexao.cursor()
        
        consulta_entregador = "SELECT nome_entregador from entregadores ORDER BY RAND() LIMIT 1"
        
        cursor.execute(consulta_entregador)
        
        resultado = cursor.fetchone()
        
        nome_entregador = resultado[0]
        
        valor_total_exibir = 0
        
        for lista_id in id_produto:
            
            consulta_preco = "SELECT preco from produtos WHERE id_produto = %s"
            
            cursor.execute(consulta_preco, (lista_id,))
            
            resultado = cursor.fetchone()
            
            preco_pedido = resultado[0]
            
            valor_total_exibir = valor_total_exibir + preco_pedido
        
            insercao_pedido = "INSERT INTO pedidos(produto_pedido, dono_pedido, nome_entregador, preco_pedido, endereco) Values(%s, %s, %s, %s, %s)"
            
            cursor.execute(insercao_pedido, (lista_id, cpf_cliente, nome_entregador, preco_pedido, endereco_entrega))
            
            print("Pedido realizado com sucesso")
            
        conexao.commit()
        
        return valor_total_exibir
        
    except mysql.connector.ProgrammingError as erro:
        
        print("Erro de inserção, por favor verifique se a coluna existe no banco de dados", erro)
    
    except mysql.connector.DatabaseError as erro:
        
        print("Erro de sintaxe ou de tabela não encontrada: ", erro)
    
    except mysql.connector.OperationalError as erro:
        
        print("Falha na conexão com o banco de dados: ", erro)
    
    except mysql.connector.IntegrityError as erro:
        
        print("Erro de integridade dos dados, por favor, verifique o valor inserido na chave estrangeira: ", erro)
    
    finally:
        
        conexao.close()

        