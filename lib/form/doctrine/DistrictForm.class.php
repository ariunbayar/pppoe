<?php

/**
 * District form.
 *
 * @package    pppoe
 * @subpackage form
 * @author     Ariunbayar
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DistrictForm extends BaseDistrictForm
{
  public function configure()
  {
    $this->widgetSchema->setLabels(array(
      'name' => 'Хорооллын нэр'
    ));
  }
}
