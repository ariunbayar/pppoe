<?php
/**
 * CustomerFilter form
 *
 * @package    incris
 * @subpackage form
 * @author     Ariunbayar
 */
class CustomerFilterForm extends BaseForm
{
  public function configure()
  {
    $block_array = array(0 => 'Нээлтэй/Хаалттай', 1 => 'Нээлттэй', 2 => 'Хаалттай');
    $this->setWidgets(array(
      'name'      => new sfWidgetFormInputText(),
      'bair'      => new sfWidgetFormInputText(),
      'toot'      => new sfWidgetFormInputText(),
      'phone'     => new sfWidgetFormInputText(),
      'district'  => new sfWidgetFormDoctrineChoice(array('model' => 'District', 'method' => 'getName', 'add_empty' => 'Бүх хороолол')),
      'speed'     => new sfWidgetFormDoctrineChoice(array('model' => 'Bandwidth', 'method' => 'getBandwidth', 'add_empty' => 'Бүх хурд')),
      'blocked'   => new sfWidgetFormChoice(array('choices' => $block_array)),
//      'username'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'name'      => new sfValidatorString(array('max_length' => 255, 'required' => false), array('max_length' => 'Богино оруулна уу!')),
      'bair'      => new sfValidatorString(array('max_length' => 50, 'required' => false), array('max_length' => 'Богино оруулна уу!')),
      'toot'      => new sfValidatorString(array('max_length' => 50, 'required' => false), array('max_length' => 'Богино оруулна уу!')),
      'phone'     => new sfValidatorString(array('max_length' => 50, 'required' => false), array('max_length' => 'Богино оруулна уу!')),
      'district'  => new sfValidatorDoctrineChoice(array('model' => 'District', 'required' => false)),
      'speed'     => new sfValidatorDoctrineChoice(array('model' => 'Bandwidth', 'required' => false)),
      'blocked'   => new sfValidatorChoice(array('choices' => array_keys($block_array))),
//      'username'  => new sfValidatorString(array('max_length' => 255, 'required' => false), array('max_length' => 'Богино оруулна уу!')),
    ));

    $this->addCSRFProtection();

    $this->widgetSchema->setNameFormat('search[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();

    $this->widgetSchema->setLabels(array(
      'name' => 'Нэр',
      'bair' => 'Байр',
      'toot' => 'Тоот',
      'phone' => 'Утас',
      'district' => 'Хороолол',
      'speed' => 'Хурд',
      'blocked' => 'Хаалттай эсэх',
//      'username' => 'Нэвтрэх нэр',
    ));
  }
}