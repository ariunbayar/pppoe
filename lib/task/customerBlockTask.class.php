<?php

class customerBlockTask extends sfBaseTask
{
  protected function configure()
  {
//     // add your own arguments here
//     $this->addArguments(array(
//       new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
//     ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'customer';
    $this->name             = 'block';
    $this->briefDescription = 'Un/Blocks customers when the time comes.';
    $this->detailedDescription = <<<EOF
The [customer:block|INFO] task does things.
Call it with:

  [php symfony customer:block|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $now = date('Y-m-d H:i:s');
    $dql = Doctrine_Core::getTable('Customer')->createQuery('c')
            ->where('c.next_date <= ?', $now)
            ->limit(100);
    $customers = $dql->execute();
    foreach ($customers as $customer) {
      /* @var $customer Customer */
      $next_actions = Doctrine_Core::getTable('NextAction')->createQuery('na')
              ->where('na.customer_id=?', $customer->getId())
              ->andWhere('na.date=?', $customer->getNextDate())
              ->andWhere('na.action=?', $customer->getNextAction())
              ->execute();
      if ($next_actions) {
        $next_action = $next_actions[0];
        $next_action->delete();

        $block = ($customer->getNextAction() == 'block');

        $msg = "Хэрэглэгч ".($block?'хаагдлаа':'нээгдлээ').': '.$customer->getName()."\n"
              .'Хугацаа: '.$customer->getDateTimeObject('next_date')->format('Y-m-d H:i')."\n";
        ChangeLogTable::saveNew($customer->getId(), 'customer', $msg, null);

        $radcheck = Doctrine_Core::getTable('Radcheck')->findOneByUsername($customer->getUsername());
        if (!($radcheck instanceof Radcheck)) {
          continue;
        }
        $radcheck->setAttr($block ? 'blocked' : 'Password');
        $radcheck->save();
        $this->dropUser($customer->getUsername());
        
        $customer->setIsBlocked($block);
        $customer->updateNextDateAction();
        $customer->save();
      }
    }
  }

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
    curl_close($ch);

    $pattern = "/<td><a href=\"\/cmd\?(poes[0-9]+)\&amp;show\&amp;auth\">$username<\/a><\/td>/i";
    $is_found = preg_match($pattern, $content, $matches);
    
    if ($is_found) {
      $conn = $matches[1];
      $url = "http://$server:8080/cmd?$conn&close";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_PORT, "8080");
      $content = curl_exec($ch);
      curl_close($ch);
    }
  }
}
