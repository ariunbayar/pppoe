<?php
/* die if not allowed ip */
$my_ip = '192.168.1.100';
$allowed_ips = array($my_ip, '127.0.0.1');
$remote_ip = $_SERVER["REMOTE_ADDR"];
if (!in_array($remote_ip, $allowed_ips)) die('error');

/* die if invalid token */
$allowed_token = 'L7EbhniYjNeph0viU56Y';
$token = $_GET['token'];
if ($token != $allowed_token) die('error');

$command = "ifconfig | grep -o 'inet 172.24.0.1' | wc -l";
$n = exec($command);
echo $n;
