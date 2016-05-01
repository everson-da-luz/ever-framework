![Ever Framework](http://www.eversondaluz.com.br/images/ever-framework-logo.png)
Bem-vindo ao Ever Framework!
===================

Ever Framework é um simples framework PHP. Foi desenvolvido em busca de simplicidade e facilidade de uso. Como está na sua primeira versão ainda tem poucos métodos para um melhor aproveitamento, mas aos poucos será acrescentado mais funcionalidades. 

##<i class="icon-file"></i>Documentação

###Estrutura de pastas

Ever Framework está dividido em três diretórios principais:

- **app**: Onde irá ficar sua aplicação. Também irá conter o MVC do sistema, bem como arquivos de configurações e o seus arquivos de inicialização.
- **public**: Este diretório contém todos os arquivos públicos para a sua aplicação como css, scripts, imagens, etc. Bem como o index.php onde irá rodar toda a aplicação. Também  é a raiz da web do seu servidor, que normalmente é definido para este diretório.
- **vendor**: Este diretório irá conter as bibliotecas de terceiros, e também a biblioteca interna do Ever Framework.

> **Observação**
> Ever Framework disponibiliza um arquivo **.htaccess** no mesmo nível desses três diretórios, mas o mesmo não é obrigatório, ele apenas serve caso sua aplicação esteja sendo desenvolvida em um ambiente local, onde geralmente sua aplicação fica dentro de uma pasta na raiz do servidor, sendo assim esse .htaccess irá setar a pasta raiz da aplicação como a pasta public.  Caso esteja em ambiente de produção a aplicação já irá ser direcionada para a pasta public.

###Arquivo de inicialização
No arquivo **index.php**, após serem setados alguns diretórios e configurações necessárias, é instanciada a classe de inicialização, essa classe herda a classe interna **Bootstrap**. A classe de inicialização contida no diretório **app**, que por padrão é o arquivo **Init.php**, irá ser executada antes mesmo de ser definido para onde será despachado o usuário. Com isso pode se utilizar métodos para diversas tarefas, e para que métodos nessa classe possam ser executados automaticamente, basta utilizar a palavra **Init* conforme exemplo a seguir:
```php
public function InitMetodo()
{
	// Será executado automaticamente
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
Por padrão o Ever Framework utiliza a url da seguinte forma *site.com.br/controller/action/param1/value1/param2/value2...*
caso queira criar uma rota alternativa como por exemplo a url *entre-em-contato*, basta acrescentar um array com essa rota no array contido no arquivo **app/config/routes.php** como o exemplo a seguir:
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
###Controllers
Para escolher a view que a action irá utilizar, basta utilizar o método **render**:
```php
$this->render('index');
```
###Parâmetros
Para resgatar um parâmetro especifico no **controller**:
```php
$this->getParam('nome-do-parametro');
```
Para resgatar todos os parâmetros basta utilizar o mesmo método, porém sem passar o nome do parâmetro, isso irá retornar um array com todos os parâmetros definidos na url ou na rota:
```php
$this->getParam();
```
###Layouts
Por padrão os layouts estão no diretório **app/views/layouts**, e por padrão o nome do arquivo de layout é **layout.phtml**, mas caso queira alterar o nome do layout ou criar diversos arquivos para uma melhor organização, basta utilizar o método na action onde você deseja essa mudança:
```php
$this->setLayout('arquivo-de-layout');
```
Assim somente essa action irá utilizar esse layout. Nesse método não deve conter a extensão .phtml e sim somente o nome do arquivo.

Para alterar o diretório dos layouts:
```php
$this->setLayoutPath('outro-diretorio');
```
Para obter o nome do layout:
```php
$this->getLayout();
```
Para obter o caminho do layout:
```php
$this->getLayoutPath();
```
Para desabilitar o layout da view, basta setar como **false** e segundo argumento no método render que chama a view, contida nos controllers:
```php
$this->render('index', false);
```
No arquivo de layout, para chamar o conteúdo respectivo de cada view sem alterar o restando do conteúdo, basta utilizar o método **content()**, como o exemplo a seguir:
**layout.phtml**
```html
<html>
	<head>
		<!-- tags -->
	</head>
	<body>
		<header>
			<!-- cabeçalho -->
		</header>

		<?= $this->content() ?>
		
		<footer>
			<!-- rodapé -->
		</footer>
	</body>
</html>
```
