<?php 

require_once('config.php');

$client = new GuzzleHttp\Client();
$response = $client->get(OWLY_BASE_URL);
$testShortUrl = "http://ow.ly/1234";
$request = $client->createRequest('GET', OWLY_BASE_URL.'url/info');
$query = $request->getQuery();
$query->set('apiKey', OWLY_API_KEY);
$query->set('shortUrl', $testShortUrl);
$res = $client->send($request);
var_dump($res->json());



?>