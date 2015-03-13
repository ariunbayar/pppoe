<?php

/**
 * Radgroupcheck form base class.
 *
 * @method Radgroupcheck getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRadgroupcheckForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'groupname' => new sfWidgetFormInputText(),
      'attr'      => new sfWidgetFormInputText(),
      'op'        => new sfWidgetFormInputText(),
      'value'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'groupname' => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'attr'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'op'        => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'value'     => new sfValidatorString(array('max_length' => 253, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('radgroupcheck[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Radgroupcheck';
  }

}
