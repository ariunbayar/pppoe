<?php

/**
 * management actions.
 *
 * @package    pppoe
 * @subpackage management
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class managementActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $dql = Doctrine_Core::getTable('Customer')->createQuery('c')
            ->select('c.id, c.name, c.username, c.password, c.is_blocked, c.bandwidth_id')
            ->orderBy('c.username DESC');
    $this->customers = $dql->fetchArray();

    $dql = Doctrine_Core::getTable('Radcheck')->createQuery('rc')
            ->select('rc.username, rc.attr, rc.value')
            ->orderBy('rc.username DESC');
    $this->radchecks = $dql->fetchArray();

    $dql = Doctrine_Core::getTable('Radreply')->createQuery('rr')
            ->select('rr.username, rr.value as ip')
            ->orderBy('rr.username DESC');
    $this->radreplies = $dql->fetchArray();
    
    $dql = Doctrine_Core::getTable('Radusergroup')->createQuery('ru')
            ->select('ru.username')
            ->orderBy('ru.username DESC');
    $this->radusergroup = $dql->fetchArray();

    $this->speeds = BandwidthTable::getSpeedArray();
  }
}
