<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Radusergroup', 'doctrine');

/**
 * BaseRadusergroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $username
 * @property string $groupname
 * @property integer $priority
 * 
 * @method integer      getId()        Returns the current record's "id" value
 * @method string       getUsername()  Returns the current record's "username" value
 * @method string       getGroupname() Returns the current record's "groupname" value
 * @method integer      getPriority()  Returns the current record's "priority" value
 * @method Radusergroup setId()        Sets the current record's "id" value
 * @method Radusergroup setUsername()  Sets the current record's "username" value
 * @method Radusergroup setGroupname() Sets the current record's "groupname" value
 * @method Radusergroup setPriority()  Sets the current record's "priority" value
 * 
 * @package    pppoe
 * @subpackage model
 * @author     Ariunbayar
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRadusergroup extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('radusergroup');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('username', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('groupname', 'string', 64, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 64,
             ));
        $this->hasColumn('priority', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '1',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}