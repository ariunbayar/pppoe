<?php

class configureIpTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'configure';
    $this->name             = 'ip';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [configure:ip|INFO] task does things.
Call it with:

  [php symfony configure:ip|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $in_progress = ConfigTable::getConfig('renew_ipsetting') == 1;
    if (!$in_progress) return;

    ConfigTable::setConfig('renew_ipsetting', 0);

    $ip_address = ConfigTable::getConfig('ip_address');
    $dns = ConfigTable::getConfig('dns');
    $subnet = ConfigTable::getConfig('subnet');
    $gateway = ConfigTable::getConfig('gateway');

    // change app.yml (ip address)
    $app_yml = ConfigTable::getConfig('app.yml');
    $content = file_get_contents($app_yml);
    $from = '/  client_ip: +[\'"][0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}[\'"]/';
    $to = '  client_ip: "'.$ip_address.'"';
    file_put_contents($app_yml, preg_replace($from, $to, $content));

    // change users.php (ip address)
    $users_php = ConfigTable::getConfig('users.php');
    $content = file_get_contents($users_php);
    $from = '/\$my_ip += +[\'"][0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}[\'"]/';
    $to = '$my_ip = "'.$ip_address.'"';
    file_put_contents($app_yml, preg_replace($from, $to, $content));

    // change mpd.conf (ip address, dns)
    $mpd_conf = ConfigTable::getConfig('mpd.conf');
    $content = file_get_contents($mpd_conf);
    $from = "/set web ip [0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/";
    $to = "set web ip ".$ip_address;
    $content = preg_replace($from, $to, $content);
    $from = "/set ipcp dns [0-9 .]+/";
    $to = "set ipcp dns ".$dns;
    $content = preg_replace($from, $to, $content);
    file_put_contents($mpd_conf, $content);

    // change rc.conf (ip address, subnet mask, gateway)
    $rc_conf = ConfigTable::getConfig('rc.conf');
    $content = file_get_contents($rc_conf);
    $from = '/defaultrouter=[\'"][0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}[\'"]/';
    $to = 'defaultrouter="'.$gateway.'"';
    $content = preg_replace($from, $to, $content);
    $from = '/ifconfig_em0="inet +[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3} +netmask +[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}"/';
    $to = 'ifconfig_em0="inet '.$ip_address.' netmask '.$subnet.'"';
    $content = preg_replace($from, $to, $content);
    file_put_contents($rc_conf, $content);

    $cache_dir = sfConfig::get('sf_cache_dir');
    $cache = new sfFileCache(array('cache_dir' => $cache_dir));
    $cache->clean();

    exec('reboot');
  }
}
