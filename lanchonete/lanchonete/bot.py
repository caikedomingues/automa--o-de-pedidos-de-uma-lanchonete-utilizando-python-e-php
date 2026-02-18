
from botcity.core import DesktopBot


class Bot(DesktopBot):
    def action(self, execution=None):
      
       while True:  
            # Searching for element 'nova_mensagem '
            if self.find("nova_mensagem", matching=0.97, waiting_time=10000):
                    print("nova mensagem encontrada")
                    
                    self.click()
                            
                    self.paste("Ola, por favor, digite sua mensagem aqui")
                            
                    # Searching for element 'enviar_mensagem '
                    if self.find("enviar_mensagem", matching=0.97, waiting_time=10000):
                            print("Mensagem Enviada")
                            self.click()
                    
                    # Searching for element 'resposta_cliente '
                    if self.find("resposta_cliente", matching=0.97, waiting_time=10000):
                        
                        pass

                        
                    
                    

       
    def not_found(self, label):
        print(f"Element not found: {label}")


if __name__ == '__main__':
    Bot.main()









