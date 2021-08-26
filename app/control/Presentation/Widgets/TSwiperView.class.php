<?php

use Adianti\Widget\Util\TSwiper;
use Adianti\Control\TPage;
use Adianti\Widget\Container\THBox;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Util\TXMLBreadCrumb;

/**
 * TSwiperView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Rodrigo Pires Meira
 */
class TSwiperView extends TPage
{
	public function __construct()
	{
		parent::__construct();

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

        $hbox = new THBox;
		
		$swiper1 = new TSwiper();
        $swiper1->setSlidesPerView(2, true);
        $swiper1->setSpaceBetween(15);
        $swiper1->enableFreeMode();
        $swiper1->enableScrollbar();
        $swiper1->{'style'} = 'height: 200px;margin:25px auto;';
        $swiper1->setItemTemplate($template);
        foreach($items as $key => $item)
        {
            $swiperitem = $swiper1->addItem($item);
            $swiperitem->{'style'} = 'border: solid 1px #ddd;border-radius: 4px';
        }
        $hbox->add($swiper1, 'width:100%;');
		
		$swiper2 = new TSwiper();
        $swiper2->setSlidesPerView(4, false);
        $swiper2->setSpaceBetween(15);
        $swiper2->enablePagination();
        $swiper2->{'style'} = 'height: 200px;margin:25px auto;';
        $swiper2->setItemTemplate($template);
        foreach($items as $key => $item)
        {
            $swiperitem = $swiper2->addItem($item);
            $swiperitem->{'style'} = 'border: solid 1px #ddd;border-radius: 4px';
        }
        $hbox->add($swiper2, 'width:100%;');
		
		$swiper3 = new TSwiper();
        $swiper3->enablePagination('fraction');
        $swiper3->centerSlides();
        $swiper3->setEffect('flip');
        $swiper3->{'style'} = 'height: 200px;width:100%;margin:25px auto;';
        $swiper3->setItemTemplate($template);
        foreach($items as $key => $item)
        {
            $swiperitem = $swiper3->addItem($item);
            $swiperitem->{'style'} = 'border: solid 1px #ddd;border-radius: 4px';
        }
        $hbox->add($swiper3, 'width:100%;');

        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 90%; margin: auto;';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));

        $vbox->add($hbox);

        parent::add($vbox);
	}
    
}
