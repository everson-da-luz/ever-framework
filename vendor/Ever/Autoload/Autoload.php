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
     * Paths to be added in the autoloader
     * @var array 
     */
    private static $pathToAutoload = array('/', '/vendor/');
    
    /**
     * Add another path to the autoloader.
     * This new path must contain a slash at the beginning and end.
     * Also runs autoload if any class
     * Is not included in the application.
     * 
     * @param String $path Way to add the autoload
     */
    public static function autoloadRegister($path = null) 
    {
        if (!empty($path)) {
            array_push(self::$pathToAutoload, $path);
        }
        
        spl_autoload_register('self::loader');
    }
    
    /**
     * Performs automatic inclusion of classes.
     * The classes will be searched in the paths defined on the property
     * <b>pathToAutoload</b>.
     * 
     * @param String $class Class name for automatic loading
     */
    private static function loader($class)
    {
        $basedir = dirname(APP_PATH);
        $filename = str_replace('\\', '/', $class) . ".php";
        
        // Checks for the App word in the namespace
        if (strpos($filename, 'App') !== false) {
            $expFilename = explode('/', strtolower($filename));
            $className = ucfirst(end($expFilename));
            
            array_pop($expFilename); // Remove the name of class
            array_push($expFilename, $className); // Add the class name
            
            $filename = implode('/', $expFilename);
        }

        foreach (self::$pathToAutoload as $path) {
            if (file_exists($basedir . $path . $filename)) {
                require $basedir . $path . $filename;
            }
        }
    }
}