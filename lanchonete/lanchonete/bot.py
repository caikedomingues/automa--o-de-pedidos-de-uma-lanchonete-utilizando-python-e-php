
# Import da classe DesktopBot do módulo core da biblioteca
# BotCity que tera como objetivo "transferir" os seus metodos
# para a classe bot que ira conter os códigos necessários para 
# a construção da aplicação.
from botcity.core import DesktopBot

# Import do arquivo que contém as funções que irão manipular
# o banco de dados.
import BancoAutomacao

# Classe que irá conter as funções que irão mandar e receber mensagens,
# salvar pedidos no banco de dados. A classe ira herdar os metodos da
# classe DesktopBot
class Bot(DesktopBot):
    
    # Função que ira conter o bloco de código da aplicação
    # self: argumento que usamos como referência para 
    # acessar os metodos da classe que está sendo herdada.
    def action(self, execution=None):
        
        # Essa variável terá como objetivo, mostrar para o sistema a etapa em que 
        # a conversa está, ou seja, se esta na etapa de coleta de cpfs, endereços
        # e pedidos. Ela tera como valor inicial "inicio atendimento" que significa
        # que a conversa esta na etapa inicial (escolha do produto que o cliente
        # quer receber).
        
        # Nessa parte do código, criei funções que irão conter os blocos que irão
        # se repetir regularmente na nossa aplicação.
        self.status_atendimento = "Inicio atendimento"
        
        # Função que tera como objetivo acessar o campo de mensagem no whatsapp
        def campo_mensagem():
            # trecho gerado pelo botcity através da captura de imagem do elemento
            # que queremos acessar
            if not self.find("campo_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("campo_mensagem")
            self.click()
        
        # Função que terá como objetivo acessar o botão de envio do cpf
        def enviar_mensagem():
            
            if not self.find("enviar_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("enviar_mensagem")
            self.click()
        
        # Função que tera como objetivo acessar o campo, escrever uma mensagem
        # e envia-la. Essa etapa será feita mo momento de coleta do cpf.
        # Observação: precisei fazer assim por que antes ele não estava
        # encontrando o campo de mensagem.
        def pegar_cpf():
            
            if not self.find("campo_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("campo_mensagem")
            self.click()
            
            self.paste("Informe o seu cpf para localizarmos o seu pedido")
            
            if not self.find("enviar_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("enviar_mensagem")
            self.click()
            
        # Função que irá realizar as 3 etapas (acessar o campo de mensagem, escrever mensagem e enviar
        # mensagem) com o objetivo de coletar o endereço do cliente.
        def pegar_endereco():
            
            if not self.find("campo_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("campo_mensagem")
            self.click()
            
            self.paste("Informe o seu endereço")
            
            if not self.find("enviar_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("enviar_mensagem")
            self.click()
        
        # Lista que ira guardar os ids dos produtos que o cliente escolheu.
        self.ids_escolhidos = []
        
        # Variável que ira guardar o cpf dos clientes. A variável terá como valor
        # inicial o None.
        self.cpf = None
        
        # Variável que ira guardar o endereço dos clientes. A variável terá como valor
        # inicial o None.
        self.endereco = None    
            
        # Loop infinito que irá ficar procurando e respondendo novas mensagens.                  
        while True:  
            # Searching for element 'nova_mensagem '
            
            # Código gerado pelo botcity que irá monitorar o campo de notificações
            # com o objetivo de identificar novas mensagens.
            nova_mensagem = self.find("nova_mensagem", matching=0.97, waiting_time=10000)
             
             # Ira verificar se há uma nova mensagem no campo de notificações do whatsapp
            if nova_mensagem:
                
                # Se o sistema identificar uma nova mensagem, ele clicara
                # no campo de notificações e abrira a conversa com o contato que
                # enviou a mensagem.
                self.click()
                
                # Searching for element 'mensagem_cliente'. Codigo gerado pelo BotCity
                # que irá identificar a mensagem enviada pelo cliente.
                if not self.find("mensagem_cliente", matching=0.97, waiting_time=10000):
                    self.not_found("mensagem_cliente")
                
                # Ira clicar na mensagem enviada pelo cliente
                self.click()
                
                # Ira clicar com o botão direito na mensagem do cliente
                self.right_click()
                
                # Searching for element 'botao_copiar. Codigo gerado pelo botcity
                # que irá identificar o botão de copiar mensagem da mensagem enviada
                # pelo usuário
                if not self.find("botao_copiar", matching=0.8, waiting_time=10000):
                    self.not_found("botao_copiar")
                self.click()
                # Ira armazenar a mensagem enviada pelo usuário com o objetivo de realizar
                # comparações na estrutura condicional que irá guiar a conversa do sistema
                # com o usuário.
                texto_mensagem = self.get_clipboard().strip().lower()
                
                # Ira conter as possiveis "primeiras mensagens" dos clientes. Vamos usar essa lista
                # para indicar para o sistema o que ele deve responder caso a mensagem do usuário 
                # tenha as segunites palavras/frases da lista.
                lista_saudacoes = ["bom dia", "boa tarde", "boa noite", "ola", "olá", "oi", "opa"]
                
                # Ira conter a lista de ids dos produtos que o cliente pode escolher. Vamos
                # usar essa lista para salvar apenas os ids presentes na mensagem do cliente.
                # Dessa forma, não precisaremos nos preocupar com o salvamento de informações
                # desnecessarias, já que a mensagem passará por uma validação baseada na lista
                # de ids.
                lista_pedidos = BancoAutomacao.lista_ids()    

                # ira conter as informações dos produtos de forma formatada para que 
                # o sistema consiga enviar a mensagem para o cliente da forma mais
                # clara possível.
                mensagem_sistema = BancoAutomacao.consultarprodutos()
                
                
                if self.status_atendimento == "Inicio atendimento":
                    
                    # Se o status de atendimento estiver no inicio do atendimento, vamos verificar
                    # se o texto_mensagem contém no conteudo da mensagem algum dos ids presentes
                    # na lista.
                    if texto_mensagem in lista_saudacoes:
                    
                        # Ira acessar o campo da mensagem.
                        campo_mensagem()

                        # Ira escrever a mensagem que solicita a escolha do usuário usando a variável
                        # mensagem_sistema
                        self.paste(f"Ola, escolha os numeros dos produtos que deseja pedir: {mensagem_sistema}")

                        # Função que irá apertar o botão de enviar 
                        # a mensagem
                        enviar_mensagem()
                        
                        # Ira sair da mensagem com o objetivo de aguardar e identificar a
                        # resposta do usuário.
                        self.key_esc()
                        
                        # Vamos mudar o status do atendimento para indicar para o sistema
                        # s etapa que a conversa se encontra.                       
                        self.status_atendimento = "Aguardando atendimento"
                
                elif self.status_atendimento == "Aguardando atendimento":
                    
                    # Se o status da conversa for 'Aguardando atendimento', vamos usar
                    # a função any na estrutura if para facilitar a identificação do 
                    # pedido do cliente. 
                    
                    # any: função nativa do python que tem como
                    # objetivo verificar condições em listas ou
                    # coleções. De forma simples, ela serve para
                    # dizer se pelo menos um item da lista é
                    # verdadeiro. Ela recebe como argumento 
                    # um bloco de codigo iteravel (um for)
                    # que ira percorrer a lista de pedidos
                    # comparando os valores da lista com os
                    # conteudos presentes na mensagem. Dessa forma
                    # ele retornara True se encontrar pelo menos um
                    # elemento verdadeiro e False se todos os elementos
                    # forem falsos (ou se a lista estiver vázia).
                    if any(opcao in texto_mensagem for opcao in lista_pedidos):
                        
                        # Se essa condição for verdadeira, precisaremos
                        # salvar na lista de ids apenas os itens
                        # presentes na lista de pedidos. Ou seja,
                        # precisamos evitar que o sistema adicione na
                        # lista conteudos que não fazem parte do grupo de id 
                        # da lista de pedidos. Para isso vamos "quebrar/dividir"
                        # o texto da mensagem com o objetivo de facilitar a 
                        # captura do id. Vamos fazer isso usando a função split que
                        # tem como objetivo separar as palavras que compóem uma string.
                        palavras_mensagens = texto_mensagem.split()
                        
                        # Após a separação das palavras, vamos percorrer a string com 
                        # o objetivo de verificar se cada palavra da mensagem é igual
                        # a um dos ids presentes na lista de pedidos. 
                        for id_produto in palavras_mensagens:
                            
                            if id_produto in lista_pedidos:

                                # Se alguma das palavras presentes no conteudo da mensagem
                                # forem iguais a um dos ids presentes na lista de pedidos
                                # vamos adicionar essa palavra na lista de ids dos produtos escolhidos
                                self.ids_escolhidos.append(id_produto)
                        
                        # Após a inserção dos ids na lista, vamos chamar a função que irá solicitar
                        # o cpf do usuário
                        pegar_cpf()
                        
                        # Apos solicitar o cpf, vamos mudar o status da conversa para indicar
                        # para o sistema a etapa que a conversa se encontra.                      
                        self.status_atendimento = "Aguardando endereco"
                        
                        # Irá sair da conversa e aguardará uma resposta do cliente.
                        self.key_esc()
                        
                elif self.status_atendimento == "Aguardando endereco":
                    
                    # Se o status da conversa for 'Aguardando endereco',
                    # vamos armazenar o cpf do usuário na variável cpf
                    self.cpf = texto_mensagem

                    # Vamos chamar a função que irá solicitar o endereço do cliente
                    pegar_endereco()
                    
                    # Irá sair da conversa e aguardará uma resposta do cliente.
                    self.key_esc()
                    
                    # Ira mudar o status do atendimento para indicar para o sistema
                    # a etapa que a conversa se encontra.
                    self.status_atendimento = "Agradecimento"
                
                elif self.status_atendimento == "Agradecimento":
                    
                    # Se o status da mensagem for igual a 'Agradecimento', vamos
                    # salvar o endereço do usuário na variável.
                    self.endereco = texto_mensagem
                    
                    # Ira acessar o campo de mensagem
                    campo_mensagem()
                    
                    # Ira escrever uma mensagem de despedida
                    self.paste("pedido realizado com sucesso")
                    
                    # Ira apertar o botão de envio de mensagem.
                    enviar_mensagem()
                    
                    # Ira chamar a função que ira inserir os dados do pedido no banco de dados
                    self.informações_pedidos = BancoAutomacao.criarpedidos(self.ids_escolhidos, self.cpf, self.endereco)
                    
                    # Ira armazenar o retorno da função que consulta os codigos dos pedidos no banco
                    # de dados.
                    self.codigos_pedidos = BancoAutomacao.consultar_codigo_pedido(self.cpf)
                    
                    # Ira acessar o campo de mensagem
                    campo_mensagem()
                    
                    # Ira escrever uma mensagem que contém as principais informações dos clientes usando as variáveis
                    # que utilizamos para armazenar os dados.
                    self.paste(f"Dados da entrega -> cpf: {self.cpf}, endereço: {self.endereco}, produtos: {self.ids_escolhidos}, valor total: {self.informações_pedidos}, codigo(s) do(s) pedido(s): {self.codigos_pedidos}")
                    
                    # Ira enviar a mensagem.
                    enviar_mensagem()
                    
                    # Ira limpar a lista de ids escolhidos com o objetivo de 
                    # nao misturar os pedidos do cliente antigo com o atual.
                    self.ids_escolhidos.clear()
                    
                    # Ira sair da conversa 
                    self.key_esc()

                    # Ira voltar para a etapa inicial do sistema para aguardar novas mensagens.
                    self.status_atendimento = "Inicio atendimento"
                    
                   
                else:
                    
                    # Se a mensagem do usuário não estiver na lista de saudações,
                    # vamos enviar uma mensagem solicitando a reinicialização do
                    # atendimento.
                     campo_mensagem()
                     
                     self.paste("Não entendi a solicitação, por favor, mande um 'ola' e reinicie a conversa")
                     
                     # Searching for element 'enviar_mensagem '
                     enviar_mensagem()
                     
                     self.key_esc()    
                     
            else:
                
                # Impressão que aparecerá no sistema enquanto ele não encontrar novas mensagens.
                print("Não há novas mensagens")
                             
     
     # Função que só sera chamada se o sistema não encontrar o elemento que o python
     # está tentando acessar. A função ira receber como argumento o nome do elemento
     # não encontrado                   
    def not_found(self, label):
        print(f"Element not found: {label}")


if __name__ == '__main__':
    # Ira criar a classe bot
    Bot.main()






































