<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

$kas = new KiindApiService($session);
$kas->getAuthRedirect();

exit;


?>