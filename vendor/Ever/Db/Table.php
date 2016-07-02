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
     * Instance of the PDO class
     * @var \PDO
     */
    protected $db;
    
    /**
     * database table name in which will be the whole query.
     * @var String 
     */
    protected $table;
    
    /**
     * Stores the SELECT of the query
     * @var String 
     */
    private $select;
    
    /**
     * Stores the fields of the query
     * @var String 
     */
    private $fields = null;
    
    /**
     * Stores the JOINs of query
     * @var String  
     */
    private $join;
    
    /**
     * Stores the WHERE of query
     * @var String  
     */
    private $where;
    
    /**
     * Stores the ORDER of query
     * @var String  
     */
    private $order;
    
    /**
     * Stores the LIMIT of query
     * @var String  
     */
    private $limit;
    
    /**
     * Stores the OFFSET of query
     * @var String  
     */
    private $offset;
    
    /**
     * Construct method
     * Stores the instance of the PDO class db property
     */
    public function __construct()
    {
        $this->db = Connection::getDb();
        
        if (!empty($this->db)) {
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }
    
    /**
     * Executes the query, bringing the query results-defined type.
     * 
     * @param String $fecth type of fetch that will return
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
     * Mount the SELECT of the query
     * 
     * @param String|Array $fields Fields that will be searched
     * @return \Ever\Db\Table
     */
    public function select($fields = null)
    {
        if (empty($fields)) { 
            // if field is empty
            $this->fields = '*';
        } else if (is_string($fields)){
            // If fields are a string
            $this->fields = $fields;
        } else {
             // If fields are an array
            $fieldsFormated = '';

            foreach ($fields as $key => $value) {
                if (is_numeric($key)) { 
                    // If the index is numeric
                    $fieldsFormated .= $value . ', ';
                } else {
                    // If you are not associative and receive a nickname 
                    // that will be worth your
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
     * Assembles the query of getting Joins the table that will unite the 
     * condition to unite, the fields that will be searched and finally the type 
     * of join, which will be inner, left or right.
     * 
     * @param String $table Table name to join
     * @param String $condition Condition to unite
     * @param String/Array $fields Fields that will be searched
     * @param String $joinType Join type
     * @return \Ever\Db\Table
     */
    public function join($table, $condition, $fields = null, $joinType = null)
    {
        if (!empty($fields)) {
            if (is_string($fields)){
                // If fields are a string
                $this->fields = $this->fields . ', ' . $fields;
            } else {
                 // If fields are an array
                $fieldsFormated = '';

                foreach ($fields as $key => $value) {
                    if (is_numeric($key)) { 
                        // If the index is numeric
                        $fieldsFormated .= $value . ', ';
                    } else {
                        // If you are not associative and receive a nickname 
                        // that will be worth your
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
     * Mount of Where the query
     * 
     * @param String|Array $where Query condition
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
     * Mount the order of query
     * 
     * @param string $value Value of order
     * @return \Ever\Db\Table
     */
    public function order($value)
    {
        $this->order =' ORDER BY ' . $value;
        
        return $this;
    }
    
    /**
     * Mount the Limit of query
     * 
     * @param Int $value Value of limit
     * @return \Ever\Db\Table
     */
    public function limit($value)
    {
        $this->limit = ' LIMIT ' . $value;
        
        return $this;
    }
    
    /**
     * Mount the Offset of query
     * 
     * @param Int $value Value of Offset
     * @return \Ever\Db\Table
     */
    public function offset($value)
    {
        $this->offset = ' OFFSET ' . $value;
        
        return $this;
    }
    
    /**
     * Insert data in the database
     * 
     * @param Array $dados Data to insert
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
     * Update to one or more lines of databases
     * 
     * @param Array  $dados Data to update
     * @param String $where Condition to update
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
     * Delete one or more lines of databases
     * 
     * @param String $where Condition to delete
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
     *Monta and return the final query, after being setados entire query, such 
     * as select, join, where, order, limit, offset.
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