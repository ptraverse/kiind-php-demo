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
<script src="register.js"></script>
</head>
<body>
';

echo '
<form name="new_user_form" id="new_user_form" class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>New User</legend>

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

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="confirm_password">Confirm Password</label>
  <div class="controls">
    <input id="confirm_password" name="confirm_password" placeholder="" class="input-xlarge" type="password">
    
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="register"></label>
  <div class="controls">
    <button id="register" name="register" class="btn btn-primary" >Register</button>
	<img id="loading_gif" src="/css/big_loading.gif" style="height:12px; display:none;">		
  </div>
</div>

</fieldset>
<div id="new_user_info" name="new_user_info"></div>
</form>
		
</body>		
';

?>