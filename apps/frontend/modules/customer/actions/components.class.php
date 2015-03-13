<?php

/**
 * customer actions.
 *
 * @package    pppoe
 * @subpackage customer
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class customerComponents extends sfComponents
{
  public function executeTotalUser(sfWebRequest $request)
  {
    $server = sfConfig::get('app_client_ip');
    $token = sfConfig::get('app_client_token');
    $url = "http://$server/killip/users.php?token=$token";
    $n = @file_get_contents($url);

    $this->n = $n;
  }
}
