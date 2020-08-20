<?php
/**
 * TInfoBoxView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Rodrigo Pires Meira
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TInfoBoxView extends TPage
{
	private $form;
	
	public function __construct()
	{
		parent::__construct();
		
		$container = new TElement('div');
		$container->class = 'row';
		
		$col1 = new TElement('div');
		$col1->class = 'col-sm-6';
		$info1 = new TInfoBox('fa:user','teste',"12323",'green');
		$col1->add($info1);
		
		$col2 = new TElement('div');
		$col2->class = 'col-sm-6';
		$info2 = new TInfoBox('fa:user','teste',"12323",'green');
		$col2->add($info2);
		
		$container->add($col1);
		$container->add($col2);
		
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($container);

        parent::add($vbox);
	}
    
}
