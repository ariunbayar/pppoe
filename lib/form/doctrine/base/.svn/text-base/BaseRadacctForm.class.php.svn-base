<?php

/**
 * Radacct form base class.
 *
 * @method Radacct getObject() Returns the current form's model object
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRadacctForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'radacctid'            => new sfWidgetFormInputHidden(),
      'acctsessionid'        => new sfWidgetFormInputText(),
      'acctuniqueid'         => new sfWidgetFormInputText(),
      'username'             => new sfWidgetFormInputText(),
      'realm'                => new sfWidgetFormInputText(),
      'nasipaddress'         => new sfWidgetFormInputText(),
      'nasportid'            => new sfWidgetFormInputText(),
      'nasporttype'          => new sfWidgetFormInputText(),
      'acctstarttime'        => new sfWidgetFormDateTime(),
      'acctstoptime'         => new sfWidgetFormDateTime(),
      'acctsessiontime'      => new sfWidgetFormInputText(),
      'acctauthentic'        => new sfWidgetFormInputText(),
      'connectinfo_start'    => new sfWidgetFormInputText(),
      'connectinfo_stop'     => new sfWidgetFormInputText(),
      'acctinputoctets'      => new sfWidgetFormInputText(),
      'acctoutputoctets'     => new sfWidgetFormInputText(),
      'calledstationid'      => new sfWidgetFormInputText(),
      'callingstationid'     => new sfWidgetFormInputText(),
      'acctterminatecause'   => new sfWidgetFormInputText(),
      'servicetype'          => new sfWidgetFormInputText(),
      'framedprotocol'       => new sfWidgetFormInputText(),
      'framedipaddress'      => new sfWidgetFormInputText(),
      'acctstartdelay'       => new sfWidgetFormInputText(),
      'acctstopdelay'        => new sfWidgetFormInputText(),
      'xascendsessionsvrkey' => new sfWidgetFormInputText(),
      'processed'            => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'radacctid'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('radacctid')), 'empty_value' => $this->getObject()->get('radacctid'), 'required' => false)),
      'acctsessionid'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'acctuniqueid'         => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'username'             => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'realm'                => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'nasipaddress'         => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'nasportid'            => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'nasporttype'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'acctstarttime'        => new sfValidatorDateTime(array('required' => false)),
      'acctstoptime'         => new sfValidatorDateTime(array('required' => false)),
      'acctsessiontime'      => new sfValidatorInteger(array('required' => false)),
      'acctauthentic'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'connectinfo_start'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'connectinfo_stop'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'acctinputoctets'      => new sfValidatorInteger(array('required' => false)),
      'acctoutputoctets'     => new sfValidatorInteger(array('required' => false)),
      'calledstationid'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'callingstationid'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'acctterminatecause'   => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'servicetype'          => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'framedprotocol'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'framedipaddress'      => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'acctstartdelay'       => new sfValidatorInteger(array('required' => false)),
      'acctstopdelay'        => new sfValidatorInteger(array('required' => false)),
      'xascendsessionsvrkey' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'processed'            => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('radacct[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Radacct';
  }

}
