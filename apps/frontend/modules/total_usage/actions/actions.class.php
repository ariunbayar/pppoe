<?php

/**
 * total_usage actions.
 *
 * @package    pppoe
 * @subpackage total_usage
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class total_usageActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
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
    $date = $r->getParameter('date');
    $hour = (int)$r->getParameter('hour');
    $minute = (int)$r->getParameter('minute');
    $duration = $this->getRequestParameter('duration');

    $interval = 60;
    $time_a = 0;
    $time_b = 0;
    $this->calculateDuration($date, $hour, $minute, $duration, $time_b, $time_a, $interval);

    $values = $this->retrieveUsage($duration, $time_a, $time_b, $interval);

    return $this->renderText(json_encode($values));
  }

  public function executeLoadPrev(sfWebRequest $r)
  {
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

    $values = $this->retrieveUsage($duration, $time_a, $time_b, $interval);

    $all_values = array(
      array($date, $hour, $minute),
      $values
    );

    return $this->renderText(json_encode($all_values));
  }

  public function executeLoadNext(sfWebRequest $r)
  {
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

    $values = $this->retrieveUsage($duration, $time_a, $time_b, $interval);

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

  private function retrieveUsage($duration, $time_a, $time_b, $interval)
  {
    $dql = Doctrine_Core::getTable('TotalUsage')->createQuery('tu')
            ->select('tu.count, tu.created_at as date')
            ->where('tu.created_at>?', date('Y-m-d H:i:s', $time_a))
            ->andWhere('tu.created_at<?', date('Y-m-d H:i:s', $time_b))
            ->orderBy('tu.created_at ASC');
    $usages = $dql->fetchArray();

    $tmp = array();
    foreach ($usages as $usage) {
      $key = round(strtotime($usage['date']) / $interval);
      if (isset($tmp[$key])) {
        $tmp[$key] = array(
          'number'  => $tmp[$key]['number'] + 1,
          'count'      => $tmp[$key]['count'] + $usage['count'],
        );
      }else{
        $tmp[$key] = array(
          'number'  => 1,
          'count'   => $usage['count']
        );
      }
    }

    $a = floor($time_a / $interval);
    $b = floor($time_b / $interval);
    $values = array(
      'type' => 'area',
      'name' => 'хэрэглэгчид',
      'pointInterval' => $interval * 1000,
      'pointStart' => ($time_a + (int)date('Z')) * 1000,
      'data' => array()
    );
    for ($i = $a; $i < $b; $i++) {
      if (isset($tmp[$i])) {
        $values['data'][] = round($tmp[$i]['count'] / $tmp[$i]['number']);
      }else{
        $values['data'][] = 0;
      }
    }

    return $values;
  }
}
