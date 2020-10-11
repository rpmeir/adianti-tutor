<?php
namespace Adianti\Widget\Form;

use Adianti\Widget\Form\AdiantiWidgetInterface;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Form\TField;

/**
 * Switch Widget
 *
 * @version    1.0
 * @package    widget
 * @subpackage form
 * @author     Rodrigo Pires Meira
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TSwitch extends TField implements AdiantiWidgetInterface
{
    protected $id;
    protected $label;
    private $indexValue;
    
    /**
     * Class Constructor
     * @param $name Name of the widget
     */
    public function __construct($name, $label = '')
    {
        parent::__construct($name);
        $this->id    = 'tswitch_'.mt_rand(1000000000, 1999999999);
        $this->label = $label;
        $this->tag->{'widget'} = 'tswitch';
    }
    
    /**
     * Define the index value for check button
     * @index Index value
     */
    public function setIndexValue($index)
    {        
        $this->indexValue = $index;
    }
    
    /**
     * Enable the field
     * @param $form_name Form name
     * @param $field Field name
    public static function enableField($form_name, $field)
    {
        TScript::create( " tswitch_enable_field('{$form_name}', '{$field}'); " );
    }
     */
    
    /**
     * Disable the field
     * @param $form_name Form name
     * @param $field Field name
    public static function disableField($form_name, $field)
    {
        TScript::create( " tswitch_disable_field('{$form_name}', '{$field}'); " );
    }
     */
    
    /**
     * Return the post data
     */
    public function getPostData()
    {
        if (isset($_POST[$this->name]))
        {
            return $_POST[$this->name];
        }
        else
        {
            return 'off';
        }
    }
    
    /**
     * Define the action to be executed when the user changes the combo
     * @param $action TAction object
     */
    public function setChangeAction(TAction $action)
    {
        if ($action->isStatic())
        {
            $this->changeAction = $action;
        }
        else
        {
            $string_action = $action->toString();
            throw new Exception(AdiantiCoreTranslator::translate('Action (^1) must be static to be used in ^2', $string_action, __METHOD__));
        }
    }
    
    /**
     * Set change function
     */
    public function setChangeFunction($function)
    {
        $this->changeFunction = $function;
    }
    
    /**
     * Shows the widget at the screen
     */
    public function show()
    {
    
        // define the tag properties
        $this->tag->{'name'}  = $this->name;    // TAG name
        $this->tag->{'type'}  = 'checkbox';         // input type
        $this->tag->{'value'} = $this->indexValue;   // value
        $this->tag->{'class'} = 'custom-control-input';
        
        if ($this->id and empty($this->tag->{'id'}))
        {
            $this->tag->{'id'} = $this->id;
        }
        
        // compare current value with indexValue
        if ($this->indexValue == $this->value AND !(is_null($this->value)) AND strlen((string) $this->value) > 0)
        {
            $this->tag->{'checked'} = '1';
        }
        
        // check whether the widget is non-editable
        if (!parent::getEditable())
        {
            // make the widget read-only
            //$this->tag-> disabled   = "1"; // the value don't post
            $this->tag->{'onclick'} = "return false;";
            $this->tag->{'style'}   = 'pointer-events:none';
            $this->tag->{'tabindex'} = '-1';
        }

        $div = new TElement('div');
        $div->{'class'} = 'custom-control custom-switch switch';
        
        $label1 = new TElement('label');

        $label = new TElement('label');
        $label->{'class'} = 'custom-control-label';
        $label->{'for'} = $this->id;
        $label->add($this->label);
        
        $span = new TElement('span');
        $span->{'class'} = 'lever';

        $label1->add('off');
        $label1->add($this->tag);
        $label1->add($span);
        $label1->add($this->label);

        $div->add($label1);
        
        $div->show();
        
    }
}
