<?php
/**
 * Ever Framework
 */

namespace Ever\Paginator;

/**
 * @category  Ever
 * @package   Paginator
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
class Paginator
{
    /**
     * Total of data
     * @var int 
     */
    private $totalData;
    
    /**
     * Limit of data per page
     * @var int 
     */
    private $limit = 10;
    
    /**
     * Offest of data
     * @var int 
     */
    private $offset = 0;
    
    /**
     * Current page
     * @var int 
     */
    private $currentPage = 1;
    
    /**
     * Total of pages
     * @var int 
     */
    private $totalPages;
    
    /**
     * Path of paginator file
     * @var String 
     */
    private $pathPaginator;
    
    /**
     * Name of file paginator
     * @var string 
     */
    private $filePaginator = 'paginator';
    
    /**
     * Vars passed to paginator in view
     * @var string|array 
     */
    private $var;
    
    public function __construct($totalData) 
    {
        $this->totalData = $totalData;
        
        $this->setPathPaginator();
    }
    
    /**
     * Set the path of paginator file
     * 
     * @param string $path Path of paginator file
     */
    public function setPathPaginator($path = null)
    {
        if (!empty($path)) {
            $this->pathPaginator = $path;
        } else {
            $this->pathPaginator = APP_PATH . '/views/paginator/';
        }
    }
    
    /**
     * Name of paginator file 
     * 
     * @param string $filePaginator Name of paginator file
     */
    public function setFilePaginator($filePaginator)
    {
        $this->filePaginator = $filePaginator;
    }
    
    /**
     * Set the current page
     * 
     * @param string $currentPage Current page
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }
    
    /**
     * Set the limit data per page in paginator
     * 
     * @param int $limit limit per page
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        
        $this->setTotalPages();
    }
    
    /**
     * Set the offset of data
     */
    private function setOffset()
    {
        $this->offset = ($this->limit * $this->currentPage) - $this->limit;
    }
    
    /**
     * Set the total of pages to paginator
     */
    private function setTotalPages()
    {
        $this->totalPages = ceil($this->totalData / $this->limit);
    }
    
    /**
     * Get the offset
     * 
     * @return int
     */
    public function getOffset()
    {
        $this->setOffset();
        
        return $this->offset;
    }
    
    /**
     * Get the current page
     * 
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
    
    /**
     * Get the total of pages
     * 
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }
    
    /**
     * Set the vars to use in paginator file
     * 
     * @param string|array $var vars to paginator file
     */
    private function setVar($var)
    {
        $this->var = $var;
    }
    
    /**
     * It gets the variable defining the key name if the name is empty will 
     * be returned all vars
     * 
     * @param string $key name of key array
     * @return string
     */
    public function getVar($key = null)
    {
        if (!empty($key) && is_array($this->var)) {
            $var = $this->var[$key];
        } else {
            $var = $this->var;
        }
        
        return $var;
    }
    
    /**
     * Get the html defined in paginator file 
     * 
     * @param string|array $var vars to use in paginator file
     * @throws \Ever\Exception\Exception
     */
    public function getPaginator($var = null) 
    {
        if ($this->totalPages > 1) {
            if (!empty($var)) {
                $this->setVar($var);
            }

            if (file_exists($this->pathPaginator . $this->filePaginator . '.phtml')) {              
                require_once $this->pathPaginator . $this->filePaginator . '.phtml';
            }
        }
    }
}