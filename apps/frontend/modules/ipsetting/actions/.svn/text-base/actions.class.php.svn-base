<?php

/**
 * ipsetting actions.
 *
 * @package    pppoe
 * @subpackage ipsetting
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ipsettingActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->ip_address = ConfigTable::getConfig('ip_address');
    $this->subnet = ConfigTable::getConfig('subnet');
    $this->gateway = ConfigTable::getConfig('gateway');
    $this->dns = ConfigTable::getConfig('dns');
    $this->in_progress = ConfigTable::getConfig('renew_ipsetting') == 1;
  }

  public function executeSave(sfWebRequest $r)
  {
    $ip_address = $r->getParameter('ip_address');
    $subnet = $r->getParameter('subnet');
    $gateway = $r->getParameter('gateway');
    $dns = $r->getParameter('dns');
    
    ConfigTable::setConfig('ip_address', $ip_address);
    ConfigTable::setConfig('subnet', $subnet);
    ConfigTable::setConfig('gateway', $gateway);
    ConfigTable::setConfig('dns', $dns);

    $this->getUser()->setFlash('message', 'Тохиргоо амжилттай хадгалагдлаа. Идэвхижүүлэх товчийг ашиглан шинэ тохиргоог идэвхижүүлнэ үү!');

    $this->redirect('ipsetting/index');
  }

  public function executeActivate(sfWebRequest $r)
  {
    ConfigTable::setConfig('renew_ipsetting', 1);
    $this->getUser()->setFlash('message', 'Серверийг ахин ачаалтал 1 минут хүлээнэ үү!');
    $this->redirect('ipsetting/index');
  }
}
