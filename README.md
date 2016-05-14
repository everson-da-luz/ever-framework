![Ever Framework](http://www.eversondaluz.com.br/images/ever-framework-logo.png)
Bem-vindo ao Ever Framework!
===================

Ever Framework é um simples framework PHP. Foi desenvolvido em busca de simplicidade e facilidade de uso. Como está na sua primeira versão ainda tem poucos métodos para um melhor aproveitamento, mas aos poucos será acrescentado mais funcionalidades. 

##Documentação

###Estrutura de pastas

Ever Framework está dividido em três diretórios principais:

- **app**: Onde irá ficar sua aplicação. Também irá conter o MVC do sistema, bem como arquivos de configurações e o seus arquivos de inicialização.
- **public**: Este diretório contém todos os arquivos públicos para a sua aplicação como css, scripts, imagens, etc. Bem como o index.php onde irá rodar toda a aplicação. Também  é a raiz da web do seu servidor, que normalmente é definido para este diretório.
- **vendor**: Este diretório irá conter as bibliotecas de terceiros, e também a biblioteca interna do Ever Framework.

> **Observação**
> Ever Framework disponibiliza um arquivo **.htaccess** no mesmo nível desses três diretórios, mas o mesmo não é obrigatório, ele apenas serve caso sua aplicação esteja sendo desenvolvida em um ambiente local, onde geralmente sua aplicação fica dentro de uma pasta na raiz do servidor, sendo assim esse .htaccess irá setar a pasta raiz da aplicação como a pasta public.  Caso esteja em ambiente de produção a aplicação já irá ser direcionada para a pasta public.

###Arquivo de inicialização
No arquivo **index.php**, após serem setados alguns diretórios e configurações necessárias, é instanciada a classe de inicialização, essa classe herda a classe interna **Bootstrap**. A classe de inicialização contida no diretório **app**, que por padrão é o arquivo **Init.php**, irá ser executada antes mesmo de ser definido para onde será despachado o usuário. Com isso pode se utilizar métodos para diversas tarefas, e para que métodos nessa classe possam ser executados automaticamente, basta utilizar a palavra **Init** conforme exemplo a seguir:
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
    'db_charset' => 'utf8'
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
Para enviar algum dado para a view, como variáveis, arrays, objetos do banco, etc, basta utilizar o atributo **view**, seguido do nome que esse dado vai receber e por último o seu valor, como por exemplo:
```php
$this->view->data = 'valor do dado';
```
No arquivo de view para exibir o valor enviado do controller:
```php
<?= $this->view->data ?>
```
Irá imprimir "valor do dado" na tela.

###Parâmetros
Para resgatar um parâmetro especifico no **controller**:
```php
$this->getParam('nome-do-parametro');
```
Para resgatar todos os parâmetros basta utilizar o mesmo método, porém sem passar o nome do parâmetro, isso irá retornar um array com todos os parâmetros definidos na url ou na rota:
```php
$this->getParam();
```
###Error Controller
No arquivo **app/config/config.php** você pode definir qual vai ser o controller que fará manipulação de erros. Por padrão é o **Error.php**, mas você pode alterar, apenas modificando a constante no arquivo config.
```php
define('ERROR_CONTROLLER', 'Error');
```
No controller Error você resgata os erros vindo de um exception, resgatando com o parâmetro **error**.
```php
$error = $this->getParam('error');
```
Com isso basta enviar os erros para a view e manipular ao seu gosto.
```php
$this->view->error = $error;
```
Para lançar um exception e manipula-lo no controller error, basta utiliziar a classe interna do Ever Framework chamada **Exception**, que estende a classe nativa do PHP Exception. Com isso basta colocar o código em um bloco **try catch**, e utilizar o método **errorHandler()**.
```php
try {
	// Código            
} catch (\Ever\Exception\Exception $e) {
    \Ever\Exception\Exception::errorHandler($e);
}
```
Caso haja algum erro no código o usuário será despachado para o Error Controller, e lá você pode manipular o erro e exibir páginas como a 404, 500, etc.

###Model
Os models herdam a classe interna do Ever chamada **Table**, a classe Table utiliza um objeto da classe nativa do PHP chamada **PDO**, por isso todos os métodos do PDO são aceitáveis pela instancia do Model criado. Para utilizar um model basta instanciar a classe desejada, como por exemplo:
```php
$model = new \App\Models\MyModel();
```
Caso não queira escrever todo o caminho do namespace, basta usar o namespace no começo do arquivo:
```php
use App\Models;
```
Para definir qual a tabela do banco de dados que o model irá utilizar, basta definir o nome da tabela no atributo protegido chamado **$table**:
```php
protected $table = "tabela";
```
Para manipular querys você pode usar a instância da classe ou dentro do próprio model.

Para fazer uma consulta:
```php
$this->select();
$this->fetchAll();
```
O método **fetchAll()** pode receber como parâmetro o tipo de retorno da consulta, para isso pode-se passar os seguintes valores:

 - **fetch_assoc**:  voltará cada linha como um array indexado pelo nome da coluna como índices.
 - **fetch_num**: voltará cada linha como um array indexado pelo número da coluna como índices.
 - **fetch_obj**: voltará cada linha como um objeto com nomes de propriedade que correspondem aos nomes das colunas.
 - **fetch_both**: voltará cada linha como um array indexada tanto pelo nome da coluna e número da coluna, a partir de coluna 0 .

Caso não seja especificado o padrão é **fetch_both**.

Para consultar somente uma ou mais colunas:
```php
// Retorna somente o valor da coluna nome
$this->select('nome');
$this->fetchAll();

// Retorna o valor da coluna id e nome
$this->select(array('id', 'nome'));
$this->fetchAll();

// Retorna o valor da coluna id e nome
// Porém colocando um apelido em cada uma
$this->select(array(
	'id'   => 'identificador', 
	'nome' => 'apelido'
));
$this->fetchAll();
```

Para unir mais tabelas você pode utilizar o método **join()**:
```php
join($table, $condition, $fields = null, $joinType = null)
```
Por exemplo:
```php
$this->select(array('id', 'nome'));
$this->join('outra_tabela', 'outra_tabela.id = tabela.id', array('id', 'conteudo'), 'left');
$this->fetchAll();
```
Tipos de join:

 - **left**
 - **right**
 - **inner**: Padrão caso não seja informado

Condição na consulta:
```php
$this->select();
$this->where('id = 2');
$this->fetchAll();
```
Multiplas condições:
```php
$this->select();
$this->where(array('id => 2', 'nome' => 'joao'));
$this->fetchAll();
```

Ordenar consulta:
```php
$this->select();
$this->order('nome DESC'); // ou ASC
$this->fetchAll();
```

Limitar consulta:
```php
$this->select();
$this->limit(2);
$this->offset(3); // Se necessário
$this->fetchAll();
```
Inserindo dados (Insert):
Use a instância do model e o método **insert**, passando um array contendo o nome da coluna e o seu valor.
```php
$model = new Models\MyModel();
$model->insert(array(
    'coluna1' => 'valor1', 
    'coluna2' => 'valor2'
));
```
Editando dados (Update)
Use a instância do model e o método **update**, passado a condição como segundo parâmetro.
```php
$model = new Models\MyModel();
$model->update(array('coluna1' => 'valor1', 'coluna2' => 'valor2'), 'id = 1');
```
Deletando dados (Delete)
Use a instância do model e o método **delete**, a condição como segundo parâmetro.
```php
$model = new Models\MyModel();
$model->delete('id = 3');
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
