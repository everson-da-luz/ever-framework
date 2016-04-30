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
    /** Usa a Trait Doctype */
    use Doctype;
    
    /**
     * Título da página
     * @var string 
     */
    private $title;
    
    /**
     * Array contendo as meta tags
     * @var Array 
     */
    private $metaTag = array();
    
    /**
     * Array contendo os estilos da página
     * @var Array 
     */
    private $styleSheet = array();
    
    /**
     * Array contendo os scripts da página
     * @var Array 
     */
    private $script = array();
    
    /**
     * Seta o título da página
     * 
     * @param string $title título da página
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Obtêm o título da página
     * 
     * @return string
     */
    public function getTitle()
    {
        return "<title>{$this->title}</title>\n";
    }
    
    /**
     * Adiciona uma meta tag no ínicio do array
     * onde são guardadas as meta tag para depois imprimi-las na tela
     * 
     * @param string $type    Tipo da meta tag
     * @param string $content Conteúdo da meta tag
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
                array_unshift($this->metaTag, array('http-equiv' => $type, 'content' => $content));
                break;
            case 'application-name':
            case 'author':
            case 'description':
            case 'generator':
            case 'keywords':
                array_unshift($this->metaTag, array('name' => $type, 'content' => $content));
                break;
        }
    }
    
    /**
     * Adiciona uma meta tag no final do array
     * onde são guardadas as meta tag para depois imprimi-las na tela
     * 
     * @param string $type    Tipo da meta tag
     * @param string $content Conteúdo da meta tag
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
                array_push($this->metaTag, array('http-equiv' => $type, 'content' => $content));
                break;
            case 'application-name':
            case 'author':
            case 'description':
            case 'generator':
            case 'keywords':
                array_push($this->metaTag, array('name' => $type, 'content' => $content));
                break;
        }
    }
    
    /**
     * Obtêm as meta tags setadas,
     * conforme ordem de precedencia pelos métodos prependMetaTag e appendMetaTag
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
                    $meta .= '<meta name="' . $value['name'] . '" content="' . $value['content'] . '"';
                }
                
                $meta .= $this->closeTagHead();
            }
        }

        return $meta;
    }
    
    /**
     * Adiciona folhas de estilos no ínicio do array
     * onde são armazenados todas as folhas de estilos setadas.
     * 
     * @param string $href       caminho da folha de estilo
     * @param array  $attributes atributos para a tag link
     */
    public function prependStyleSheet($href, array $attributes = null)
    {
        array_push($this->styleSheet, array('href' => $href, 'attributes' => $attributes));
    }
    
    /**
     * Adiciona folhas de estilos no final do array
     * onde são armazenados todas as folhas de estilos setadas.
     * 
     * @param string $href       caminho da folha de estilo
     * @param array  $attributes atributos para a tag link
     */
    public function appendStyleSheet($href, array $attributes = null)
    {
        array_unshift($this->styleSheet, array('href' => $href, 'attributes' => $attributes));
    }
    
    /**
     * Monta a tag link, se conter atributos os mesmos serão atribidos a tag.
     * Retorna as tags link com as folhas de estilo setadas para a página.
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
     * Adiciona scripts no ínicio do array
     * onde são armazenados todas os scripts setadas.
     * 
     * @param string $src        caminho do script
     * @param array  $attributes atributos para a tag script
     */
    public function prependScript($src, array $attributes = null)
    {
        array_push($this->script, array('src' => $src, 'attributes' => $attributes));
    }
    
    /**
     * Adiciona scripts no final do array
     * onde são armazenados todas os scripts setadas.
     * 
     * @param string $src        caminho do script
     * @param array  $attributes atributos para a tag script
     */
    public function appendScript($src, array $attributes = null)
    {
        array_unshift($this->script, array('src' => $src, 'attributes' => $attributes));
    }
    
    /**
     * Monta a tag script, se conter atributos os mesmos serão atribidos a tag.
     * Retorna as tags script com os scripts setadas para a página.
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
     * Fecha as tags do head de acordo com o Doctype setado.
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

