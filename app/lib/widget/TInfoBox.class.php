<?php

use Adianti\Widget\Base\TElement;
use Adianti\Widget\Util\TImage;
use Adianti\Control\TAction; // Redirect to another class with more info?

/**
 * TInfoBox
 *
 * @version    7.0
 * @package    widget
 * @subpackage util
 * @author     Rodrigo Pires Meira
 */
class TInfoBox extends TElement
{
    private $icon;
    private $title;
    private $value;
    private $background;

    /**
     * Class Constructor
     * @param $icon text Icon name
     * @param $title text Title text
     * @param $value text Value text
     * @param $background text Background color class
     */
    public function __construct($icon = null, $title = null, $value = null, $background = null)
    {
        parent::__construct('div');
        $this->id = 'tinfobox_' . uniqid();
        $this->{'class'} = 'info-box';
        
        $this->setIcon($icon);
        $this->setTitle($title);
        $this->setValue($value);
        $this->setBackground($background);
    }

    /**
     * Define the box icon
     * @param  $icon Icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * Define the content title
     * @param  $title Title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Define the content value
     * @param  $value Value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Define the icon background color
     * @param  $background Background color class
     */
    public function setBackground($background)
    {
        $this->background = $background;
    }
    
    /**
     * Render infobox icon
     */
    public function renderBoxIcon()
    {
        $icon = new TImage($this->icon);
        $icon->{'aria-hidden'} = 'true';
        
        $span = new TElement('span');
        $span->{'class'} = 'info-box-icon';
        if(isset($this->background))
        {
           $span->{'class'} .= ' bg-'.$this->background;
        }
        $span->add($icon);
        
        return $span;
    }
    
    /**
     * Render infobox content
     */
    public function renderBoxContent()
    {
        $content = new TElement('div');
        $content->{'class'} = 'info-box-content';
        
        if(isset($this->title))
        {
            $title = new TElement('span');
            $title->{'class'} = 'info-box-text';
            $title->add($this->title);
            $content->add($title);
        }

        if(isset($this->value))
        {
            $value = new TELement('span');
            $value->{'class'} = 'info-box-number';
            $value->add($this->value);
            $content->add($value);
        }
        
        return $content;
    }
    
    /**
     * Show
     */
	public function show()
    {
        parent::add( $this->renderBoxIcon() );
        parent::add( $this->renderBoxContent() );
                
    	parent::show();
    }
    
}
