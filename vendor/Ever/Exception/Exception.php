<?php
/**
 * Ever Framework
 */

namespace Ever\Exception;

use Ever\View\View;

/**
 * @category  Ever
 * @package   Exception
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
class Exception extends \Exception
{
    /**
     * Resgata uma exception e despacha a aplicação
     * para o controller de erros definido na constante <b>CONTROLLER_FOLDER</b>,
     * caso não tenha sido definido o controller para erros,
     * sera despachado para um layout padrão de erros.
     * 
     * @param \Exception $e Exceção lançada.
     */
    public static function errorHandler($e)
    {
        $error = array(
            'error' => array(
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine()
            )
        );

        View::setParams($error);
        
        if (file_exists(APP_PATH . DS . CONTROLLER_FOLDER . DS . ucfirst(ERROR_CONTROLLER) . '.php')
            && defined('ERROR_CONTROLLER')) {
            $classError = "\\App\\" . ucfirst(CONTROLLER_FOLDER) . "\\Error";
            $errorController = new $classError();
            $errorController->index();
        } else {
            echo self::defaultLayoutError($e);
        }
    }
    
    /**
     * Layout padrão de erros, caso o controller de manipulação
     * de erros não tenha sido definido.
     * 
     * @param \Exception $e Exceção lançada
     * @return String
     */
    private static function defaultLayoutError($e)
    {
        $html = <<<ERROR
            <h1>{$e->getCode()} - An error has occurred</h1>
            <h2>{$e->getMessage()}</h2>
            <p>Arquivo: <b>{$e->getFile()}</b></p>
            <p>Linha: <b>{$e->getLine()}</b></p>
ERROR;
        return $html;
    }
}