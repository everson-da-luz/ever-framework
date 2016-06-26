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
     * Layout file name
     * @var string 
     */
    private $layout;
    
    /**
     * Path layout file
     * @var string 
     */
    private $layoutPath;
    
    /**
     * Sets the name of the layout file by default is layout.
     * 
     * @param string $layout name of the layout file
     */
    public function setLayout($layout = 'layout')
    {
        $this->layout = $layout . '.phtml';
        
        $this->setLayoutPath();
    }
    
    /**
     * Sets the path of the layout file
     * 
     * @param string $layoutPath path layout file
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
     * Get the name of the layout file
     * 
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
    
    /**
     * Get the path of the layout file
     * 
     * @return string
     */
    public function getLayoutPath()
    {
        return $this->layoutPath;
    }
}