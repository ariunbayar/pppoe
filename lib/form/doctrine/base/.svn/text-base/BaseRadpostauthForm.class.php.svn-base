<?php

/**
 * Radpostauth form base class.
 *
 * @method Radpostauth getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRadpostauthForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'username' => new sfWidgetFormInputText(),
      'pass'     => new sfWidgetFormInputText(),
      'reply'    => new sfWidgetFormInputText(),
      'authdate' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'username' => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'pass'     => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'reply'    => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'authdate' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('radpostauth[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Radpostauth';
  }

}
