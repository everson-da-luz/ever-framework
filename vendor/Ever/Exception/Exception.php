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
     * Redeems an exception and dispatches the application to the error 
     * controller defined in constant <b> CONTROLLER_FOLDER </ b> if you have 
     * not set the controller for error, will be dispatched to an error 
     * standard layout.
     * 
     * @param \Exception $e exception thrown
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
        
        if (file_exists(APP_PATH . DS . CONTROLLER_FOLDER . DS . 
            ucfirst(ERROR_CONTROLLER) . '.php') && defined('ERROR_CONTROLLER')) {
            $classError = "\\App\\" . ucfirst(CONTROLLER_FOLDER) . "\\Error";
            $errorController = new $classError();
            $errorController->index();
        } else {
            echo self::defaultLayoutError($e);
        }
    }
    
    /**
     * Error standard layout, if the error handling controller has not been set.
     * 
     * @param \Exception $e exception thrown
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