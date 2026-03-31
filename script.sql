
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

# Vamos verificar se os produtos foram inseridos corretamente.
select * from produtos;

# Vamos inserir entregadores para testar a criação de pedidos através do sistema

insert into entregadores(cpf_entregador, nome_entregador, telefone_entregador, veiculo, senha_entregador) values('12345678911', 'carlos', '90909678921','moto', '123456');

insert into entregadores(cpf_entregador, nome_entregador, telefone_entregador, veiculo, senha_entregador) values('89738267189', 'jean', '41833397','moto', '123456');

insert into entregadores(cpf_entregador, nome_entregador, telefone_entregador, veiculo, senha_entregador) values('22222222222', 'mario', '41894566','moto', '123456');

# Resolvi remover a coluna de total de pedidos. Tomei essa decisão
# por que realizaremos o conceito de normalização, ou seja, um cliente que possui
# mais de um pedido terá mais de uma linha no banco de dados (uma para cada pedido
# desse mesmo cliente). 
alter table pedidos drop column total_pedido;

# Vou mudar a coluna de pedidos em uma coluna de preço dos pedidos.
alter table pedidos add column preco_pedido float not null;

# Verificando se as alterações nas tabelas foram realizadas com sucesso.
describe pedidos;
describe entregadores;

# Deletei esses dados que foram inseridos no sistema de forma incorreta (resolvi esse problema no python).
delete from pedidos where codigo_pedido = '0005';

delete from pedidos where codigo_pedido = '0006';

delete from pedidos where codigo_pedido = '0025';

delete from pedidos where codigo_pedido = '0026';

SET SQL_SAFE_UPDATES = 0;

delete from pedidos;

alter table pedidos add column cpf_entregador varchar(11);

alter table pedidos drop column nome_entregador;

# Inserindo pedidos para testar a página de status de entregas
INSERT INTO pedidos( produto_pedido, dono_pedido, endereco, preco_pedido, cpf_entregador) VALUES('2', '98635478293', 'jardim planalto', '14','90934839021');

INSERT INTO pedidos( produto_pedido, dono_pedido, endereco, preco_pedido, cpf_entregador) VALUES('2', '98635478293', 'jardim planalto', '14','90934839021');

delete from produtos where id = 5;

# Vamos adicionar a quantidade de vendas o valor padrão 0 para produtos que ainda não foram vendidos;

alter table produtos modify column quantidade_vendas int default 0; 

# Verificando se os dados foram inseridos corretamente.
select * from pedidos;

select * from produtos;

select * from entregadores;


