<?php

/**
 * changelog actions.
 *
 * @package    pppoe
 * @subpackage changelog
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class changelogActions extends sfActions
{
  public function executeIndex(sfWebRequest $r)
  {
    $customer_id = (int)$r->getParameter('customer_id');
    $page = $r->getParameter('page', 1);

    $dql = Doctrine_Core::getTable('ChangeLog')->createQuery('cl')->where('1')->orderBy('cl.created_at DESC');
    if ($customer_id) $dql->andWhere('cl.object=?', 'customer')->andWhere('cl.object_id=?', $customer_id);

    $pager = new sfDoctrinePager('Customer', sfConfig::get('app_max_changelogs', 20));
    $pager->setQuery($dql);
    $pager->setPage($page);
    $pager->init();

    $this->pager = $pager;
    $this->changelogs = $pager->getResults();
  }
}
