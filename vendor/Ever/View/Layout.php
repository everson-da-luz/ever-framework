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
trait Layout
{
    /**
     * Nome do arquivo de layout
     * @var string 
     */
    private $layout;
    
    /**
     * Caminho do arquivo de layout
     * @var string 
     */
    private $layoutPath;
    
    /**
     * Seta o nome do arquivo de layout,
     * por padrão é layout.
     * 
     * @param string $layout nome do arquivo de layout
     */
    public function setLayout($layout = 'layout')
    {
        $this->layout = $layout . '.phtml';
        
        $this->setLayoutPath();
    }
    
    /**
     * Seta o caminho do arquivo de layout
     * 
     * @param string $layoutPath caminho do arquivo de layout
     */
    public function setLayoutPath($layoutPath = null)
    {
        if (!empty($layoutPath)) {
            $this->layoutPath = $layoutPath . $this->layout;
        } else {
            $this->layoutPath = APP_PATH . '/views/layouts/' . $this->layout;
        }
    }
    
    /**
     * Obtêm o nome do arquivo de layout
     * 
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
    
    /**
     * Obtêm o caminho do arquivo de layout
     * 
     * @return string
     */
    public function getLayoutPath()
    {
        return $this->layoutPath;
    }
}