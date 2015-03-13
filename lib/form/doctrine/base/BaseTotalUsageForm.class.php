<?php

/**
 * TotalUsage form base class.
 *
 * @method TotalUsage getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTotalUsageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'count'       => new sfWidgetFormInputText(),
      'input_bits'  => new sfWidgetFormInputText(),
      'output_bits' => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'count'       => new sfValidatorInteger(array('required' => false)),
      'input_bits'  => new sfValidatorInteger(array('required' => false)),
      'output_bits' => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('total_usage[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TotalUsage';
  }

}
