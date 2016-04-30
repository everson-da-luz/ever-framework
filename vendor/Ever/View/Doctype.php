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
trait Doctype
{
    /**
     * Doctype setado para a aplicação
     * @var String 
     */
    protected $doctype;
    
    /**
     * Método Construtor
     * Seta o doctype da aplicação
     */
    public function __construct()
    {
        $this->setDoctype();
    }
    
    /**
     * Seta o doctype para a aplicação,
     * o valor padrão é html5
     * 
     * @param  string $doctype doctype da aplicação
     * @return string
     */
    public function setDoctype($doctype = 'html5')
    {
        $this->doctype = $doctype;
        
        switch ($doctype) {
            case 'html5':
                $doc = "<!DOCTYPE html>\n";
                break;
            case 'html4_strict':
                $doc = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . "\n";
                break;
            case 'html4_transitional':
                $doc = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' . "\n";
                break;
            case 'html4_frameset':
                $doc = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">' . "\n";
                break;
            case 'xhtml1_strict':
                $doc = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n";
                break;
            case 'xhtml1_transitional':
                $doc = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
                break;
            case 'xhtml1_frameset':
                $doc = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">' . "\n";
                break;
            case 'xhtml1.1':
                $doc = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' . "\n";
                break;
            case 'xhtml1.1_basic':
                $doc = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">' . "\n";
                break;
            default :
                $doc = "<!DOCTYPE html>\n";
        }
        
        return $doc;
    }
}
