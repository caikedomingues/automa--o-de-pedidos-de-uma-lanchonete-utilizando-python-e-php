
import mysql.connector



def conectarBancoAutomacao():
    
    conexao = mysql.connector.connect(
    
    host = 'localhost',
    
    user = 'root',
    
    password = '',
    
    database = 'lanchonete'
    )
    
    return conexao

