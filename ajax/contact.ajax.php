<?php 

require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

$email = $_REQUEST['email'];
$contact_message = $_REQUEST['contact_message'];
$attachment = $_REQUEST['attachment'];

//swiftmail
$transport = Swift_SendmailTransport::newInstance('/usr/bin/mail -t');
$mailer = Swift_Mailer::newInstance($transport);
$message = Swift_Message::newInstance() 
  // Give the message a subject
  ->setSubject('New Message from Quidprize Contact Page')
  // Set the From address with an associative array
  ->setFrom(array($email))
  // Set the To addresses with an associative array
  ->setTo(array('philippe.traverse@gmail.com'))
  // Give it a body
  ->setBody($email);
$result = $mailer->send($message);


echo "<strong>Email Sent!</strong> Thanks for keeping in touch - we'll get back to you ASAP.<br>
				";
var_dump($_REQUEST);