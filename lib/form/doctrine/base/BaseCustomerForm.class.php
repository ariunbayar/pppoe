<?php

/**
 * Customer form base class.
 *
 * @method Customer getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCustomerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'district_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('District'), 'add_empty' => false)),
      'bair'         => new sfWidgetFormInputText(),
      'toot'         => new sfWidgetFormInputText(),
      'username'     => new sfWidgetFormInputText(),
      'password'     => new sfWidgetFormInputText(),
      'bandwidth_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Bandwidth'), 'add_empty' => false)),
      'description'  => new sfWidgetFormTextarea(),
      'payment'      => new sfWidgetFormInputText(),
      'is_blocked'   => new sfWidgetFormInputCheckbox(),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'next_action'  => new sfWidgetFormInputText(),
      'next_date'    => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'district_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('District'))),
      'bair'         => new sfValidatorString(array('max_length' => 50)),
      'toot'         => new sfValidatorString(array('max_length' => 50)),
      'username'     => new sfValidatorString(array('max_length' => 255)),
      'password'     => new sfValidatorString(array('max_length' => 255)),
      'bandwidth_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Bandwidth'))),
      'description'  => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'payment'      => new sfValidatorInteger(array('required' => false)),
      'is_blocked'   => new sfValidatorBoolean(array('required' => false)),
      'user_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'next_action'  => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'next_date'    => new sfValidatorPass(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Customer', 'column' => array('username')))
    );

    $this->widgetSchema->setNameFormat('customer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Customer';
  }

}
