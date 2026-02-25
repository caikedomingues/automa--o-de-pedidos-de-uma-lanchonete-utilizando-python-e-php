
create database lanchonete;

use lanchonete;


create table entregadores(

	cpf_entregador varchar(11),
    nome_entregador varchar(255),
    telefone_entregador varchar(11),
    veiculo varchar(255),
    foto_entregador varchar(255),
    senha_entregador varchar(255),
    quantidade_pedidos_feitos int default 0,
	
    primary key(cpf_entregador)

)default charset=utf8;

create table produtos(
	
    id_produto int auto_increment,
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

)default charset = utf8

