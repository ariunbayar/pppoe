<?php

class customerUsageTask extends sfBaseTask
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

    $this->namespace        = 'customer';
    $this->name             = 'usage';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [customer:usage|INFO] task does things.
Call it with:

  [php symfony customer:usage|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    set_time_limit(0);
    $begin_time = time();

    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $radaccts = Doctrine_Core::getTable('Radacct')->createQuery('ra')
            ->where('ra.processed=0')
            ->andWhere('ra.acctstoptime IS NOT NULL')
            ->limit(10)
            ->execute();
    foreach ($radaccts as $radacct)
    {
      /* @var $radacct Radacct */
      $radacct->setProcessed(true);
      $radacct->save();
      $start = $radacct->getDateTimeObject('acctstarttime')->format('U');
      $n = $radacct->getAcctsessiontime();
      if ($n == 0) continue;
      $customer = $radacct->getCustomer();
      $input = round($radacct->getAcctinputoctets() * 8 / ($n * 1024));
      $output = round($radacct->getAcctoutputoctets() * 8 / ($n * 1024));

      $k = $start % 60; // floor the time to zero second
      $start -= $k; 
      $n += $k;

      $total_usages = Doctrine_Core::getTable('TotalUsage')->createQuery('tu')
              ->where('tu.created_at>=?', date('Y-m-d H:i:s', $start - 1))
              ->andWhere('tu.created_at<=?', date('Y-m-d H:i:s', $start + $n))
              ->orderBy('tu.created_at ASC')
              ->execute();
      $l = 0;
      while ($n > 0) {
        $date = date('Y-m-d H:i:s', $start);

        $tusage = $total_usages[$l];
        if ($tusage->getCreatedAt() == $date) {
          $tusage->setCount($tusage->getCount() + 1);
          $tusage->setInputBits($tusage->getInputBits() + $input);
          $tusage->setOutputBits($tusage->getOutputBits() + $output);
          $tusage->save();
          if (count($total_usages) - 1 > $l) $l++;
        }else{
          $tusage = new TotalUsage();
          $tusage->setCount(1);
          $tusage->setInputBits($input);
          $tusage->setOutputBits($output);
          $tusage->setCreatedAt($date);
          $tusage->save();
        }
        $n -= 60;
        $start += 60;
        unset($tusage, $date);
      }
      unset($customer, $total_usages);
    }

    echo "total time:\t".(time() - $begin_time);
  }
}
