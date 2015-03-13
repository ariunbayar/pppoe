<?php

/**
 * Customer form.
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CustomerForm extends BaseCustomerForm
{
  public function configure()
  {
    unset(  $this['created_at'],
            $this['updated_at'],
            $this['next_date'],
            $this['next_action']
            );

    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'district_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('District'), 'add_empty' => false)),
      'bair'         => new sfWidgetFormInputText(),
      'toot'         => new sfWidgetFormInputText(),
      'username'     => new sfWidgetFormInputText(),
      'password'     => new sfWidgetFormInputText(),
      'bandwidth_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Bandwidth'), 'add_empty' => false, 'method' => 'getBandwidth')),
      'phones'       => new sfWidgetFormSelect(array('choices' => array(), 'multiple' => true)),
      'description'  => new sfWidgetFormTextarea(),
      'payment'      => new sfWidgetFormInputText(),
      'is_blocked'   => new sfWidgetFormInputCheckbox(),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'nex_date'    => new sfWidgetFormInputText(),
      'nex_time'    => new sfWidgetFormTime(array('can_be_empty' => false)),
      'nex_action'  => new sfWidgetFormChoice(array('choices' => array('block' => 'хаах', 'unblock' => 'нээх'))),
    ));

    $this->widgetSchema->setLabels(array(
      'name' => 'Нэр',
      'district_id' => 'Хороолол',
      'bair' => 'Байр',
      'toot' => 'Тоот',
      'username' => 'Нэвтрэх нэр',
      'password' => 'Нууц үг',
      'bandwidth_id' => 'Хурд',
      'description' => 'Тайлбар',
      'payment' => 'Төлбөр',
      'is_blocked' => 'Хаалттай эсэх',
    ));

    $this->setDefault('nex_time', array('hour' => 12, 'minute' => 0));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255), array('required' => 'Оруулна уу')),
      'district_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('District'))),
      'bair'         => new sfValidatorString(array('max_length' => 50), array('required' => 'Оруулна уу')),
      'toot'         => new sfValidatorString(array('max_length' => 50), array('required' => 'Оруулна уу')),
      'username'     => new sfValidatorRegex(array('max_length' => 255, 'pattern' => '/^[A-z0-9-_]+$/'), array('required' => 'Оруулна уу', 'invalid' => 'Зөвхөн тоо, латин үсэг, зураас оруулна уу')),
      'password'     => new sfValidatorRegex(array('max_length' => 255, 'pattern' => '/^[A-z0-9-_]+$/'), array('required' => 'Оруулна уу', 'invalid' => 'Зөвхөн тоо, латин үсэг, зураас оруулна уу')),
      'phones'       => new sfValidatorPass(),
      'bandwidth_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Bandwidth'))),
      'description'  => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'payment'      => new sfValidatorInteger(array('required' => false)),
      'is_blocked'   => new sfValidatorBoolean(array('required' => false)),
      'user_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'nex_date'     => new sfValidatorRegex(array('required' => false, 'pattern' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/'), array('invalid' => 'Огноо алдаатай байна')),
      'nex_time'     => new sfValidatorTime(array('required' => false)),
      'nex_action'   => new sfValidatorChoice(array('required' => false, 'choices' => array('block', 'unblock'))),
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
      new sfValidatorDoctrineUnique(array('model' => 'Customer', 'column' => array('username')), array('invalid' => 'Нэвтрэх нэр өөр хэрэглэгчийнхтэй давхцаж байна')),
      new sfValidatorCallback(array('callback' => array($this, 'postValidate'))),
    )));

    $this->widgetSchema->setNameFormat('customer[%s]');
  }

  public function postValidate($validator, $values)
  {
    if ($this->isNew()) {
      $this->checkExistance($validator, $values['username']);
    }else{
      if ($values['username'] != $this->getObject()->getUsername()) {
        $this->checkExistance($validator, $values['username']);
      }
    }

    if ($values['nex_date']) {
      if ($values['nex_date'] < date('Y-m-d')) {
        $e = new sfValidatorError($validator, 'Огноог өнөөдрөөс эхлэн оруулна уу!');
        throw new sfValidatorErrorSchema($validator, array('nex_date' => $e));
      }
      if ($values['nex_date'] == date('Y-m-d') && $values['nex_time'] < date('H:i:s')) {
        $e = new sfValidatorError($validator, 'Хугацааг одооноос хойш оруулна уу!');
        throw new sfValidatorErrorSchema($validator, array('nex_time' => $e));
      }
    }
    
    return $values;
  }

  protected function checkExistance($v, $u)
  {
    $acct_exists = RadacctTable::userExists($u);
    $check_exists = RadcheckTable::userExists($u);
    $postauth_exists = RadpostauthTable::userExists($u);
    $reply_exists = RadreplyTable::userExists($u);
    $usergroup_exists = RadusergroupTable::userExists($u);
    if ($acct_exists || $check_exists || $postauth_exists || $reply_exists || $usergroup_exists) {
      $e = new sfValidatorError($v, 'Ийм нэрээр бүртгэгдсэн байна!');
      throw new sfValidatorErrorSchema($v, array('username' => $e));
    }
  }

  protected function doSave($con = null)
  {
    $phones = $this->getValue('phones');
    
    parent::doSave($con);

    $customer = $this->getObject();
    Doctrine_Core::getTable('Phone')->createQuery('p')
            ->delete()
            ->where('p.customer_id=?', $customer->getId())
            ->execute();
    foreach ($phones as $v) {
      $v = trim($v);
      if (!$v) continue;
      $phone = new Phone();
      $phone->setCustomerId($customer->getId());
      $phone->setDescription($v);
      $phone->save();
    }
  }
}
