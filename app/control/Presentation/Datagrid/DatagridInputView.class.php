<?php

use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TEntry;

/**
 * DatagridInputView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class DatagridInputView extends TPage
{
    private $form;
    private $datagrid;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new TForm;
        
        // creates one datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width:100%';
        // $this->datagrid->enablePopover('Hint', 'Type address for <b>{name}</b>');
        $this->datagrid->disableDefaultClick();
        
        $panel = new TPanelGroup(_t('Datagrid with input fields'));
        $panel->add($this->datagrid)->style = 'overflow-x:auto';
        $this->form->add($panel);
        
        // add the columns
        $this->datagrid->addColumn( new TDataGridColumn('name',    'Name',    'left',   '30%') );
        $this->datagrid->addColumn( new TDataGridColumn('active',  'Active',  'left',   '20%') );
        $this->datagrid->addColumn( new TDataGridColumn('address', 'Address', 'left',   '30%') );
        $this->datagrid->addColumn( new TDataGridColumn('phone',   'Phone',   'center', '20%') );
        
        // creates the datagrid model
        $this->datagrid->createModel();
        
        // creates the action button
        $button = TButton::create('action1', [$this, 'onSave'], 'Save', 'fa:save green');
        $this->form->addField($button);
        $panel->addFooter($button);
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
    
    /**
     * Load the data into the datagrid
     */
    function onReload()
    {
        $this->datagrid->clear();
        
        // add an regular object to the datagrid
        $item = new StdClass;
        $item->name     = 'Aretha Franklin';
        $item->active   = new TCombo('active1');
        $item->active->setSize('100%');
        $item->address  = new TEntry('address1');
        $item->phone    = '1111-1111';
        $item->active->addItems(['Sim' => 'Sim', 'Não' => 'Não']);
        $item->address->setValue('Memphis, Tennessee');
        $item->address->setSize('100%');
        $this->datagrid->addItem($item);
        $this->form->addField($item->address); // important!
        $this->form->addField($item->active); // important!
        
        // add an regular object to the datagrid
        $item = new StdClass;
        $item->name     = 'Eric Clapton';
        $item->active   = new TCombo('active2');
        $item->active->setSize('100%');
        $item->address  = new TEntry('address2');
        $item->phone    = '2222-2222';
        $item->active->addItems(['Sim' => 'Sim', 'Não' => 'Não']);
        $item->address->setValue('Ripley, Surrey');
        $item->address->setSize('100%');
        $this->datagrid->addItem($item);
        $this->form->addField($item->address); // important!
        $this->form->addField($item->active); // important!
        
        // add an regular object to the datagrid
        $item = new StdClass;
        $item->name     = 'B.B. King';
        $item->active   = new TCombo('active3');
        $item->active->setSize('100%');
        $item->address  = new TEntry('address3');
        $item->phone    = '3333-3333';
        $item->active->addItems(['Sim' => 'Sim', 'Não' => 'Não']);
        $item->address->setValue('Itta Bena, Mississippi');
        $item->address->setSize('100%');
        $this->datagrid->addItem($item);
        $this->form->addField($item->address); // important!
        $this->form->addField($item->active); // important!
        
        // add an regular object to the datagrid
        $item = new StdClass;
        $item->name     = 'Janis Joplin';
        $item->active   = new TCombo('active4');
        $item->active->setSize('100%');
        $item->address  = new TEntry('address4');
        $item->phone    = '4444-4444';
        $item->active->addItems(['Sim' => 'Sim', 'Não' => 'Não']);
        $item->address->setValue('Port Arthur, Texas');
        $item->address->setSize('100%');
        $this->datagrid->addItem($item);
        $this->form->addField($item->address); // important!
        $this->form->addField($item->active); // important!
    }
    
    /**
     * Simulates an save button
     * Show the form content
     */
    public function onSave($param)
    {
        $data = $this->form->getData(); // optional parameter: active record class
        
        // put the data back to the form
        $this->form->setData($data);
        
        $message = '';
        foreach ($this->form->getFields() as $name => $field)
        {
            if ($field instanceof TEntry || $field instanceof TCombo)
            {
                $message .= " $name: " . $field->getValue() . '<br>';
            }
        }
        
        // show the message
        new TMessage('info', $message);
    }
    
    /**
     * shows the page
     */
    function show()
    {
        $this->onReload();
        parent::show();
    }
}
