<?php
$access_token = 'EZhc3qkbHr8CzNimKi8y3eZbY+C897upwPu/0Np+4I1XhliJCxBVY9oCjPgAB9SXA69lnCGL/O7Qw+81fWTeJJyeQShqZDNXBjFU1VGPJ0XeIGXVS7DFD197JIBBcyUzfMuVj5gjKqm2F2amX+mj/AdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;