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
class Table
{
    /**
     * Instância da classe PDO
     * @var \PDO
     */
    protected $db;
    
    /**
     * Nome da tabela do banco de dados
     * no qual será feito toda a query.
     * @var String 
     */
    protected $table;
    
    /**
     * Armazena o SELECT da query
     * @var String 
     */
    private $select;
    
    /**
     * Armazena os campos da query
     * @var String 
     */
    private $fields = null;
    
    /**
     * Armazena os JOINs da query
     * @var String  
     */
    private $join;
    
    /**
     * Armazena o WHERE da query
     * @var String  
     */
    private $where;
    
    /**
     * Armazena o ORDER da query
     * @var String  
     */
    private $order;
    
    /**
     * Armazena o LIMIT da query
     * @var String  
     */
    private $limit;
    
    /**
     * Armazena o OFFSET da query
     * @var String  
     */
    private $offset;
    
    /**
     * Método construtor
     * Armaze a instância da classe PDO na propriedade db
     */
    public function __construct()
    {
        $this->db = Connection::getDb();
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Executa a consulta, 
     * trazendo os resultados da consulta pelo tipo definido.
     * 
     * @param String $fecth tipo de fetch que irá retornar
     * @return Object
     */
    public function fetchAll($fecth = 'fetch_both')
    {
        try {
            $query = $this->getQuery();

            switch ($fecth) {
                case 'fetch_assoc':
                    $fetcthType = \PDO::FETCH_ASSOC;
                    break;
                case 'fetch_num':
                    $fetcthType = \PDO::FETCH_NUM;
                    break;
                case 'fetch_obj':
                    $fetcthType = \PDO::FETCH_OBJ;
                    break;
                case 'fetch_both':
                    $fetcthType = \PDO::FETCH_BOTH;
                    break;
                default :
                    $fetcthType = \PDO::FETCH_BOTH;
            }

            return $this->db->query($query)->fetchAll($fetcthType);
        } catch (\PDOException $e) {
            \Ever\Exception\Exception::errorHandler($e);
            exit;
        }
    }
    
    /**
     * Monta o SELECT da query.
     * 
     * @param String/Array $fields Campos quer serão buscados
     * @return \Ever\Db\Table
     */
    public function select($fields = null)
    {
        if (empty($fields)) { 
            // Se campos for vazio
            $this->fields = '*';
        } else if (is_string($fields)){
            // Se campos for uma string
            $this->fields = $fields;
        } else {
             // Se campos for um array
            $fieldsFormated = '';

            foreach ($fields as $key => $value) {
                if (is_numeric($key)) { 
                    // Se o índice for numérico
                    $fieldsFormated .= $value . ', ';
                } else {
                    // Senão é associativo e receberá um apelido que será o seu valor
                    $fieldsFormated .= "{$key} AS {$value}, ";
                }
            }

            $field = substr($fieldsFormated, 0, -2);
            
            $this->fields = $field;
        }
        
        $query = "SELECT {fields} FROM {$this->table}";
        
        $this->select = $query;
        
        return $this;
    }
    
    /**
     * Monta os Joins da query
     * recebendo a tabela que irá unir,
     * a condição para unir, os campos que serão buscados
     * e por fim o tipo de join, que será inner, left ou right.
     * 
     * @param String $table Nome da tabela para unir
     * @param String $condition Condição para unir
     * @param String/Array $fields Campos que serão buscados
     * @param String $joinType Tipo de join
     * @return \Ever\Db\Table
     */
    public function join($table, $condition, $fields = null, $joinType = null)
    {
        if (!empty($fields)) {
            if (is_string($fields)){
                // Se campos for uma string
                $this->fields = $this->fields . ', ' . $fields;
            } else {
                 // Se campos for um array
                $fieldsFormated = '';

                foreach ($fields as $key => $value) {
                    if (is_numeric($key)) { 
                        // Se o índice for numérico
                        $fieldsFormated .= $value . ', ';
                    } else {
                        // Senão é associativo e receberá um apelido que será o seu valor
                        $fieldsFormated .= "{$key} AS {$value}, ";
                    }
                }

                $field = substr($fieldsFormated, 0, -2);

                $this->fields = $this->fields . ', ' . $field;
            }
        }

        switch ($joinType) {
            case 'left' :
                $query = ' LEFT JOIN ';
                break;
            case 'right' :
                $query = ' RIGHT JOIN ';
                break;
            default :
                $query = ' INNER JOIN ';
        }
        
        $query .= $table . ' ON ' . $condition;
        
        $this->join = $query;
        
        return $this;
    }
    
    /**
     * Monta o Where da query
     * 
     * @param String\Array $where Condição da query
     * @return \Ever\Db\Table
     */
    public function where($where)
    {
        $wr = '';
        
        if (is_array($where)) {
            foreach ($where as $key => $value) {
                $wr .= $key . " = '{$value}' AND ";
            }
            
            $wr = substr($wr, 0, -5);
        } else {
            $wr .= $where;
        }

        $this->where = ' WHERE ' . $wr;

        return $this;
    }
    
    /**
     * Monta o order da query
     * 
     * @param string $value Valor do order
     * @return \Ever\Db\Table
     */
    public function order($value)
    {
        $this->order =' ORDER BY ' . $value;
        
        return $this;
    }
    
    /**
     * Monta o Limit da query
     * 
     * @param Int $value Valor do limit
     * @return \Ever\Db\Table
     */
    public function limit($value)
    {
        $this->limit = ' LIMIT ' . $value;
        
        return $this;
    }
    
    /**
     * Monta o Offset da query
     * 
     * @param Int $value Valor do Offset
     * @return \Ever\Db\Table
     */
    public function offset($value)
    {
        $this->offset = ' OFFSET ' . $value;
        
        return $this;
    }
    
    /**
     * Insreri dados no banco de dados
     * 
     * @param Array $dados Dados para inserir
     * @return Object
     */
    public function insert(Array $dados)
    {
        try {
            foreach ($dados as $inds => $vals){
                $campos[]  = $inds;
                $valores[] = $vals;
            }

            $campos = implode(", ", $campos);
            $valores = "'".implode("','",$valores)."'";

            $query = $this->db->query("INSERT INTO `{$this->table}` ({$campos}) VALUES ({$valores})");

            return $query;
        } catch (\PDOException $e) {
            \Ever\Exception\Exception::errorHandler($e);
            exit;
        }
    }
    
    /**
     * Utualiza uma ou linhas do banco de dados.
     * 
     * @param Array  $dados Dados para atualizar
     * @param String $where Condição par atualizar
     * @return Object
     */
    public function update(Array $dados, $where = null)
    {
        try {
            foreach ($dados as $ind => $val){
                $campos[] = "{$ind} = '{$val}'";
            }

            $campos = implode(", ", $campos);

            $query = $this->db->query("UPDATE `{$this->table}` SET {$campos} WHERE {$where}");

            return $query;
        } catch (\PDOException $e) {
            \Ever\Exception\Exception::errorHandler($e);
            exit;
        }
    }
    
    /**
     * Deleta uma ou mais linhas do banco de dados
     * 
     * @param String $where Condição para deletar
     * @return Object
     */
    public function delete($where)
    {
        try {
            $query = $this->db->query("DELETE FROM {$this->table} WHERE {$where}");
        
            return $query;
        } catch (\PDOException $e) {
            \Ever\Exception\Exception::errorHandler($e);
            exit;
        }
    }
    
    /**
     * Monta e retorna a query final,
     * depois de ter sido setados toda a query, 
     * como o select, join, where, order, limit, offset.
     * 
     * @return String
     */
    public function getQuery()
    {
        $query = str_replace('{fields}', $this->fields, $this->select);
    
        $query .= !empty($this->join) ? $this->join : '';
        $query .= !empty($this->where) ? $this->where : '';
        $query .= !empty($this->order) ? $this->order : '';
        $query .= !empty($this->limit) ? $this->limit : '';
        $query .= !empty($this->offset) ? $this->offset : '';
        
        return $query;
    }
}