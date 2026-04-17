                # Automação de pedidos de uma lanchonete em python e php
Irei criar um sistema que armazena os pedidos dos clientes feitos 
pelo whatsapp com o objetivo de mostra-los em uma interface feita em html, css e PHP (para acessar o banco de dados).


                                Usuários do sistema
                                
                                    Administrador
 -> poderá ver os pedidos realizados (concluidos e não concluidos)
 
 -> podera cadastrar entregadores e produtos (os produtos irão aparacer na lista de produtos que o cliente receberá
 via whatsapp).

 -> poderá excluir produtos do sistema

 -> poderá visualizar as informações dos produtos.

 -> poderá visualizar as informações dos entregadores.

 -> Poderá visualizar as informações dos pedidos

 -> poderá pesquisar informações dos pedidos, entregadores e produtos.

 -> poderá editar dados dos produtos 

                                    Clientes
-> Ira interagir com o sistema via whatsapp com o objetivo de realizar
pedidos.

-> Ira receber informações do pedidos realizado.

                                    Entregadores    
-> irão mudar os status de suas entregas.
->Irão atualizar os seus dados (menos o seu cpf)
                                Ferramentas


                                    Python 3.12.10
-> Ira cuidar das automações (processo de receber e enviar mensagem) usando o framework botcity

-> Registrará no banco de dados os pedidos realizados pelos clientes

                                    PHP 8.2.12
-> Será responsável por realizar consultas e mostrar os pedidos feitos
pelos clientes.


                                     HTML
-> Será responsável por criar o corpo/layout da página que contém os pedidos



                                    Bootstrap
-> FrameWork do CSS que ja possui classes prontas para realização de
estilizações de páginas.


                                     SQL 10.4.32
-> Irá manipular o nosso banco de dados


                                    IDEs utilizadas
-> Visual Studio Code: Python, PHP, HTML, Bootstrap

-> MysqlWorkbench 8.0 CE: SQL.

                                        Tabelas
-> pedidos: código_pedido(primary key), produto_pedido (ira conter os produtos que o cliente escolheu), dono_pedido, status_entrega (Ira informar se o pedido ja foi ou não entregue), total_pedido (valor total da compra), data_pedido, endereco, cpf_entregador(vamos usar para depois verificar as entregas dele na página de status de 
entregas).

-> entregadores: cpf_entregador(primary key), nome_entregador, telefone_entregador,senha_entregador, veiculo, quantidade_pedidos_feitos.

-> produtos: id(primary key), nome, preco, categoria (lanches, salgados, porções, bebidas, sobremesas), quantidade_vendas (ira conter a quantidade de vezes que o produto foi vendido).


                                        Regras de Negócio

-> Para acessar o sistema o administrador deverá fornecer um login e senha: Finalizado

-> Somente o entregador poderá mudar o status das entregas (só a partir disso iremos atribuir uma entrega a mais na coluna de quantidade de pedidos feitos): Finalizado

-> Para mudar o status o entregador deve realizar um login usando
o seu cpf e a uma senha: Finalizado.


-> Não há restriçoes para as senhas de entregadores: Finalizado.

-> O sistema devera verificar se uma sessão foi iniciada antes de permitir que uma ação seja executada

-> Somente o administrador do sistema poderá cadastrar novos entregadores: Finalizado

-> Um entregador só pode ser cadastrado uma única vez: finalizado.

-> Somente o administrador poderá cadastrar produtos: finalizado

-> Ao receber uma mensagem o sistema deve responder mandando a lista de itens disponiveis para a compra: Finalizado

-> O cliente devera escolher os ids dos produtos que ele quer comprar: finalizado

-> Somente o administrador poderá excluir produtos do sistema: Finalizado

-> O administrador não poderá excluir produtos que estão a caminho
para a entrega: finalizado

-> Somente o administrador poderá excluir entregadores do sistema: finalizado

-> Somente o administrador poderá visualizar todos os pedidos e seus status: finalizado.

-> O administrador poderá ver as informações de todos os entregadores: finalizado

-> O administrador poderá ver as informações sobre os produtos cadastrados: Finalizado

-> Somente o administrador poderá pesquisar sobre produtos, entregadores e 
pedidos.

-> O cliente deve receber o codigo ao finalizar o pedido com o objetivo
de informa-lo ao entregador.: finalizado

-> Somente o administrador poderá editar dados de produtos: finalizado

-> Somente o entregador poderá editar os seus dados: finalizado.

-> a quantidade de vendas só sera atualizada se o status da entrega for
igual a 'Entregue': Finalizado.


                                                        Paginas do sistema

index.php-> tela de login do administrador (pagina inicial): Finalizado

LoginEntregador.php-> tela de login dos entregadores: finalizado

StatusEntregas.php-> tela de mudança de status de entrega: Finalizado

CadastroEntregador.php-> tela de cadastro de entregadores: Finalizado

CadastroProdutos.php -> tela de cadastro de produtos: Finalizado

InformacoesProdutos.php-> botão de exclusão de produtos: Finalizado

InformacoesProdutos.php-> botão de edição de informações dos produtos: finalizado

InformacoesProduto.php -> Tela de informações de produtos: Finalizado

-> Tela de informações de pedidos (TodasEntregasRealizadas.php e EntregasaCaminho.php): Finalizado

HistoricoEntregas.php-> historico de pedidos entregues: Finalizado

InformacoesEntregadores.php-> tela de informações dos entregadores: finalizado

InfomacoesEntregadores.php-> Botão de exclusão de entregadores: Finalizado

PesquisarEntregador.php-> pesquisar entregadores: finalizado

PesquisarPedido.php-> pesquisar pedidos: finalizado

PesquisarPedidosCliente.php-> pesquisar pedidos do cliente: finalizado

PesquisarProduto.php-> pesquisar produtos: Finalizado

EditarProduto.php->Tela de edição de dados dos produtos: Finalizado

EditarEntregadores.php-> Tela de edição dos dados dos entregadores:finalizado

LogoutAdm.php e LogutEntregador.php-> Botão de logout de administrador e entregadores (penultima etapa): finalizado

-> Criação do menu principal (etapa final): finalizado

