![Ever Framework](http://www.eversondaluz.com.br/images/ever-framework-logo.png)
Bem-vindo ao Ever Framework!
===================

Ever Framework é um simples framework PHP. Foi desenvolvido em busca de simplicidade e facilidade de uso.

##Documentação

###Estrutura de pastas

Ever Framework está dividido em três diretórios principais:

- **app**: Onde irá ficar sua aplicação. Também irá conter o MVC do sistema, bem como arquivos de configurações e o seus arquivos de inicialização.
- **public**: Este diretório contém todos os arquivos públicos para a sua aplicação como css, scripts, imagens, etc. Bem como o index.php onde irá rodar toda a aplicação. Também  é a raiz da web do seu servidor, que normalmente podem ser definidas para este diretório.
- **vendor**: Este diretório irá conter as bibliotecas de terceiros, e também a biblioteca do interna do Ever Framework.

> **Observação**
> Ever Framework disponibiliza um arquivo **.htaccess** no mesmo nível desses três diretórios, mas o mesmo não é obrigatório, ele apenas serve caso sua aplicação esta sendo desenvolvida em ambiente local, onde geralmente sua aplicação fica dentro de uma pasta na raiz do servidor, sendo assim esse .htaccess irá setar a pasta raiz do aplicação como a pasta public.  Caso esteja em ambiente de produção a aplicação já irá ser direcionada para a pasta public.

###Arquivo de inicialização
No arquivo **index.php**, após serem setados alguns diretórios e configurações necessárias, é instanciada a classe de inicialização, essa classe herda a classe interna **Bootstrap**. A classe de inicialização contida no diretório **app**, irá ser executada antes mesmo de ser definido para onde será despachado o usuário. Com isso pode se utilizar métodos para diversas tarefas, e para que métodos nessa classe possam ser executados automaticamente, basta utilizar a palavra **Init* conforme exemplo a seguir:
```php
public function InitMetodo()
{
	// Alguma coisa
}
```
###Conexão com o banco de dados
No arquivo **app/config/database.php**, basta retornar um array conforme o exemplo a seguir:
```php
return array(
    'db_host'    => 'localhost',
    'db_user'    => 'usuario',
    'db_pass'    => 'senha',
    'db_name'    => 'banco',
    'db_driver'  => 'mysql',
    'db_charset' => 'utf-8'
);
```
###Rotas
Por padrão o Ever Framework utiliza a url da seguinte forma *www.site.com.br/controller/action/param1/value1/param2/value2...*
caso queira criar uma rota alternativa como por exemplo a url *entre-em-contato*, basta acrescentar essa rota no array contido no arquivo **app/config/routes.php** como o exemplo a seguir:
```php
return array(
    array(
	    'route' => 'entre-em-contato', 
	    'controller' => 'contato', 
	    'action' => 'index',
	    'params' => array(
			'param1' => 'value1',
			'param2' => 'value2'
		)
    )
);
```
