<?php
/**
 * Login form
 *
 * @package    incris
 * @subpackage form
 * @author     Ariunbayar
 */
class LoginForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'username'  => new sfWidgetFormInputText(),
      'password'  => new sfWidgetFormInputPassword(),
    ));

    $this->setValidators(array(
      'username'  => new sfValidatorString(array('max_length' => 255), array('required' => 'Нэвтрэх нэрээ оруулна уу!')),
      'password'  => new sfValidatorString(array('max_length' => 255), array('required' => 'Нууц үгээ оруулна уу!')),
    ));

    $this->addCSRFProtection();

    $this->widgetSchema->setNameFormat('login[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();

    $this->widgetSchema->setLabels(array(
      'username' => 'Нэр',
      'password' => 'Нууц үг',
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'postValidate'))));
  }

  public function postValidate($validator, $values)
  {
    if (empty($values['username']) || empty($values['password'])) return $values;

    $error = new sfValidatorError($this->validatorSchema['username'], 'Нэр эсвэл нууц үг буруу байна!');
    $this->user = Doctrine_Core::getTable('User')->findOneByUsername($values['username']);
    if (!$this->user || $this->user->getPassword() != md5($values['password'])) {
      throw new sfValidatorErrorSchema($validator, array('username' => $error));
    }

    return $values;
  }
}