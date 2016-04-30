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
     * Array com os paramêtros da url ou setados nas rotas
     * @var array 
     */
    private static $params = array();
    
    /**
     * Obtem a url atual após o domínio
     * Caso a aplicação esta em um sub diretório, 
     * irá ser removido o nome do sub diretório
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
     * Seta os paramêtros referente a url atual
     * ou os paramêtros setados nas rotas.
     * 
     * @param String\Array $Param Url atual ou array contendo os parâmetros
     */
    public static function setParams($param = null)
    {        
        if (is_array($param)) {
            self::$params = $param; 
        } else {
            $params = explode('/', $param);
            unset($params[0], $params[1]);

            if(array_filter($params)) {
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

            if(count($ind) == count($value) && !empty($ind) && !empty($value)) {
                self::$params = array_combine($ind, $value);                
            } else {
                self::$params = array();
            }
        }
    }
    
    /**
     * Retorna o valor de um determinado paramêtro.
     * Caso não seja informado o nome do paramêtro,
     * irá retornar um array contendo todos os paramêtros da url
     * 
     * @param String $name nome do paramêtro a ser buscado
     * @return String/Array
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
     * Retorna o baseUrl padrão da aplicação
     * 
     * @return String
     */
    public function getBaseUrl()
    {
	$pathInfo = pathinfo($_SERVER['PHP_SELF']); 
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
        $baseUrl = $protocol . $_SERVER['HTTP_HOST'] . str_replace(PUBLIC_FOLDER . '/', '', $pathInfo['dirname']);
        
	return $baseUrl;
    }
}