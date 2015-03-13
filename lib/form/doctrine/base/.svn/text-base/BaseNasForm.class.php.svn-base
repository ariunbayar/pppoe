<?php

/**
 * Nas form base class.
 *
 * @method Nas getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNasForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nasname'     => new sfWidgetFormInputText(),
      'shortname'   => new sfWidgetFormInputText(),
      'type'        => new sfWidgetFormInputText(),
      'ports'       => new sfWidgetFormInputText(),
      'secret'      => new sfWidgetFormInputText(),
      'community'   => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nasname'     => new sfValidatorString(array('max_length' => 128)),
      'shortname'   => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'type'        => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'ports'       => new sfValidatorInteger(array('required' => false)),
      'secret'      => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'community'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nas';
  }

}
