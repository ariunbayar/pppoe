<?php

/**
 * NextAction form base class.
 *
 * @method NextAction getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNextActionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'customer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Customer'), 'add_empty' => false)),
      'action'      => new sfWidgetFormInputText(),
      'date'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'customer_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Customer'))),
      'action'      => new sfValidatorString(array('max_length' => 50)),
      'date'        => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('next_action[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NextAction';
  }

}
