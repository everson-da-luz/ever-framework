<?php
/**
 * Ever Framework
 */

namespace Ever\Init;

use Ever\View\View;

/**
 * @category  Ever
 * @package   Init
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
class Bootstrap
{
    /**
     * Recebe as rotas setadas para a aplicação
     * @var array 
     */
    private $routes;
    
    /**
     * Controller atual
     * @var string 
     */
    private $controller;
    
    /**
     * Action atual
     * @var string 
     */
    private $action;
    
    /**
     * Método construtor
     * Seta se exibirá os erros ou não.
     * Executa os métodos setados na class Init com o nome que comece com Init.
     * Seta as rotas da aplicação.
     */
    public function __construct() 
    {
        $this->setShowErrors();
        $this->loadMethods();
        
        $routes = require_once APP_PATH . '/config/routes.php';
        $this->setRoutes($routes);        
    }
    
    /**
     * Seta se será exibido os erros ou não
     */
    public function setShowErrors()
    {
        if (defined('DISPLAY_ERROR') && DISPLAY_ERROR == 1) {
            error_reporting(E_ALL);
        } else {
            error_reporting(0);
        }
    }

    /**
     * Carrega e executa os métodos setados na classe filha
     * que contenha a palavra Init.
     */
    private function loadMethods()
    {
        // Obtêm o nome da classe filha
        $classChildren = get_called_class();
        
        // Obtêm todos os métodos da própria classe e da classe filha
        $methods = get_class_methods($classChildren);
        
        // Percorre e executa os métodos
        foreach ($methods as $method) {
            if (!is_bool(strpos($method, 'Init'))) {
                $classChildren::$method();
            }
        }
    }
    
    /**
     * Seta as rotas da aplicação
     * 
     * @param array $routes array contendo as rotas definidas
     */
    private function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }
    
    /**
     * Percorre as rotas verificando se a url pertence a alguma rota,
     * caso pertença será setados o controller, action e params 
     * pertencentes aquela rota
     * 
     * @param String $url Url atual
     */
    public function verifyUrlInRoutes($url)
    {
        array_walk($this->routes, function($route) use ($url) {
            if ($url == $route['route']) {
                $this->controller = empty($route['controller']) ? 'index' : $route['controller'];
                $this->action = empty($route['action']) ? 'index' : $route['action'];
                
                // Se definido paramêtros para essa rota será setado
                if (isset($route['params']) && !empty($route['params'])) {
                    $funcArray = array_map(
                        function ($v, $k) { 
                            return $k . '/' . $v; 
                        }, 
                        $route['params'], 
                        array_keys($route['params'])
                    );

                    $params = implode('/', $funcArray);
                    
                    View::setParams('/' . $this->controller . '/' . $this->action . '/' . $params);
                }
            }
        });
    }

    /**
     * Despacha o usuário para o controller e action
     * buscando a url atual e as rotas, verificando se a url
     * consta nas rotas, caso não conste,
     * será dispachado para o controller e action setados na url,
     * caso não esteja setado na url o controller e action
     * a aplicação irá despachar para o controller e action index.
     */
    public function run()
    {
        // Url atual
        $url = View::getCurrentUrl();
        
        // Percorre as rotas verificando se a url pertence a alguma rota
        $this->verifyUrlInRoutes($url);

        // Se a url não pertence a nenhuma rota, será setado o controller e action
        if (empty($this->controller) || empty($this->action)) {
            $segments = explode('/', $url);

            $this->controller = empty($segments[0]) ? 'index' : $segments[0];
            $this->action = empty($segments[1]) ? 'index' : $segments[1];
            
            View::setParams($url);
        }
        
        $class = "App\\" . ucfirst(CONTROLLER_FOLDER) . "\\" . ucfirst($this->controller);  
        
        try {
            if (!file_exists(APP_PATH . DS . CONTROLLER_FOLDER . DS . ucfirst($this->controller) . '.php')) {
                throw new \Ever\Exception\Exception("Controller {$this->controller} does not exist", 404);
            }
            
            $controllerClass = new $class;

            if (!method_exists($controllerClass, $this->action)) {
                throw new \Ever\Exception\Exception("Action {$this->action} does not exist", 404);
            }
            
            $controllerClass->{$this->action}();
        } catch (\Ever\Exception\Exception $e) {
            \Ever\Exception\Exception::errorHandler($e);
        }
    }
}