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
    /** Use the Traits Head, Url and Layout */
    use Head,
        Url,
        Layout;
    
    /**
     * Constructor method to set the default layout
     */
    public function __construct() 
    {
        $this->setLayout();
    }
}