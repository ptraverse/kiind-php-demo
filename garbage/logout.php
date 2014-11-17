<?php

require_once('config.php');

Sentry::logout();

header("HTTP/1.1 302 Found");
header("Location: /");