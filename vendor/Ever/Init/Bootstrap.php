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
     * Receives the routes defined for the application
     * @var array 
     */
    private $routes;
    
    /**
     * Params of routes
     * @var string|array 
     */
    private $routesParams;
    
    /**
     * Current controller
     * @var string 
     */
    private $controller;
    
    /**
     * Current Action
     * @var string 
     */
    private $action;
    
    /**
     * Method contruct
     * Sets whether errors are displayed or not.
     * Executes the methods defined in the Init 
     * class with the name starting with Init.
     * Defines the application routes.
     */
    public function __construct() 
    {
        $this->setShowErrors();
        $this->loadMethods();
        
        $routes = require_once APP_PATH . '/config/routes.php';
        $this->setRoutes($routes);        
    }
    
    /**
     * Sets whether errors are displayed or not.
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
     * Loads and executes the methods defined in child class that contains 
     * the word Init.
     */
    private function loadMethods()
    {
        // Get the name of the child class
        $classChildren = get_called_class();
        
        // Get all the methods of the class itself and child class
        $methods = get_class_methods($classChildren);
        
        // Performing the methods
        foreach ($methods as $method) {
            if (!is_bool(strpos($method, 'Init'))) {
                $classChildren::$method();
            }
        }
    }
    
    /**
     * Defines the application routes
     * 
     * @param array $routes array containing the defined routes
     */
    private function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Travels the route and checks if the present URL is the same as the route, 
     * if applicable, controller, action and parameters are set to the 
     * values set in the route
     * 
     * @param String $url Current url
     */
    public function verifyUrlInRoutes($url)
    {     
        foreach ($this->routes as $route => $value) {
            $route = $this->checkAndReplaceRegexInRoute($route, $url, $value);
            
            if ($route == $url) {
                $this->controller = empty($value[0]) ? 'index' : $value[0];
                $this->action = empty($value[1]) ? 'index' : $value[1];

                if (!empty($this->routesParams)) {
                    View::setParams($this->routesParams);
                }
                
                break;
            }
        }
    }
    
    /**
     * Check and replace regex in route
     * 
     * @param string $route  route to check
     * @param string $url    current url
     * @param array  $params params defined in route
     * @return string
     */
    private function checkAndReplaceRegexInRoute($route, $url, $params = null)
    {
        $pattern = '/^' . 
            str_replace(
                ['(any)', '(str)', '(num)', '/'], 
                ['(.+)', '(\w+)', '(\d+)', '\/'], 
                $route
            ) 
        . '$/';
        
        $matches = '';
        
        if (preg_match($pattern, $url, $matches)) {
            $route = preg_replace($pattern, $url, $url);
            
            $this->checkAndReplaceRegexInParams($matches, $params);
        }
        
        return $route;
    }
    
    /**
     * Check and replace regex in params
     * 
     * @param array $matches regex matches of route
     * @param array $params  params of route
     */
    private function checkAndReplaceRegexInParams($matches, $params)
    {
        $this->routesParams = isset($params[2]) ? $params[2] : '';
        
        foreach ($matches as $key => $matche) {
            if (!empty($this->routesParams) && in_array('$' . $key, $this->routesParams)) {
                $this->routesParams = str_replace('$' . $key, $matche, $this->routesParams);
            }
        }
    }

    /**
     * Dispatches the user to the controller and action seeking the current url 
     * and routes by checking that the URL listed on the routes, if not record, 
     * will dispachado to the controller and action set in the url, if not set 
     * in the url the controller and action to application will dispatch to the 
     * controller and the index action.
     */
    public function run()
    {
        // Current url
        $url = View::getCurrentUrl();

        // Runs along the routes by checking that the URL belongs to some route
        $this->verifyUrlInRoutes($url);

        // If the url does not belong to any route, 
        // the controller and action will be set
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