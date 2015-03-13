<?php
/**
 * ResetPassword form
 *
 * @package    incris
 * @subpackage form
 * @author     Ariunbayar
 */
class ResetPasswordForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'password'  => new sfWidgetFormInputPassword(),
      'confirm'   => new sfWidgetFormInputPassword(),
    ));

    $this->setValidators(array(
      'password'  => new sfValidatorString(array('max_length' => 255), array('required' => 'Нууц үгээ оруулна уу!')),
      'confirm'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->addCSRFProtection();

    $this->widgetSchema->setNameFormat('reset[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();

    $this->widgetSchema->setLabels(array(
      'password'  => 'Шинэ нууц үг',
      'confirm'   => 'Нууц үг давтах',
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('confirm', '==', 'password', array(), array('invalid' => 'Нууц үгээ ижил оруулна уу!')));
  }
}