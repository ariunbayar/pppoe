<?php
class tools
{
  public static function translateRoles($role, $separator = ', ')
  {
    $role = trim($role);
    if (empty($role)) return '';
    
    $values = explode(',', $role);
    $roles = sfConfig::get('app_roles');
    $names = '';
    foreach ($values as $i =>  $v) {
      if (isset($roles[$v])) {
        $names .= ($i ? $separator : '').$roles[$v];
      }
    }
    return $names;
  }

  public static function ip2bandwidth($ip)
  {
    $ips = explode('.', $ip);
    $iprange = "$ips[0].$ips[1].";
    $bandwidth = Doctrine_Core::getTable('Bandwidth')->findOneByIpaddress($iprange);
    if (!($bandwidth instanceof Bandwidth)) return false;

    return $bandwidth->getBandwidth();
  }
}