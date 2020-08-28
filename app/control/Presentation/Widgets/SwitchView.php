<?php
/**
 * SwitchView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Rodrigo Pires Meira
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class SwitchView extends TPage
{
    private $form;
    
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle(_t('Bootstrap form'));
        $this->form->generateAria(); // automatic aria-label
        $this->form->setFieldSizes('100%');
        
        // creates the dropdown
        $switch1 = new TSwitch('switch_test1', 'Teste 01');
        $switch2 = new TSwitch('switch_test2', 'Teste 02');
        
        // add the fields inside the form
        $this->form->addFields( 
            [new TLabel(''), $switch1],
            [new TLabel('Switch 02'), $switch2]
        )->layout = ['col-6','col-6'];
        
        // define the form action 
        $this->form->addAction('Send', new TAction(array($this, 'onSend'), ['static' => '1']), 'far:check-circle green');
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        
        parent::add($vbox);
    }
    
    /**
     * Simulates an save button
     * Show the form content
     */
    public function onSend($param)
    {
        $data = $this->form->getData();
        
        // put the data back to the form
        $this->form->setData($data);
        
        // creates a string with the form element's values
        $message = 'Teste 01: ' . $data->switch_test1 . '<br>';
        $message.= 'Teste 02: ' . $data->switch_test2 . '<br>';
        
        // show the message
        new TMessage('info', $message);
    }
    
}