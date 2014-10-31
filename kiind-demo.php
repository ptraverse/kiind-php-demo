<?php 

require_once('config.php');

$client = new GuzzleHttp\Client();
$response = $client->get('http://guzzlephp.org');
$res = $client->get('https://api.github.com/user', ['auth' =>  ['ptraverse', 'hmuxJVH4']]);
echo $res->getStatusCode();
// "200"
echo $res->getHeader('content-type');
// 'application/json; charset=utf8'
echo $res->getBody();
// {"type":"User"...'
var_export($res->json());
// Outputs the JSON decoded data

// Send an asynchronous request.
$req = $client->createRequest('GET', 'http://httpbin.org', ['future' => true]);
$client->send($req)->then(function ($response) {
	echo 'I completed! ' . $response;
});

?>