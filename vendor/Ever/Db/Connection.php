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
     * Conexão com o banco de dados,
     * buscando as informações setadas no arquivo de conexão database.php
     * 
     * @return \PDO
     */
    public static function getDb()
    {
        try {
            $dbConfig = require_once APP_PATH . '/config/database.php';
            
            if (!empty($dbConfig)) {
                $config  = (!empty($dbConfig['db_driver']) ? $dbConfig['db_driver'] : 'mysql') . ':';
                $config .= "host={$dbConfig['db_host']}";
                $config .= ";dbname={$dbConfig['db_name']}";
                $config .= ";charset=" . (!empty($dbConfig['db_charset']) ? $dbConfig['db_charset'] : 'utf8');

                $db = new \PDO($config, $dbConfig['db_user'], $dbConfig['db_pass']);

                return $db;
            }
        } catch (\PDOException $e) {
            \Ever\Exception\Exception::errorHandler($e);
            exit;
        }
    }
}
