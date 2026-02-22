

from botcity.core import DesktopBot


class Bot(DesktopBot):
    def action(self, execution=None):
      
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
                if not self.find("botao_copiar", matching=0.97, waiting_time=10000):
                    self.not_found("botao_copiar")
                self.click()
                
                
                mensagem_cliente = self.get_clipboard().strip().lower()
                
                print(mensagem_cliente)
                
                
                

                
               
                    
                
                    
              
            
            else:
                
                print("Não há novas mensagens")
                    
                     
                         
                        
                      
                    
                            
                        
                            
                   
                    
                    
                        
                        
                    
                   
                        
    def not_found(self, label):
        print(f"Element not found: {label}")


if __name__ == '__main__':
    Bot.main()




























