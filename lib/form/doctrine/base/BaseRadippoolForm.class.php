<?php

/**
 * Radippool form base class.
 *
 * @method Radippool getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRadippoolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'pool_name'        => new sfWidgetFormInputText(),
      'framedipaddress'  => new sfWidgetFormInputText(),
      'nasipaddress'     => new sfWidgetFormInputText(),
      'calledstationid'  => new sfWidgetFormInputText(),
      'callingstationid' => new sfWidgetFormInputText(),
      'expiry_time'      => new sfWidgetFormDateTime(),
      'username'         => new sfWidgetFormInputText(),
      'pool_key'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'pool_name'        => new sfValidatorString(array('max_length' => 30)),
      'framedipaddress'  => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'nasipaddress'     => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'calledstationid'  => new sfValidatorString(array('max_length' => 30)),
      'callingstationid' => new sfValidatorString(array('max_length' => 30)),
      'expiry_time'      => new sfValidatorDateTime(array('required' => false)),
      'username'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'pool_key'         => new sfValidatorString(array('max_length' => 30)),
    ));

    $this->widgetSchema->setNameFormat('radippool[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Radippool';
  }

}
