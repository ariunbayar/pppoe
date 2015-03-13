<?php
/* die if not allowed ip */
//$allowed_ips = array('10.10.38.43', '127.0.0.1');
//$remote_ip = $_SERVER["REMOTE_ADDR"];
//if (!in_array($remote_ip, $allowed_ips)) die('error');

/* die if invalid token */
$allowed_token = 'L7EbhniYjNeph0viU56Y';
$token = $_GET['token'];
if ($token != $allowed_token) die('error');

$ip = trim($_GET['ip']);
$ip = escapeshellarg($ip);
if (strlen($ip) == 0) die('invalid');

$command = "ifconfig | grep -B 2 -A 1 $ip | grep -o 'Opened by PID [0-9]*' | cut -c15-";
$pid = exec($command);
$pid = (int)$pid;

/* die if no pid found */
if (!$pid) die('invalid');

$file = 'pid.txt';
file_put_contents($file, $pid, LOCK_EX);

while (trim(file_get_contents($file)) != 'done') {
  sleep(2);
}

echo 'ok';