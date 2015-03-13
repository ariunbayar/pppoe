<?php

/**
 * account actions.
 *
 * @package    pppoe
 * @subpackage account
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accountActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $bandwidths = $this->getBandwidths();

    $dql = Doctrine_Core::getTable('Radcheck')->createQuery('rc')
            ->select('rc.id, rc.username, rc.value as password')
            ->orderBy('rc.username ASC');
    $accounts = $dql->fetchArray();
    $dql = Doctrine_Core::getTable('Radreply')->createQuery('rr')
            ->select('rr.id, rr.username, rr.value as ip')
            ->orderBy('rr.username ASC');
    $addrs = $dql->fetchArray();
    foreach ($accounts as $i => $v){
      if ($addrs[$i]['username'] == $accounts[$i]['username']) $accounts[$i]['ip'] = $addrs[$i]['ip'];
      $ips = explode('.', $accounts[$i]['ip']);
      $sub = $ips[0].'.'.$ips[1].'.';
      $bandwidth = 'алдаа';
      if (isset($bandwidths[$sub])) {
        $bandwidth = $bandwidths[$sub];
      }
      $accounts[$i]['bandwidth'] = $bandwidth;
    }
    $this->accounts = $accounts;
  }

  public function executeEdit(sfWebRequest $r)
  {
    $username = $r->getParameter('username');
    
    $radcheck = Doctrine_Core::getTable('Radcheck')->findOneBy('username', $username);
//    echo $radcheck->getId();
    $this->username = $radcheck->getUsername();
    $this->password = $radcheck->getValue();

    $bandwidths = $this->getBandwidths();
    $radreply = Doctrine_Core::getTable('Radreply')->findOneBy('username', $username);
//    echo $radreply->getId();
//    die;
    $ips = explode('.', $radreply->getValue());
    $this->sub = $ips[0].'.'.$ips[1].'.';
    $this->bandwidths = $bandwidths;
  }

  private function getBandwidths()
  {
    $dql = Doctrine_Core::getTable('Bandwidth')->createQuery('b')
            ->orderBy('b.bandwidth ASC');
    $bands = $dql->fetchArray();
    $bandwidths = array();
    foreach ($bands as $band) {
      $bandwidths[$band['ipaddress']] = $band['bandwidth'];
    }

    return $bandwidths;
  }

  public function executeUpdate(sfWebRequest $r)
  {
    $username = $r->getParameter('username');
    $password = $r->getParameter('password');
    $sub = $r->getParameter('sub');
    $bandwidths = $this->getBandwidths();
    $radcheck = Doctrine_Core::getTable('Radcheck')->findOneBy('username', $username);
    $radreply = Doctrine_Core::getTable('Radreply')->findOneBy('username', $username);
    if (!($radcheck instanceof Radcheck) || !($radreply instanceof Radreply)) {
      $this->getUser()->setFlash('message', 'Ийм нэртэй хэрэглэгч олдсонгүй');
      $this->redirect('account/index');
    }

    if (preg_match("/^[A-z0-9_]+$/", $password)) {
      if (isset($bandwidths[$sub])) {
        $ip = $this->getNewIp($sub);
        if ($ip !== false) {
          $radcheck->setValue($password);
          $radcheck->save();
          $radreply->setValue($ip);
          $radreply->save();
          $this->getUser()->setFlash('message', 'Хэрэглэгчийг амжилттай хадгаллаа');
          $this->redirect('account/index');
        }else{
          $this->getUser()->setFlash('message', 'Энэ хурд дээр IP хаяг үлдсэнгүй');
        }
      }else{
        $this->getUser()->setFlash('message', 'Хурд буруу байна');
      }
    }else{
      $this->getUser()->setFlash('message', 'Нууц үг алдаатай байна');
    }

    $this->username = $username;
    $this->password = $password;
    $this->sub      = $sub;
    $this->bandwidths = $bandwidths;

    $this->setTemplate('edit');
  }

  private function getNewIp($sub)
  {
    $ips = explode('.', $sub);
    for ($i=1; $i<255; $i++){
      for ($j=1; $j<255; $j++) {
        $ip = "$ips[0].$ips[1].$i.$j";
        $radreply = Doctrine_Core::getTable('Radreply')->findOneBy('value', $ip);
        if (!($radreply instanceof Radreply)) {
          $i = 255;
          $j = 255;
        }else{
          $ip = false;
        }
      }
    }
    return $ip;
  }

  public function executeNew(sfWebRequest $r)
  {
    $this->username = '';
    $this->password = '';
    $this->sub = '';
    $this->bandwidths = $this->getBandwidths();
  }

  public function executeCreate(sfWebRequest $r)
  {
    $username = $r->getParameter('username');
    $password = $r->getParameter('password');
    $sub = $r->getParameter('sub');
    $bandwidths = $this->getBandwidths();

    if (preg_match("/^[A-z0-9_]+$/", $username)) {
      $radcheck = Doctrine_Core::getTable('Radcheck')->findOneBy('username', $username);
      if (!($radcheck instanceof Radcheck)) {
        if (preg_match("/^[A-z0-9_]+$/", $password)) {
          if (isset($bandwidths[$sub])) {
            $ip = $this->getNewIp($sub);
            if ($ip !== false) {
              $radcheck = new Radcheck();
              $radcheck->setUsername($username);
              $radcheck->setAttr('Password');
              $radcheck->setOp('==');
              $radcheck->setValue($password);
              $radcheck->save();

              $radreply = new Radreply();
              $radreply->setUsername($username);
              $radreply->setAttr('Framed-IP-Address');
              $radreply->setOp(':=');
              $radreply->setValue($ip);
              $radreply->save();

              $radusergroup = new Radusergroup();
              $radusergroup->setUsername($username);
              $radusergroup->setGroupname('static');
              $radusergroup->setPriority(1);
              $radusergroup->save();
              
              $this->getUser()->setFlash('message', 'Шинэ хэрэглэгчийг амжилттай хадгаллаа');
              $this->redirect('account/index');
            }else{
              $this->getUser()->setFlash('message', 'Энэ хурд дээр IP хаяг үлдсэнгүй');
            }
          }else{
            $this->getUser()->setFlash('message', 'Хурд буруу байна');
          }
        }else{
          $this->getUser()->setFlash('message', 'Нууц үг алдаатай байна');
        }
      }else{
        $this->getUser()->setFlash('message', 'Ийм нэрээр хэрэглэгч бүртгэгдсэн байна');
      }
    }else{
      $this->getUser()->setFlash('message', 'Нэр алдаатай байна');
    }


    $this->username = $username;
    $this->password = $password;
    $this->sub      = $sub;
    $this->bandwidths = $bandwidths;

    $this->setTemplate('new');
  }

  public function executeDelete(sfWebRequest $r)
  {
    $username = $r->getParameter('username');
    $radcheck = Doctrine_Core::getTable('Radcheck')->findOneBy('username', $username);
    $radreply = Doctrine_Core::getTable('Radreply')->findOneBy('username', $username);
    $radusergroup = Doctrine_Core::getTable('Radusergroup')->findOneBy('username', $username);

    $radcheck->delete();
    $radreply->delete();
    $radusergroup->delete();

    $this->getUser()->setFlash('message', 'Амжилттай устгалаа');
    $this->redirect('account/index');
  }
}
