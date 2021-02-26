<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TSwitch;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Wrapper\BootstrapFormBuilder;

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
        
        $uid = uniqid();

        $this->form->add(
            '<hr>
            <div class="row" >
                <div class="col-3" >
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" widget="tswitch" name="switch_test1" type="checkbox" id="tswitch_'.$uid.'">
                        <label class="custom-control-label" for="tswitch_'.$uid.'">
                            TESTE 01
                        </label>
                    </div>
                </div>
                <div class="col-3" >
                    <div class="switch">
                        <label>
                            <input type="checkbox" checked="">
                            <span class="lever"></span>
                            TESTE 02
                        </label>
                    </div>
                </div>
                <div class="col-3" >
                    <div class="custom-control custom-switch switch">
                        <label>
                            <input type="checkbox" checked="" class="custom-control-input" widget="tswitch" name="switch_test1" id="tswitch_'.$uid.'xxx">
                            <span class="custom-control-label" for="tswitch_'.$uid.'xxx"><span>
                            TESTE 03
                        </label>
                    </div>
                </div>
                <div class="col-3" >
                    <div class="custom-control custom-switch switch">
                        <span>
                            <input type="checkbox" checked="" class="custom-control-input" id="tswitch_'.$uid.'yyy">
                            <label class="lever custom-control-label" for="tswitch_'.$uid.'yyy" ></label>
                            TESTE 04
                        </span>
                    </div>
                </div>
            </div>
            <hr>'
        );
        
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