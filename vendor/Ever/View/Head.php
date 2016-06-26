<?php
/**
 * Ever Framework
 */

namespace Ever\View;

use Ever\View\Doctype;

/**
 * @category  Ever
 * @package   View
 * @copyright 
 * @license   
 * @author    Everson da Luz <everson@eversondaluz.com.br>
 * @version   1.0
 */
trait Head
{
    /** Uses Trait Doctype */
    use Doctype;
    
    /**
     * Page title
     * @var string 
     */
    private $title;
    
    /**
     * Array containing the meta tags
     * @var Array 
     */
    private $metaTag = array();
    
    /**
     * Array containing the page styles
     * @var Array 
     */
    private $styleSheet = array();
    
    /**
     * Array containing the page scripts
     * @var Array 
     */
    private $script = array();
    
    /**
     * Sets the page title
     * 
     * @param string $title page title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Get the page title
     * 
     * @return string
     */
    public function getTitle()
    {
        return "<title>{$this->title}</title>\n";
    }
    
    /**
     * Add a meta tag at the beginning of the array where the meta tag are saved 
     * and then print them on the screen
     * 
     * @param string $type    Type meta tag
     * @param string $content Content meta tag
     */
    public function prependMetaTag($type, $content = null)
    {
        switch ($type) {
            case 'charset':
                array_unshift($this->metaTag, array('charset' => $content));
                break;
            case 'content-type':
            case 'default-style':
            case 'refresh':
                array_unshift($this->metaTag, array(
                    'http-equiv' => $type, 'content' => $content
                ));
                break;
            case 'application-name':
            case 'author':
            case 'description':
            case 'generator':
            case 'keywords':
                array_unshift($this->metaTag, array(
                    'name' => $type, 'content' => $content
                ));
                break;
        }
    }
    
    /**
     * Add a meta tag at the end of the array where the meta tag are saved and 
     * then print them on the screen
     * 
     * @param string $type    Type meta tag
     * @param string $content Content meta tag
     */
    public function appendMetaTag($type, $content = null)
    {
        switch ($type) {
            case 'charset':
                array_push($this->metaTag, array('charset' => $content));
                break;
            case 'content-type':
            case 'default-style':
            case 'refresh':
                array_push($this->metaTag, array(
                    'http-equiv' => $type, 'content' => $content
                ));
                break;
            case 'application-name':
            case 'author':
            case 'description':
            case 'generator':
            case 'keywords':
                array_push($this->metaTag, array(
                    'name' => $type, 'content' => $content
                ));
                break;
        }
    }
    
    /**
     * Get the meta tags defined as the order of precedence by prependMetaTag 
     * methods and appendMetaTag
     * 
     * @return string
     */
    public function getMetaTag()
    {
        if (!empty($this->metaTag)) {
            $meta = '';
            
            foreach($this->metaTag as $value) {
                if (key($value) == 'charset') {
                    $meta .= '<meta charset="' . $value['charset'] . '"';
                } else {
                    $meta .= '<meta name="' . $value['name'] . 
                        '" content="' . $value['content'] . '"';
                }
                
                $meta .= $this->closeTagHead();
            }
        }

        return $meta;
    }
    
    /**
     * Add style sheets at the beginning of the array which are stored all the 
     * leaves of unset styles.
     * 
     * @param string $href       path of the stylesheet
     * @param array  $attributes attributes for the link tag
     */
    public function prependStyleSheet($href, array $attributes = null)
    {
        array_push($this->styleSheet, array(
            'href' => $href, 'attributes' => $attributes
        ));
    }
    
    /**
     * Add style sheets at the end of the array which are stored all the leaves
     * of unset styles.
     * 
     * @param string $href       path of the stylesheet
     * @param array  $attributes attributes for the link tag
     */
    public function appendStyleSheet($href, array $attributes = null)
    {
        array_unshift($this->styleSheet, array(
            'href' => $href, 'attributes' => $attributes
        ));
    }
    
    /**
     * Mounts the tag link, if attributes contain the same will be atribidos 
     * the tag. Returns the tag link with the unset style sheets page.
     * 
     * @return string
     */
    public function getStyleSheet()
    {
        if (!empty($this->styleSheet)) {
            $style = '';
            
            foreach($this->styleSheet as $value) {
                $style .= '<link href="' . $value['href'] . '"';
                
                if (!empty($value['attributes'])) {
                    foreach($value['attributes'] as $atrKey => $atrValue) {
                        $style .= ' ' . $atrKey . '="' . $atrValue . '"';
                    }
                }
            }

            $style .= $this->closeTagHead();
        }

        return $style;
    }
    
    /**
     * Add scripts at the beginning of the array which are stored all the 
     * unset scripts.
     * 
     * @param string $src        script path
     * @param array  $attributes attributes for the script tag
     */
    public function prependScript($src, array $attributes = null)
    {
        array_push($this->script, array(
            'src' => $src, 'attributes' => $attributes
        ));
    }
    
    /**
     * Add scripts at the end of the array which are stored all the 
     * unset scripts.
     * 
     * @param string $src        script path
     * @param array  $attributes attributes for the script tag
     */
    public function appendScript($src, array $attributes = null)
    {
        array_unshift($this->script, array(
            'src' => $src, 'attributes' => $attributes
        ));
    }
    
    /**
     * Mounts the script tag, if contain the same attributes will atribidos the 
     * tag. Returns the script tags with the unset scripts page.
     * 
     * @return string
     */
    public function getScript()
    {
        if (!empty($this->script)) {
            $script = '';
            
            foreach($this->script as $value) {
                $script .= '<script src="' . $value['src'] . '"';
                
                if (!empty($value['attributes'])) {
                    foreach($value['attributes'] as $atrKey => $atrValue) {
                        $script .= ' ' . $atrKey . '="' . $atrValue . '"';
                    }
                }
            }

            $script .= "></script>\n";
        }

        return $script;
    }
    
    /**
     * Close head of the tags according to the setted Doctype.
     * 
     * @return string
     */
    public function closeTagHead()
    {
        if (strpos($this->doctype, 'xhtml') !== false) {
            $close = " />\n";
        } else {
            $close = ">\n";
        }
        
        return $close;
    }
}