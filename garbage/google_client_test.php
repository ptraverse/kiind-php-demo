<?php

require_once('./config.php');

$client = new Google_Client();
$client->setApplicationName("Client_Library_Examples");
$client->setDeveloperKey("FOOBAR");

$service = new Google_Service_Urlshortener($client);

$url = new Google_Service_Urlshortener_Url();

$url->longUrl = 'http://192.168.1.19:8080/r/1/1';
$shortUrl = $service->url->insert($url);
var_dump($shortUrl['id']);

?>