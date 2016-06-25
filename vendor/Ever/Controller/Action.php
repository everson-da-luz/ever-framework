<?php
/**
 * Ever Framework
 */

namespace Ever\Controller;

use Ever\View\View;

/**
 * @category  Ever
 * @package   Controller
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
class Action extends View
{   
    /**
     * You receive a std class in order to be passed attributes to view
     * @var stdClass 
     */
    protected $view;
    
    /**
     * Current action name
     * @var string 
     */
    protected $action;
    
    /**
     * Construct method
     * Runs the constructor method of the View class.
     * Define the view attribute as an object of std class.
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->view = new \stdClass;
    }
    
    /**
     * Renders the user to view.
     * Receiving the name of action on which the application must include, 
     * and also checks whether the action will contain a layout or not. 
     * 
     * @param String  $action action name
     * @param Boolean $layout If the view will contain layout or not
     */
    public function render($action, $layout = true)
    { 
        $this->action = $action;

        if ($layout == true && file_exists($this->getLayoutPath())) {
            require $this->getLayoutPath();
        } else {
            $this->content();
        }
    }
    
    /**
     * It includes the corresponding view file with the action
     */
    public function content()
    {
        $classAtual = get_class($this);
        $singleClassName = strtolower(
            str_replace('App\\' . ucfirst(CONTROLLER_FOLDER) . '\\', 
                '', $classAtual)
            );

        try {
            if (file_exists(APP_PATH . '/views/' . $singleClassName . '/' . 
                    $this->action . '.phtml')) {              
                require_once APP_PATH . '/views/' . $singleClassName . '/' . 
                        $this->action . '.phtml';
            } else {
                throw new \Ever\Exception\Exception("
                    File {$this->action}.phtml does not exist", 404);
            }
        } catch (\Ever\Exception\Exception $e) {
            \Ever\Exception\Exception::errorHandler($e);
        }
    }
}