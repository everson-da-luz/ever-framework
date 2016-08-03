<?php
/**
 * Ever Framework
 */

namespace Ever\Db;

/**
 * @category  Ever
 * @package   Db
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
class Connection
{
    /**
     * Instance of PDO class
     * @var \PDO 
     */
    private static $instance = null;

    private function __construct() {}

    private function __clone() {}
    
    /**
     * Connection to the database, searching for the information defined in the 
     * connection file database.php
     * 
     * If there is no instance of PDO, it will create a new object of the 
     * PDO class.
     * 
     * @return \PDO
     */
    public static function getInstance() 
    {
        if (!isset(self::$instance)) {
            $dbConfig = require_once APP_PATH . '/config/database.php';
            
            if (!empty($dbConfig)) {
                try {
                    $config  = (!empty($dbConfig['db_driver']) ? 
                        $dbConfig['db_driver'] : 'mysql') . ':';
                    $config .= "host={$dbConfig['db_host']}";
                    $config .= ";dbname={$dbConfig['db_name']}";
                    $config .= ";charset=" . (!empty($dbConfig['db_charset']) ? 
                        $dbConfig['db_charset'] : 'utf8');

                    self::$instance = new \PDO($config, $dbConfig['db_user'], 
                        $dbConfig['db_pass']);
                } catch (\PDOException $e) {
                    \Ever\Exception\Exception::errorHandler($e);
                    exit;
                }
            }
        }
        
        return self::$instance;
    }
}