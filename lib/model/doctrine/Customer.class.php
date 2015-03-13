<?php

/**
 * Customer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    pppoe
 * @subpackage model
 * @author     Ariunbayar
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Customer extends BaseCustomer
{
  public function updateNextDateAction()
  {
    $next_actions = Doctrine_Core::getTable('NextAction')->createQuery('na')
            ->where('na.customer_id=?', $this->getId())
            ->orderBy('na.date ASC')
            ->limit(1)
            ->execute();

    if ($next_actions) {
      $next_action = $next_actions[0];
      $this->setNextAction($next_action->getAction());
      $this->setNextDate($next_action->getDate());
      $this->save();
    }else{
      $this->setNextAction(null);
      $this->setNextDate(null);
      $this->save();
    }
  }

  public function getOrderedNextActions()
  {
    $dql = Doctrine_Core::getTable('NextAction')->createQuery('na')
            ->where('na.customer_id=?', $this->getId())
            ->orderBy('na.date ASC');
    return $dql->execute();
  }
}
