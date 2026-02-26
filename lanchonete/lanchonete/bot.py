

from botcity.core import DesktopBot



    


class Bot(DesktopBot):
    def action(self, execution=None):
        
        def campo_mensagem():
            # Searching for element 'campo_mensagem'
            if not self.find("campo_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("campo_mensagem")
            self.click()
        
        def enviar_mensagem():
            
            if not self.find("enviar_mensagem", matching=0.8, waiting_time=10000):
                self.not_found("enviar_mensagem")
            self.click()
            
                  
        while True:  
            # Searching for element 'nova_mensagem '
            nova_mensagem = self.find("nova_mensagem", matching=0.97, waiting_time=10000)
            
            if nova_mensagem:
                
                self.click()
                
                # Searching for element 'mensagem_cliente '
                if not self.find("mensagem_cliente", matching=0.97, waiting_time=10000):
                    self.not_found("mensagem_cliente")
                
                self.click()
                
                self.right_click()
                
                # Searching for element 'botao_copiar '
                if not self.find("botao_copiar", matching=0.8, waiting_time=10000):
                    self.not_found("botao_copiar")
                self.click()
                
                texto_mensagem = self.get_clipboard().strip().lower()
                
                
                lista_pedidos = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"]
                
                lista_saudacoes = ["bom dia", "boa tarde", "boa noite", "ola", "olá", "oi", "opa"]
                
                
                if texto_mensagem in lista_saudacoes:
                    
                     # Searching for element 'campo_mensagem '
                    campo_mensagem()
                    
                    self.paste(f"Ola, escolha uma das nossas opções: {lista_pedidos}")
                    
                    enviar_mensagem()
                    self.key_esc()
                          
                elif any(opcao in texto_mensagem for opcao in lista_pedidos):
                    
                    for id_produto in lista_pedidos:
                        
                        if id_produto in texto_mensagem:
                            
                            print("Ids encontrados: ", id_produto)
                    
                    campo_mensagem()
                    
                    self.paste("Pedido realizado com sucesso")
                    
                    # Searching for element 'enviar_mensagem '
                    enviar_mensagem()
                    
                    self.key_esc()
                    
                else:
                    
                     campo_mensagem()
                     
                     self.paste("Não entendi a solicitação, por favor, mande um 'ola' e reinicie a conversa")
                     
                     # Searching for element 'enviar_mensagem '
                     enviar_mensagem()
                     
                     self.key_esc()
                    
                
            else:
                
                print("Não há novas mensagens")
                             
                        
    def not_found(self, label):
        print(f"Element not found: {label}")


if __name__ == '__main__':
    Bot.main()







































