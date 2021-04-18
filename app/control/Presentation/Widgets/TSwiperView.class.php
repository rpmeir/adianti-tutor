<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Util\TSwiper;
use Adianti\Widget\Util\TXMLBreadCrumb;

/**
 * TSwiperView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Rodrigo Pires Meira
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TSwiperView extends TPage
{
	public function __construct()
	{
		parent::__construct();
		
		$swiper = new TSwiper();
        $swiper->setSlidesPerView(2, true);
        $swiper->setSpaceBetween(15);
        $swiper->enableFreeMode();
        $swiper->enablePagination();
        //$swiper->centerSlides();
        //$swiper->setEffect('flip');
        //$swiper->setDirection('vertical');
        $swiper->{'style'} = 'height: 200px';

        $items = [];
        $items[] = (object) ['content' => 'Slide 1 <br> A'];
        $items[] = (object) ['content' => 'Slide 2 <br> B'];
        $items[] = (object) ['content' => 'Slide 3 <br> C'];
        $items[] = (object) ['content' => 'Slide 4 <br> D'];
        $items[] = (object) ['content' => 'Slide 5 <br> E'];
        $items[] = (object) ['content' => 'Slide 6 <br> F'];
        $items[] = (object) ['content' => 'Slide 7 <br> G'];
        $items[] = (object) ['content' => 'Slide 8 <br> H'];
        $items[] = (object) ['content' => 'Slide 9 <br> I'];
        $items[] = (object) ['content' => 'Slide 10 <br> J'];

        $template = '<b>teste</b><br>{content}';

        $swiper->setItemTemplate($template);

        foreach($items as $key => $item)
        {
            $swiperitem = $swiper->addItem($item);
            $swiperitem->{'style'} = 'border: solid 1px #ddd;border-radius: 4px';
        }

        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($swiper);

        parent::add($vbox);
	}
    
}
