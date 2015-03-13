<?php

/**
 * customer actions.
 *
 * @package    pppoe
 * @subpackage customer
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class customerActions extends sfActions
{
  public function executeIndex(sfWebRequest $r)
  {
    $page = $r->getParameter('page', 1);
    
    $dql = Doctrine_Core::getTable('Customer')
          ->createQuery('a')
          ->where('1')
          ->orderBy('a.created_at ASC');

    $form = new CustomerFilterForm();
    if ($r->isMethod(sfRequest::POST)) {
      $form->bind($r->getParameter($form->getName()));
      if ($form->isValid()) {
        if ($form->getValue('name')) $dql->andWhere('a.name LIKE ?', '%'.$form->getValue('name').'%');
        if ($form->getValue('bair')) $dql->andWhere('a.bair LIKE ?', $form->getValue('bair').'%');
        if ($form->getValue('toot')) $dql->andWhere('a.toot LIKE ?', $form->getValue('toot').'%');
        if ($form->getValue('phone')) {
          $dql->leftJoin('a.Phones p')->andWhere('p.description LIKE ?', $form->getValue('phone').'%');
        }
        if ($form->getValue('district')) $dql->andWhere('a.district_id=?', $form->getValue('district'));
        if ($form->getValue('speed')) $dql->andWhere('a.bandwidth_id=?', $form->getValue('speed'));
        if ($form->getValue('blocked')) $dql->andWhere('a.is_blocked=?', $form->getValue('blocked') - 1);
      }
    }
    
    $pager = new sfDoctrinePager('Customer', sfConfig::get('app_max_customers', 20));
    $pager->setQuery($dql);
    $pager->setPage($page);
    $pager->init();

    $this->pager = $pager;
    $this->customers = $pager->getResults();

    $this->form = $form;
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CustomerForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CustomerForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($customer = Doctrine_Core::getTable('Customer')->find(array($request->getParameter('id'))), sprintf('Object customer does not exist (%s).', $request->getParameter('id')));
    $this->form = new CustomerForm($customer);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($customer = Doctrine_Core::getTable('Customer')->find(array($request->getParameter('id'))), sprintf('Object customer does not exist (%s).', $request->getParameter('id')));
    $this->form = new CustomerForm($customer);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($customer = Doctrine_Core::getTable('Customer')->find(array($request->getParameter('id'))), sprintf('Object customer does not exist (%s).', $request->getParameter('id')));
    $radreply = Doctrine_Core::getTable('Radreply')->findOneBy('username', $customer->getUsername());
    $radcheck = Doctrine_Core::getTable('Radcheck')->findOneBy('username', $customer->getUsername());
    $radusergroup = Doctrine_Core::getTable('Radusergroup')->findOneBy('username', $customer->getUsername());

    /* @var $customer Customer */
    
    // remove phones while collecting log data
    $s_phone = '';
    foreach ($customer->getPhones() as $i => $phone) {
      $s_phone .= ($i?', ':'').$phone->getDescription();
      $phone->delete();
    }
    $msg = $this->getUser()->getUsername()." хэрэглэгчийг устгалаа: ".$customer->getName()."\n"
          ."Нэр: ".$customer->getName()."\n"
          ."Хороолол: ".$customer->getDistrict()->getName()."\n"
          ."Байр: ".$customer->getBair()."\n"
          ."Тоот: ".$customer->getToot()."\n"
          ."Нэвтрэх нэр: ".$customer->getUsername()."\n"
          ."Хурд: ".$customer->getBandwidth()->getBandwidth()."k\n"
          ."Утасны дугаар: ".$s_phone."\n"
          ."Тайлбар: ".$customer->getDescription()."\n"
          ."Төлбөр: ".number_format($customer->getPayment(), 0, '.', '`')."\n"
          ."Хаалттай эсэх: ".($customer->getIsBlocked() ? 'хаалттай' : 'нээлттэй')."\n"
          ."Хаах/Нээх: ".($customer->getNextAction()?$customer->getNextDate().' '.($customer->getNextAction()=='block'?'хаах':'нээх'):'-')."\n"
          ."Бүртгэсэн огноо: ".$customer->getCreatedAt()."\n";
    ChangeLogTable::saveNew(null, 'customer', $msg, $this->getUser()->getId());
    // remove next_actions
    foreach ($customer->getNextActions() as $next_action) { $next_action->delete(); }
    // drop connection and remove ip info
    if ($radreply) {
      $this->dropUser($customer->getUsername());
//      $drop_ok = $this->dropIp($radreply->getValue());
//      if (!$drop_ok) {
//        $this->getUser()->setFlash('message', 'Хэрэглэгчтэй үүссэн холболтыг таслахад алдаа гарлаа');
//        $this->redirect('@homepage');
//      }
      $radreply->delete();
    }
    if ($radcheck) $radcheck->delete();
    if ($radusergroup) $radusergroup->delete();
    // mark accounting data as deleted
    RadacctTable::updateUsername($customer->getUsername(), 'DELETED_'.$customer->getUsername());
    RadpostauthTable::updateUsername($customer->getUsername(), 'DELETED_'.$customer->getUsername());
    // update changelog by object id
    Doctrine_Core::getTable('ChangeLog')->createQuery('cl')
            ->update()
            ->set('cl.object_id', '?', 0)
            ->where('cl.object_id=?', $customer->getId())
            ->andWhere('cl.object=?', 'customer')
            ->execute();
    $customer->delete();

    $this->getUser()->setFlash('message', 'Хэрэглэгчийг амжилттай устгалаа');
    $this->redirect('customer/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $values = $request->getParameter($form->getName());
    $values['user_id'] = $this->getUser()->getId();
    $form->bind($values, $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $old_vals = $form->getObject()->toArray();
      $is_new = $form->isNew();
      $ip = BandwidthTable::getNewIp($form->getValue('bandwidth_id'));
      if ($ip === false) {
        $this->getUser()->setFlash('message', 'Энэ хурд дээр хэрэглэгч нэмэхэд алдаа гарлаа');
        $this->redirect('@homepage');
      }

      if ($is_new) {
        $customer = $form->save();

        // changelog
        $s_phone = '';
        foreach ($customer->getPhones() as $i => $phone) { $s_phone .= ($i?', ':'').$phone->getDescription(); }
        $msg = $this->getUser()->getUsername()." шинэ хэрэглэгч үүсгэлээ: ".$customer->getName()."\n"
              ."Нэр: ".$customer->getName()."\n"
              ."Хороолол: ".$customer->getDistrict()->getName()
              ."Байр: ".$customer->getBair()."\n"
              ."Тоот: ".$customer->getToot()."\n"
              ."Нэвтрэх нэр: ".$customer->getUsername()."\n"
              ."Хурд: ".$customer->getBandwidth()->getBandwidth()."k\n"
              ."Утасны дугаар: ".$s_phone."\n"
              ."Тайлбар: ".$customer->getDescription()."\n"
              ."Төлбөр: ".number_format($customer->getPayment(), 0, '.', '`')."\n"
              ."Хаалттай эсэх: ".($customer->getIsBlocked() ? 'хаалттай' : 'нээлттэй')."\n"
              ."Хаах/Нээх: ".($customer->getNextAction()?$customer->getNextDate().' '.($customer->getNextAction()=='block'?'хаах':'нээх'):'-')."\n"
              ."Бүртгэсэн огноо: ".$customer->getCreatedAt()."\n";
        ChangeLogTable::saveNew($customer->getId(), 'customer', $msg, $this->getUser()->getId());

        // authentication data
        $radcheck = new Radcheck();
        $radcheck->setUsername($customer->getUsername());
        $radcheck->setAttr($customer->getIsBlocked() ? 'blocked' : 'Password');
        $radcheck->setOp('==');
        $radcheck->setValue($customer->getPassword());
        $radcheck->save();
        
        $radreply = new Radreply();
        $radreply->setUsername($customer->getUsername());
        $radreply->setAttr('Framed-IP-Address');
        $radreply->setOp(':=');
        $radreply->setValue($ip);
        $radreply->save();
        
        $radusergroup = new Radusergroup();
        $radusergroup->setUsername($customer->getUsername());
        $radusergroup->setGroupname('static');
        $radusergroup->setPriority(1);
        $radusergroup->save();
      }else{ // not new
        $user_changed = ($old_vals['username'] != $form->getValue('username'));
        $pass_changed = ($old_vals['password'] != $form->getValue('password'));
        $block_changed = ($old_vals['is_blocked'] != $form->getValue('is_blocked'));
        $speed_changed = ($old_vals['bandwidth_id'] != $form->getValue('bandwidth_id'));
        $radcheck = null;
        if ($pass_changed || $block_changed) {
          $radcheck = Doctrine_Core::getTable('Radcheck')->findOneByUsername($old_vals['username']);
          if (!($radcheck instanceof Radcheck)) {
            $this->getUser()->setFlash('message', 'Нууц үгийг уншихад алдаа гарлаа');
            $this->redirect('@homepage');
          }
        }
        $customer = $form->save();
        if (($pass_changed || $block_changed) && ($radcheck instanceof Radcheck)) {
          if ($block_changed) $radcheck->setAttr($customer->getIsBlocked() ? 'blocked' : 'Password');
          if ($pass_changed) $radcheck->setValue($customer->getPassword());
          $radcheck->save();
        }
        $radreply = null;
        if ($user_changed || $pass_changed || $block_changed || $speed_changed) {
          $radreply = Doctrine_Core::getTable('Radreply')->findOneByUsername($old_vals['username']);
          if (!($radreply instanceof Radreply)) {
            $this->getUser()->setFlash('message', 'Хурдны мэдээллийг уншихад алдаа гарлаа');
            $this->redirect('@homepage');
          }
          $this->dropUser($old_vals['username']);
//          $drop_ok = $this->dropIp($radreply->getValue());
//          if (!$drop_ok) {
//            $this->getUser()->setFlash('message', 'Хэрэглэгчтэй үүссэн холболтыг таслахад алдаа гарлаа');
//            $this->redirect('@homepage');
//          }
        }
        $old_phone = '';
        foreach ($form->getObject()->getPhones() as $i => $phone) { $old_phone .= ($i?', ':'').$phone->getDescription(); }
        if ($speed_changed) {
          $radreply->setValue(BandwidthTable::getNewIp($customer->getBandwidthId()));
          $radreply->save();
        }
        if ($user_changed) {
          RadacctTable::updateUsername($old_vals['username'], $customer->getUsername());
          RadcheckTable::updateUsername($old_vals['username'], $customer->getUsername());
          RadpostauthTable::updateUsername($old_vals['username'], $customer->getUsername());
          RadreplyTable::updateUsername($old_vals['username'], $customer->getUsername());
          RadusergroupTable::updateUsername($old_vals['username'], $customer->getUsername());
        }

        // next_action
        $next_action = null;
        if ($form->getValue('nex_date')) {
          $next_date = $form->getValue('nex_date') . ' ' . $form->getValue('nex_time');
          $next_action = new NextAction();
          $next_action->setCustomerId($customer);
          $next_action->setDate(date('Y-m-d H:i:s', strtotime($next_date)));
          $next_action->setAction($form->getValue('nex_action'));
          $next_action->save();
          $customer->updateNextDateAction();
        }

        // changelog
        $msg = '';
        $new_vals = $customer->toArray();
        $new_phone = '';
        foreach ($customer->getPhones() as $i => $phone) { $new_phone .= ($i?', ':'').$phone->getDescription(); }
        if ($new_vals['name'] != $old_vals['name']) { $msg .= 'Нэр: '.$old_vals['name'].' -> '.$new_vals['name']."\n";}
        if ($new_vals['district_id'] != $old_vals['district_id']) {
          $old_district = DistrictTable::getInstance()->find($old_vals['district_id']);
          $new_district = DistrictTable::getInstance()->find($new_vals['district_id']);
          $msg .= 'Хороолол: '.$old_district->getName().' -> '.$new_district->getName()."\n";
        }
        if ($new_vals['bair'] != $old_vals['bair']) { $msg .= 'Байр: '.$old_vals['bair'].' -> '.$new_vals['bair']."\n";}
        if ($new_vals['toot'] != $old_vals['toot']) { $msg .= 'Тоот: '.$old_vals['toot'].' -> '.$new_vals['toot']."\n";}
        if ($user_changed) { $msg .= 'Нэвтрэх нэр: '.$old_vals['username'].' -> '.$new_vals['username']."\n";}
        if ($pass_changed) { $msg .= "Нууц үг: *** -> *** \n";}
        if ($new_vals['bandwidth_id'] != $old_vals['bandwidth_id']) {
          $new_bandwidth = BandwidthTable::getInstance()->find($new_vals['bandwidth_id']);
          $old_bandwidth = BandwidthTable::getInstance()->find($old_vals['bandwidth_id']);
          $msg .= 'Хурд: '.$old_bandwidth->getBandwidth().'k -> '.$new_bandwidth->getBandwidth()."k\n";
        }
        if ($old_phone != $new_phone) { $msg .= 'Утас: '.$old_phone.' -> '.$new_phone."\n"; }
        if ($new_vals['description'] != $old_vals['description']) { $msg .= 'Тайлбар: '.$old_vals['description'].' -> '.$new_vals['description']."\n";}
        if ($new_vals['payment'] != $old_vals['payment']) {
          $msg .= 'Төлбөр: '.number_format($old_vals['payment'], 0, '.', '`').' -> '.number_format($new_vals['payment'], 0, '.', '`')."\n";
        }
        if ($block_changed) { $msg .= 'Хаалттай эсэх: '.($old_vals['is_blocked'] ? 'хаалттай' : 'нээлттэй').' -> '.($new_vals['is_blocked'] ? 'хаалттай' : 'нээлттэй')."\n";}
        if ($next_action) { $msg .= 'Нэмсэн: автоматаар '.$next_action->getDateTimeObject('date')->format('Y-m-d H:i').' '.($next_action->getAction() == 'block' ? 'хаагдана' : 'нээгдэнэ')." \n"; }
        
        if ($msg != '') {
          $msg = $this->getUser()->getUsername()." хэрэглэгчийг заслаа: ".$customer->getName()."\n".$msg;
          ChangeLogTable::saveNew($customer->getId(), 'customer', $msg, $this->getUser()->getId());
        }
      } // end of is_new

      $this->getUser()->setFlash('message', 'Хэрэглэгчийг амжилттай хадгаллаа');
      $this->redirect('customer/edit?id='.$customer->getId());
    }
  }

  /**
   * DEPRECATED
   */
  protected function dropIp($ip)
  {
    $ip = urlencode($ip);
    $server = sfConfig::get('app_client_ip');
    $token = sfConfig::get('app_client_token');
    $url = "http://$server/killip/kill.php?token=$token&ip=$ip";

    $result = file_get_contents($url);
    return $result == 'ok' || $result == 'invalid';
  }

  protected function dropUser($username)
  {
    $server = sfConfig::get('app_client_ip');
    $user = sfConfig::get('app_client_username');
    $pass = sfConfig::get('app_client_password');
    $url = "http://$server:8080/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_PORT, "8080");
    $content = curl_exec($ch);
//    $info = curl_getinfo($ch);
    curl_close($ch);

    $pattern = "/<td><a href=\"\/cmd\?(poes[0-9]+)\&amp;show\&amp;auth\">$username<\/a><\/td>/i";
    preg_match($pattern, $content, $matches);
    $conn = $matches[1];

    $url = "http://$server:8080/cmd?$conn&close";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_PORT, "8080");
    $content = curl_exec($ch);
//    $info = curl_getinfo($ch);
    curl_close($ch);
  }

  public function executeShow(sfWebRequest $r)
  {
    $customer = Doctrine_Core::getTable('Customer')->find($r->getParameter('id'));
    $this->forward404Unless($customer);

    $this->customer = $customer;
    $this->durations_widget = new sfWidgetFormChoice(array('choices' => $this->getDurations()));
    $this->time_widget = new sfWidgetFormTime(array('can_be_empty' => false));
  }

  public function getDurations()
  {
    return array(
      '12hour' => 'Сүүлийн 12 цаг',
      'day' => 'Сүүлийн 1 өдөр',
      'week' => 'Сүүлийн 7 хоног',
      'month' => 'Сүүлийн 30 хоног',
    );
  }

  public function executeLoadData(sfWebRequest $r)
  {
    $customer_id = $r->getParameter('customer_id');
    $date = $r->getParameter('date');
    $hour = (int)$r->getParameter('hour');
    $minute = (int)$r->getParameter('minute');
    $duration = $this->getRequestParameter('duration');

    $interval = 60;
    $time_a = 0;
    $time_b = 0;
    $this->calculateDuration($date, $hour, $minute, $duration, $time_b, $time_a, $interval);

    $values = $this->retrieveUsage($customer_id, $duration, $time_a, $time_b, $interval);

    return $this->renderText(json_encode($values));
  }

  public function executeLoadPrev(sfWebRequest $r)
  {
    $customer_id = $r->getParameter('customer_id');
    $date = $r->getParameter('date');
    $hour = (int)$r->getParameter('hour');
    $minute = (int)$r->getParameter('minute');
    $duration = $this->getRequestParameter('duration');

    $interval = 60;
    $time_a = 0;
    $time_b = 0;
    $this->calculateDuration($date, $hour, $minute, $duration, $time_b, $time_a, $interval);
    $date = date('Y-m-d', $time_a);
    $hour = date('G', $time_a);
    $minute = (int)date('i', $time_a);
    $this->calculateDuration($date, $hour, $minute, $duration, $time_b, $time_a, $interval);

    $values = $this->retrieveUsage($customer_id, $duration, $time_a, $time_b, $interval);

    $all_values = array(
      array($date, $hour, $minute),
      $values
    );

    return $this->renderText(json_encode($all_values));
  }

  public function executeLoadNext(sfWebRequest $r)
  {
    $customer_id = $r->getParameter('customer_id');
    $date = $r->getParameter('date');
    $hour = (int)$r->getParameter('hour');
    $minute = (int)$r->getParameter('minute');
    $duration = $this->getRequestParameter('duration');

    $interval = 60;
    $time_a = 0;
    $time_b = 0;
    $this->calculateDuration($date, $hour, $minute, $duration, $time_b, $time_a, $interval);
    $t = $time_b + ($time_b - $time_a);
    $date = date('Y-m-d', $t);
    $hour = date('G', $t);
    $minute = (int)date('i', $t);
    $this->calculateDuration($date, $hour, $minute, $duration, $time_b, $time_a, $interval);

    $values = $this->retrieveUsage($customer_id, $duration, $time_a, $time_b, $interval);
    
    $all_values = array(
      array($date, $hour, $minute),
      $values
    );

    return $this->renderText(json_encode($all_values));
  }

  private function calculateDuration($date, $hour, $minute, $duration, &$time_b, &$time_a, &$interval)
  {
    $hour = $hour < 10 ? '0'.$hour : $hour;
    $minute = $minute < 10 ? '0'.$minute : $minute;
    $time_b = strtotime($date.' '.$hour.':'.$minute.':00', time());
    if (!in_array($duration, array_keys($this->getDurations()))) {
      $duration = '12hour';
    }

    $interval = 60;
    switch ($duration) {
      case '12hour':
        $time_a = $time_b - 12 * 3600;
        break;
      case 'day':
        $time_a = $time_b - 24 * 3600;
        break;
      case 'week':
        $time_a = $time_b - 7 * 24 * 3600;
        $interval = 15 * 60;
        break;
      case 'month':
        $time_a = $time_b - 30 * 24 * 3600;
        $interval = 60 * 60;
        break;
    }
  }
  
  private function retrieveUsage($customer_id, $duration, $time_a, $time_b, $interval)
  {
    $customer = Doctrine_Core::getTable('Customer')->find($customer_id);
    if (!($customer instanceof Customer)) return array();

    $dql = Doctrine_Core::getTable('Radacct')->createQuery('ra')
            ->select('ra.acctstarttime as start, ra.acctstoptime as stop, ra.acctsessiontime as time, ra.acctinputoctets as input, ra.acctoutputoctets as output')
            ->where('ra.username=?', $customer->getUsername())
            ->andWhere('ra.acctstarttime>? AND ra.acctstarttime<? OR ra.acctstoptime>? AND ra.acctstoptime<?', array(date('Y-m-d H:i:s', $time_a), date('Y-m-d H:i:s', $time_b), date('Y-m-d H:i:s', $time_a), date('Y-m-d H:i:s', $time_b)))
            ->orderBy('ra.acctstarttime DESC');
    $usages = $dql->fetchArray();
    
    $values = array(
      'type' => 'area',
      'name' => 'input',
      'pointInterval' => $interval * 1000,
      'pointStart' => ($time_a + (int)date('Z')) * 1000,
      'data' => array()
    );

    $usage = array_pop($usages);
    for ($i = $time_a; $i < $time_b; $i+=$interval) {
      if ($usage) {
        if ((date('Y-m-d H:i:s', $i) <= $usage['start']) && ($usage['start'] < date('Y-m-d H:i:s', $i + $interval))) {
          $values['data'][] = 1;
          $usage['start'] = date('Y-m-d H:i:s', $i + $interval);
        }else{
          $values['data'][] = 0;
        }
        if (date('Y-m-d H:i:s', $i + $interval) >= $usage['stop']) {
          $usage = array_pop($usages);
        }
      }else{
        $values['data'][] = 0;
      }
    }
    
    return $values;
  }

  public function executeConnected(sfWebRequest $r)
  {
    $server = sfConfig::get('app_client_ip');
    $user = sfConfig::get('app_client_username');
    $pass = sfConfig::get('app_client_password');
    $url = "http://$server:8080/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_PORT, "8080");
    $content = curl_exec($ch);
    curl_close($ch);

    $pattern = "/<td><a href=\"\/cmd\?(poes[0-9]+)\&amp;show\&amp;auth\">(.+)<\/a><\/td>/i";
    preg_match_all($pattern, $content, $matches);
    $usernames = $matches[2];

    $this->customers = Doctrine_Core::getTable('Customer')->createQuery('c')
            ->whereIn('c.username', $usernames)
            ->execute();
  }

  public function executeDateCustomer(sfWebRequest $r)
  {
    $timestamp = $r->getParameter('timestamp');
    $timestamp = round($timestamp / 1000);
    $date = date('Y-m-d H:i:s', $timestamp);
    $arr = Doctrine_Core::getTable('Radacct')->createQuery('r')
            ->select('r.username')
            ->where('r.acctstarttime<=?', $date)
            ->andWhere('r.acctstoptime>=?', $date)
            ->fetchArray();
    $usernames = array();
    foreach ($arr as $v) {
      $usernames[] = $v['username'];
    }
    
    if ($usernames) {
      $this->customers = Doctrine_Core::getTable('Customer')->createQuery('c')
              ->whereIn('c.username', $usernames)
              ->execute();
    }else{
      $this->customers = array();
    }
  }
}
