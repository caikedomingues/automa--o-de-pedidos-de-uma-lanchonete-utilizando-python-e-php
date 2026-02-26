
# Criação do banco de dados que iremos utilizar no projeto
create database lanchonete;

# Irei especificar para o mysql o banco que irei utilizar no projeto
use lanchonete;

# Tabela que irá conter o cadastro dos entregadores que irão atuar no sistema para atualizar
# status de entregas.
create table entregadores(
	
    # Ira conter o cpf do entregador que será a chave de identificação do entregador
	cpf_entregador varchar(11),
    # Ira conter o nome do entregador
    nome_entregador varchar(255),
    # Ira conter o telefone de contato do entregador
    telefone_entregador varchar(11),
    # Tipo de veiculo que o entregador utilizara na entrega (carro, moto ou bicicleta).
    veiculo varchar(255),
    # Foto do entregador que aparecerá para o administrador do sistema.
    foto_entregador varchar(255),
    # Senha que o entregador usará para acessar a página de mudança de status de entrega
    senha_entregador varchar(255),
    # Ira armazenar a quantidade de entregas do entregador 
    quantidade_pedidos_feitos int default 0,
	
    # Ira identificar a chave primaria da tabela de entregadores
    primary key(cpf_entregador)

)default charset=utf8;

# Ira criar a tabela de produtos disponiveis para venda
create table produtos(
	# Será a chave primária que identificará os produtos da lanchonete
    id_produto int auto_increment,
    
    # Ira conter o nome do produto
    nome_produto varchar(255),
    preco float,
    categoria varchar(255),
    
    primary key(id_produto)
    
) default charset = utf8;

create table pedidos(
	
    codigo_pedido INT(4) zerofill auto_increment,
    
    produto_pedido varchar(255),
    
    dono_pedido varchar(11),
    
    nome_entregador varchar(255),
    
    status_entrega varchar(255) default 'Pedido a caminho',
    
    total_pedido float,
    
    data_pedido DATETIME DEFAULT current_timestamp,
    
    primary key(codigo_pedido)
	
)default charset = utf8;


alter table produtos add column quantidade_vendas int;

select * from produtos;
