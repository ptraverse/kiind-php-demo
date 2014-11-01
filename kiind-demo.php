<?php 

require_once('config.php');

$owly = new Owly();
$testShortUrl = "http://ow.ly/1234";
var_dump($owly->url_info($testShortUrl));exit;




?>