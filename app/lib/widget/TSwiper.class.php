<?php
namespace Adianti\Widget\Util;

use Adianti\Util\AdiantiTemplateHandler;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Base\TStyle;
use Adianti\Widget\Template\THtmlRenderer;
use ApplicationTranslator;

/**
 * TSwiper Widget
 *
 * @version    7.3
 * @package    widget
 * @subpackage util
 * @author     Rodrigo Pires Meira
 */
class TSwiper extends TElement
{

    private $templatePath;
    private $itemTemplate;
    private $itemHeight;
    private $contentHeight;
    private $pagination; // position bug on progressbar type, should stay on top
    private $arrows; // minimal position bug on prev button
    private $scrollbar;
    private $items;
    private $breakpoints;
    private $options;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct('div');
        $this->{'class'} = 'tswiper';
        $this->{'id'}    = 'tswiper_' . mt_rand(1000000000, 1999999999);
        $this->items = [];
        $this->pagination = FALSE;
        $this->arrows = FALSE;
        $this->scrollbar = FALSE;
        $this->breakpoints = [];
        $this->options = [];
    }
    
    /**
     * Set extra tswiper options (ex: effect, grabCursor, direction, spaceBetween...)
     */
    private function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * Get extra tswiper options (ex: effect, grabCursor, direction, spaceBetween...)
     */
    public function getOptions()
    {
        $options = json_encode($this->options);
        return $options;
    }
    
    /**
     * Add item
     * @param  $object Item data object
     */
    public function addItem($object)
    {
        $this->items[] = $object;
    }

    /**
     * Clear items
     */
    public function clear()
    {
        $this->items = [];
    }
    
    /**
     * Set swiper item template for rendering
     * @param  $template   Template content
     */
    public function setItemTemplate($template)
    {
        $this->itemTemplate = $template;
    }
    
    /**
     * Set item min height
     * @param $height min height
     */
    public function setItemHeight($height)
    {
        $this->itemHeight = $height;
    }
    
    /**
     * Set swiper item template for rendering
     * @param  $path   Template path
     */
    public function setTemplatePath($path)
    {
        $this->templatePath = $path;
    }
    
    /**
     * Set content min height
     * @param $height min height
     */
    public function setContentHeight($height)
    {
        $this->contentHeight = $height;
    }
    
    /**
     * Add breakpoint
     */
    public function addBreakPoint($pixelsWidth, $slidesPerView, $spaceBetween)
    {
        $this->breakpoints[$pixelsWidth] = [
            'slidesPerView' => $slidesPerView, 
            'spaceBetween' => $spaceBetween
        ];
    }
    
    /**
     * Set direction slides
     * @param $direction 
     */
    public function setDirection($direction)
    {
        $allowed = ['horizontal', 'vertical'];
        if(in_array($direction, $allowed))
        {
            $this->setOption('direction', $direction);
        }
    }

    /**
     * Set effect transition
     */
    public function setEffect($effect)
    {
        $allowed = ['slide', 'fade', 'cube', 'coverflow', 'flip'];
        if(in_array($effect, $allowed))
        {
            $this->setOption('effect', $effect);
        }
    }

    /**
     * Set free mode option
     * @param boolean Disable keep moving
     */
    public function enableFreeMode($disableMomentum = false)
    {
        $this->setOption('freeMode', true);
        if($disableMomentum)
        {
            $this->setOption('freeModeMomentum', false);
        }
    }
    
    /**
     * Enable arrows
     */
    public function enableArrows()
    {
        $this->arrows = TRUE;
        $this->setOption('navigation', [
            'nextEl' => '.swiper-button-next', 
            'prevEl' => '.swiper-button-prev'
        ]);
    }
    
    /**
     * Enable pagination
     * @param string Pagination type progressbar or fraction
     * @param boolean Clickable
     * @param boolean Enable dinamic bullets
     */
    public function enablePagination($type = 'bullets', $clickable = false, $dynamicBullets = false)
    {
        $this->pagination = TRUE;

        $opt = [];
        $allowedTypes = ['bullets', 'fraction', 'progressbar', 'custom'];

        $opt['el'] = '.swiper-pagination';

        $opt['type'] = in_array($type, $allowedTypes) ? $type : null;
        $opt['clickable'] = $clickable;
        $opt['dynamicBullets'] = $dynamicBullets;

        $this->setOption('pagination', $opt);
    }
    
    /**
     * Enable scrollbar
     * @param Boolean Hide
     */
    public function enableScrollbar($hide = true)
    {
        $this->scrollbar = TRUE;
        $this->setOption('scrollbar', [ 'el' => '.swiper-scrollbar', 'hide' => $hide ]);
    }
    
    /**
     * Set space between slides
     * @param  $space   Space
     */
    public function setSpaceBetween($space = 0)
    {
        if(is_numeric($space) && $space >= 0)
        {
            $this->setOption('spaceBetween', $space);
        }
    }
    
    /**
     * Set slides per view
     * @param  $number   Number of slides per view, or 'auto'
     * @param  $grouped   Boolean Aply same number per group
     */
    public function setSlidesPerView($number, $grouped = false)
    {
        if(is_numeric($number))
        {
            $this->setOption('slidesPerView', $number);
            if(is_bool($grouped) && $grouped)
            {
                $this->setOption('slidesPerGroup', $number);
            }
        }
    }
    
    /**
     * Set speed duration
     * @param  $miliseconds Duration of transition between slides
     */
    public function setSpeed($miliseconds)
    {
        if(is_numeric($miliseconds))
        {
            $this->setOption('speed', $miliseconds);
        }
    }
    
    /**
     * Set slides per column // with bug
     * @param  $number   Number of slides per column
     */
    public function setSlidesPerColumn($number)
    {
        if(is_numeric($number))
        {
            $this->setOption('slidesPerColumn', $number);
        }
    }

    /*
     * Set Centered slides
     * @param $bounds Boolean with the bounds option
     */
    public function centerSlides($bounds = false)
    {
        $this->setOption('centeredSlides', true);
        if(is_bool($bounds))
        {
            $this->setOption('centeredSlidesBounds', $bounds);
        }
    }

    /**
     * Render item
     */
    private function renderItem($item)
    {
        if (!empty($this->templatePath))
        {
            $html = new THtmlRenderer($this->templatePath);
            $html->enableSection('main');
            $html->enableTranslation();
            $html = AdiantiTemplateHandler::replace($html->getContents(), $item);
            
            return $html;
        }

        $item_wrapper = new TElement('div');
        $item_wrapper->{'class'} = 'swiper-slide';

        if (!empty($this->itemTemplate))
        {
            $item_content = new TElement('div');
            $item_template = ApplicationTranslator::translateTemplate($this->itemTemplate);
            $item_template = AdiantiTemplateHandler::replace($item_template, $item);
            $item_content->add($item_template);
        }
        
        if (!empty($item_content))
        {
            $item_wrapper->add($item_content);
            
            if (!empty($this->contentHeight))
            {
                $item_content->{'style'}   = 'min-height:'.$this->contentHeight;
                
                if (strstr($this->size, '%') !== FALSE)
                {
                    $item_content->{'style'}   = 'min-height:'.$this->contentHeight;
                }
                else
                {
                    $item_content->{'style'}   = 'min-height:'.$this->contentHeight.'px';
                }
            }
        }

        if (!empty($this->itemHeight))
        {
            $item_wrapper->{'style'}   = 'min-height:'.$this->itemHeight;
            
            if (strstr($this->size, '%') !== FALSE)
            {
                $item_wrapper->{'style'}   = 'min-height:'.$this->itemHeight;
            }
            else
            {
                $item_wrapper->{'style'}   = 'min-height:'.$this->itemHeight.'px';
            }
        }

        return $item_wrapper;

    }
    
    /**
     * Show the callendar and execute required scripts
     */
    public function show()
    {
        $id = $this->{'id'};

        $wrapper = new TElement('div');
        $wrapper->{'class'} = 'swiper-wrapper';

        parent::add($wrapper);

        if($this->items)
        {
            foreach ($this->items as $item)
            {
                $wrapper->add($this->renderItem($item));
            }
        }

        if($this->pagination)
        {
            $page = new TElement('div');
            $page->{'class'} = 'swiper-pagination';
            parent::add($page);
        }

        if($this->arrows)
        {
            $prev = new TElement('div');
            $prev->{'class'} = 'swiper-button-prev';
            parent::add($prev);
            $next = new TElement('div');
            $next->{'class'} = 'swiper-button-next';
            parent::add($next);
        }

        if($this->scrollbar)
        {
            $scrl = new TElement('div');
            $scrl->{'class'} = 'swiper-scrollbar';
            parent::add($scrl);
        }

        // create options
        if($this->breakpoints)
        {
            $this->options['breakpoints'] = $this->breakpoints;
        }

        $options = json_encode($this->options);

        TStyle::importFromFile('app/lib/include/tswiper/tswiper.css');

        TScript::create("$(function(){var swiper = new Swiper('.tswiper', $options);});");

        parent::show();
    }
}