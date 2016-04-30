<?php
/**
 * Ever Framework
 */

namespace Ever\Autoload;

/**
 * @category  Ever
 * @package   Autoload
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
class Autoload
{
    /**
     * Caminhos para serem adicionados no autoloader
     * @var array 
     */
    private static $pathToAutoload = array('/', '/vendor/');
    
    /**
     * Adiciona mais um caminho para o autoloader.
     * Esse novo caminho deve conter uma barra no ínicio e fim.
     * Também executa o autoload caso alguma classe
     * não seja incluida na aplicação.
     * 
     * @param String $path Caminho para adicionar no autoload
     */
    public static function autoloadRegister($path = null) 
    {
        if (!empty($path)) {
            array_push(self::$pathToAutoload, $path);
        }
        
        spl_autoload_register('self::loader');
    }
    
    /**
     * Executa a inclusão automática das classes.
     * As classes serão procuradas nos caminhos setados
     * na propriedade <b>pathToAutoload</b>.
     * 
     * @param String $class Nome da classe para o carregamento automatico.
     */
    private static function loader($class)
    {
        $basedir = dirname(APP_PATH);
        $filename = str_replace('\\', '/', $class) . ".php";
        
        // Verifica se existe a palavra App no namespace
        if (strpos($filename, 'App') !== false) {
            $expFilename = explode('/', strtolower($filename));
            $className = ucfirst(end($expFilename));
            
            array_pop($expFilename); // Remove o nome da classe
            array_push($expFilename, $className); // Adciona o nome da classe
            
            $filename = implode('/', $expFilename);
        }

        foreach (self::$pathToAutoload as $path) {
            if (file_exists($basedir . $path . $filename)) {
                require $basedir . $path . $filename;
            }
        }
    }
}