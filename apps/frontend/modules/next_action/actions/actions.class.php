<?php

/**
 * next_action actions.
 *
 * @package    pppoe
 * @subpackage next_action
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class next_actionActions extends sfActions
{
  public function executeDelete(sfWebRequest $r)
  {
    $next_action = NextActionTable::getInstance()->find($r->getParameter('id'));
    $this->forward404Unless($next_action);

    $customer = $next_action->getCustomer();
    $msg = $this->getUser()->getUsername()." хэрэглэгчийг заслаа: ".$customer->getName()."\n";
    $msg .= 'Устсан: автоматаар '.$next_action->getDateTimeObject('date')->format('Y-m-d H:i').' '.($next_action->getAction() == 'block' ? 'хаагдана' : 'нээгдэнэ')." \n";
    ChangeLogTable::saveNew($customer->getId(), 'customer', $msg, $this->getUser()->getId());

    $next_action->delete();
    $customer->updateNextDateAction();
    $this->getUser()->setFlash('message', 'Автомат үйлдлийг амжилттай устгалаа');

    $this->redirect('customer/edit?id='.$next_action->getCustomerId());
  }
}
