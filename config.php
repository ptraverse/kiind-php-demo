<?php
require 'vendor/autoload.php';

//Define OWLY_API_KEY and OWLY_BASE_URL
$owly_api_key_file = file_get_contents("./private/owly_api_key.json");
$owly_api_key_array = json_decode($owly_api_key_file, TRUE);
define("OWLY_API_KEY",(string)($owly_api_key_array['owly_api_key']));
define("OWLY_BASE_URL",(string)($owly_api_key_array['base_url']));

