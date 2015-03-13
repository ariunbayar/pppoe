<?php

/**
 * RadreplyTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class RadreplyTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object RadreplyTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Radreply');
  }

  public static function userExists($username)
  {
    return Doctrine_Core::getTable('Radreply')->createQuery('rr')
            ->where('rr.username LIKE ?', $username)
            ->count();
  }

  public static function updateUsername($old, $new)
  {
    Doctrine_Core::getTable('Radreply')->createQuery('rr')
            ->update()
            ->set('rr.username', '?', $new)
            ->where('rr.username LIKE ?', $old)
            ->execute();
  }
}