<?php

require_once('config.php');

$kas = new KiindApiService($session);
$kas->getAuthRedirect();

exit;


?>