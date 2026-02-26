
import mysql.connector

def conectarBancoAutomacao():
    
    conexao = mysql.connector.connect(
    
    host = 'localhost',
    
    user = 'root',
    
    password = '',
    
    database = 'lanchonete'
    )
    
    return conexao


def consultarprodutos():
    
    conexao = conectarBancoAutomacao()
    
    cursor = conexao.cursor()
    
    consulta = "SELECT id_produto, nome_produto, preco from produtos"
    
    cursor.execute(consulta)
    
    lista_produtos = cursor.fetchall()
    
    for produto in lista_produtos:
        
        id_produto = produto[0]
        
        nome_produto = produto[1]
        
        preco = produto[2]
        
        mensagem =f"{id_produto} - {nome_produto} | R${preco}"
        
        return mensagem     