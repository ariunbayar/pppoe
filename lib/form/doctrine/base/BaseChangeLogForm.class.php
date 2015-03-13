<?php

/**
 * ChangeLog form base class.
 *
 * @method ChangeLog getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseChangeLogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'object_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Customer'), 'add_empty' => true)),
      'object'      => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
      'editor_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Editor'), 'add_empty' => true)),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'object_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Customer'), 'required' => false)),
      'object'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'editor_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Editor'), 'required' => false)),
      'created_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('change_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ChangeLog';
  }

}
