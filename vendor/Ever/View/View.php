<?php
/**
 * Ever Framework
 */

namespace Ever\View;

use Ever\View\Head,
    Ever\View\Layout;

/**
 * @category  Ever
 * @package   View
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
class View
{
    /** Usa as Traits Head, Url e Layout */
    use Head,
        Url,
        Layout;
    
    /**
     * Método construtor para setar o layout padrão
     */
    public function __construct() 
    {
        $this->setLayout();
    }
}
