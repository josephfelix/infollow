<?php
$ch = curl_init('http://ifconfig.me');

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => true,
    CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
    CURLOPT_PROXY => 'socks5://127.0.0.1:9150'
]);

echo curl_exec($ch);

curl_close($ch);