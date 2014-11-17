<?php

require_once('config.php');

echo '
<html>
<title>New User</title>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script src="login.js"></script>
</head>
<body>
';



echo '
<form class="form-horizontal" id="login_form" name="login_form">
<fieldset>

<!-- Form Name -->
<legend>Log In</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">Email</label>
  <div class="controls">
    <input id="email" name="email" placeholder="" class="input-xlarge" type="text">

  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="password">Password</label>
  <div class="controls">
    <input id="password" name="password" placeholder="" class="input-xlarge" type="password">

  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="login"></label>
  <div class="controls">
    <button id="login_btn" name="login_btn" class="btn btn-primary">Log In</button>
	<img id="loading_gif" src="/css/big_loading.gif" style="height:12px; display:none;">		
  </div>
</div>

</fieldset>
<div name="login_info" id="login_info"></div>
</form>

</body>			
';




?>