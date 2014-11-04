<?php

require_once('./config.php');

session_start();
echo '<h1>Its Alive!</h1>';
print_r($_SESSION);
?>