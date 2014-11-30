<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

$link_id = $_REQUEST['link_id'];
$user_id = $_REQUEST['user_id'];

$link = $em->getRepository('Link')->find($link_id);
$link->date_updated = new DateTime(); 
$link->clicks = '0';

$em->persist($link);
$em->flush();