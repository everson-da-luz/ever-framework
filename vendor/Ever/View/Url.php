<?php
/**
 * Ever Framework
 */

namespace Ever\View;

/**
 * @category  Ever
 * @package   View
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
Trait Url 
{
    /**
     * Array with the parameters defined in the routes or url
     * @var array 
     */
    private static $params = array();
    
    /**
     * Get the current url after the domain, if the application is in a sub 
     * directory will be removed from the sub directory name
     * 
     * @return string Url atual
     */
    public static function getCurrentUrl()
    {         
        $parse = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (strpos($parse, '/' . BASE_DIR . '/') !== false) {
            $url = str_replace('/' . BASE_DIR . '/', '', $parse);
        } else {
            $url = $parse;
        }
        
        return $url;
    }
    
    /**
     * Set the parameters related to the current url or setados 
     * parameters in routes.
     * 
     * @param String|Array $param Current url or array containing the parameters
     */
    public static function setParams($param = null)
    {        
        if (is_array($param)) {
            self::$params = $param; 
        } else {
            $params = explode('/', $param);
            unset($params[0], $params[1]);

            if (array_filter($params)) {
                if (count($params) % 2) {
                    array_push($params, '');
                }

                $i = 0;

                foreach ($params as $val) {
                    if( $i % 2 == 0 ) {
                        $ind[] = $val;
                    } else {
                        $value[] = $val;
                    }

                    $i ++;
                }
            } else {
                $ind = array();
                $value = array();
            }

            if (count($ind) == count($value) && !empty($ind) && !empty($value)) {
                self::$params = array_combine($ind, $value);                
            } else {
                self::$params = array();
            }
        }
    }
    
    /**
     * Returns the value of a given parameter. If not informed the parameter to 
     * name, will return an array containing all the parameters of the url
     * 
     * @param String $name Parameter name to be searched
     * @return String|Array
     */
    public function getParam($name = null)
    {
        if (empty($name)) {
            $param = self::$params;
        } else if (!empty($name) && !array_key_exists($name, self::$params)) {
            $param = '';
        } else {
            $param = self::$params[$name];
        }
        
        return $param;
    }
    
    /**
     * Returns the application default baseUrl
     * 
     * @return String
     */
    public function getBaseUrl()
    {
        $pathInfo = pathinfo($_SERVER['PHP_SELF']); 
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 
            'https://' ? 'https://' : 'http://';
        $baseUrl = $protocol . $_SERVER['HTTP_HOST'] . 
            str_replace(PUBLIC_FOLDER . '/', '', $pathInfo['dirname']);
        
        return $baseUrl;
    }
}