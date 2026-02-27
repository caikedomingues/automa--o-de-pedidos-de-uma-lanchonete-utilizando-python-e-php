
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
    
    # Ira conter o preço do produto
    preco float,
    
    # Ira conter o tipo do produto (lanches, salgados, porções, bebidas, sobremesas)
    categoria varchar(255),
    
    # Ira identificar a chave primária da tabela de produtos.
    primary key(id_produto)
    
) default charset = utf8;

# Ira criar a tabela de pedidos
create table pedidos(
	# Irá conter o código que o cliente irá informar ao entregador.
    # Esse código também sera utilizado na identificação do pedido 
    # no sistema
    codigo_pedido INT(4) zerofill auto_increment,
    
    # Ira ser a chave estrangeira que irá conter o id do produto
    # solicitado (posteriormente iremos modificar essa coluna no
    # código)
    produto_pedido varchar(255),
    
    # Ira conter o cpf do cliente que é dono do pedido
    dono_pedido varchar(11),
    
    # Ira conter o nome do entregador
    nome_entregador varchar(255),
    
    # Ira conter o status da entrega que terá como valor padrão o 'pedido a caminho'
    status_entrega varchar(255) default 'Pedido a caminho',
    
    # Ira conter o total do pedido realizado com sucesso
    total_pedido float,
    
    # Ira conter a data do pedido
    data_pedido DATETIME DEFAULT current_timestamp,
    
    # Ira identificar a chave primaria da tabela de pedidos 
    primary key(codigo_pedido)
	
)default charset = utf8;

# Ira adicionar a coluna de quantidade de vendas dos produtos.
alter table produtos add column quantidade_vendas int;

# Iremos transformar a coluna de produtos pedidos em uma coluna int
# com o objetivo de transforma-la em uma chave estrangeira. 
alter table pedidos modify produto_pedido int not null;

# Ira transformar a coluna em uma chave estrangeira
ALTER TABLE pedidos ADD CONSTRAINT fk_produto_pedido FOREIGN KEY (produto_pedido) 
REFERENCES produtos(id_produto);

# Adicionei a coluna de endereço na tabela de pedidos.
alter table pedidos add column endereco varchar(255);

# Irá descrever as colunas da tabela entregadores.
describe entregadores;

describe produtos;
# Vamos inserir dados no banco para testar o envio das opções para o cliente voa whatsapp.
# categorias válidas: lanches, salgados, porções, bebidas, sobremesas
insert into produtos(nome_produto, preco, categoria, quantidade_vendas) VALUES('Hamburguer', 28.90, 'lanches', 1 );
insert into produtos(nome_produto, preco, categoria, quantidade_vendas) VALUES('Batata Frita', 14.00, 'porções', 4 );
insert into produtos(nome_produto, preco, categoria, quantidade_vendas) VALUES('coxinha', 1.00, 'salgados', 1 );
insert into produtos(nome_produto, preco, categoria, quantidade_vendas) VALUES('misto quente', 15.90, 'lanches', 8 );

select * from produtos;

