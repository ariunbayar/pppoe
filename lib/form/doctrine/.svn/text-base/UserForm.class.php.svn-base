<?php

/**
 * User form.
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserForm extends BaseUserForm
{
  public function configure()
  {
    unset(
            $this['created_at'],
            $this['updated_at']
            );

    $roles = sfConfig::get('app_roles');

    $this->widgetSchema['username'] = new sfWidgetFormInputText();
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['confirm']  = new sfWidgetFormInputPassword();
    $this->widgetSchema['role']     = new sfWidgetFormSelect(array('choices' => $roles, 'multiple' => true));
    $this->widgetSchema['reset']    = new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1));

    $this->validatorSchema['username'] = new sfValidatorString(array('max_length' => 255), array('required' => 'Оруулна уу'));
    $this->validatorSchema['password'] = new sfValidatorPass();
    $this->validatorSchema['confirm']  = new sfValidatorPass();
    $this->validatorSchema['role']     = new sfValidatorChoice(array('choices' => array_keys($roles), 'multiple' => true), array('required' => 'Оруулна уу'));
    $this->validatorSchema['reset']    = new sfValidatorBoolean();

    $this->widgetSchema->setLabels(array(
      'username'  => 'Нэвтрэх нэр',
      'reset'     => 'Нууц үг өөрчлөх',
      'password'  => 'Нууц үг',
      'confirm'   => 'Нууц үг давтах',
      'role'      => 'Хандах эрх',
    ));

    $this->widgetSchema->setHelps(array(
      'role' => 'олныг сонгохдоо &lt;ctrl&gt; товч дээр дарж байгаад сонгоно',
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('username')), array('invalid' => 'Ийм нэрээр хэрэглэгч бүртгэгдсэн байна')),
      new sfValidatorCallback(array('callback' => array($this, 'postValidate'))),
    )));

    $this->setDefault('role', array());
  }

  public function postValidate($validator, $values)
  {
    if ($values['reset']) {
      try{
        $v = new sfValidatorString(array('max_length' => 255), array('required' => 'Нууц үгээ оруулна уу!', 'max_length' => 'Нууц үг дэндүү урт байна!'));
        $values['password'] = $v->clean($values['password']);
      }catch(sfValidatorError $e){
        throw new sfValidatorErrorSchema($validator, array('password' => $e));
      }
      try{
        $v = new sfValidatorString(array('max_length' => 255, 'required' => false), array('max_length' => 'Нууц үг дэндүү урт байна!'));
        $values['confirm'] = $v->clean($values['confirm']);
      }catch(sfValidatorError $e){
        throw new sfValidatorErrorSchema($validator, array('confirm' => $e));
      }

      if ($values['password']) {
        $v = new sfValidatorSchemaCompare('confirm', '==', 'password', array(), array('invalid' => 'Нууц үгээ ижил оруулна уу!'));
        $values = $v->clean($values);
      }
    }

    return $values;
  }

  /**
   * Before save
   */
  protected function doUpdateObject($values)
  {
    $values['role'] = implode(',', $values['role']);
    if ($values['reset']) {
      $values['password'] = md5($values['password']);
    }else{
      $values['password'] = $this->getObject()->getPassword();
    }
    
    $this->getObject()->fromArray($values);
  }

  /**
   * Before display
   */
  protected function updateDefaultsFromObject()
  {
    $defaults = $this->getDefaults();

    // update defaults for the main object
    if ($this->isNew()) {
      $defaults = $defaults + $this->getObject()->toArray(false);
    }else{
      $obj_vals = $this->getObject()->toArray(false);
      if ($obj_vals['role']) $obj_vals['role'] = explode(',', $obj_vals['role']);
      $defaults = $obj_vals + $defaults;
    }

    foreach ($this->embeddedForms as $name => $form)
    {
      if ($form instanceof sfFormDoctrine)
      {
        $form->updateDefaultsFromObject();
        $defaults[$name] = $form->getDefaults();
      }
    }

    $this->setDefaults($defaults);
  }
}
