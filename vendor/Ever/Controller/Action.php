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
     * Recebe uma classe std, para poder ser passado atributos para view
     * @var stdClass 
     */
    protected $view;
    
    /**
     * Nome da action atual
     * @var string 
     */
    protected $action;
    
    /**
     * Método construtor
     * Executa o método construtor da classe View.
     * Defini o atributo view como um objeto da classe std.
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->view = new \stdClass;
    }
    
    /**
     * Renderiza o usuário para a view.
     * Recebendo a nome da action no qual a aplicação deve incluir,
     * e também verifica se essa action vai conter um layout ou não. 
     * 
     * @param String  $action Nome da action
     * @param Boolean $layout Se a view vai conter layout ou não
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
     * Inclui o arquivo da view correspondente com a action
     */
    public function content()
    {
        $classAtual = get_class($this);
        $singleClassName = strtolower(str_replace('App\\' . ucfirst(CONTROLLER_FOLDER) . '\\', '', $classAtual));

        try {
            if (file_exists(APP_PATH . '/views/' . $singleClassName . '/' . $this->action . '.phtml')) {              
                require_once APP_PATH . '/views/' . $singleClassName . '/' . $this->action . '.phtml';
            } else {
                throw new \Ever\Exception\Exception("File {$this->action}.phtml does not exist", 404);
            }
        } catch (\Ever\Exception\Exception $e) {
            \Ever\Exception\Exception::errorHandler($e);
        }
    }
}