<?php

/**
 * Radusergroup form base class.
 *
 * @method Radusergroup getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRadusergroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'username'  => new sfWidgetFormInputText(),
      'groupname' => new sfWidgetFormInputText(),
      'priority'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'username'  => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'groupname' => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'priority'  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('radusergroup[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Radusergroup';
  }

}
