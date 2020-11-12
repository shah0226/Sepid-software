<?php
require_once('model/user.php');
if (isset($_POST["login-btn"])) {
    $user = new user();
    $loginResult = $user->loginUser();}
?>
<HTML>
<HEAD>
<TITLE>Login</TITLE>
<link href="css/login.css" type="text/css" 	rel="stylesheet" />
<link href="css/user-registration.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
	<div class="whole-cnotainer">
		<div class="sign-up-container">
			<div class="login-signup">
				<a href="user-registration.php">Sign up</a>
			</div>
      <div class = "admin">
        <a href="admin_login.php">Admin Login</a>
      </div>
			<div class="signup-align">
				<form name="login" action="" method="post"
					onsubmit="return loginValidation()">
					<div class="signup-heading">Login</div>
				<?php if(!empty($loginResult)){?>
				<div class="error-msg"><?php echo $loginResult;?></div>
				<?php }?>
				<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Username<span class="required error" id="username-info"></span>
							</div>
							<input class="input-box-330" type="text" name="username"
								id="username">
						</div>
					</div>
					<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Password<span class="required error" id="login-password-info"></span>
							</div>
							<input class="input-box-330" type="password"
								name="login-password" id="login-password">
						</div>
					</div>
					<div class="row">
						<input class="btn" type="submit" name="login-btn"
							id="login-btn" value="Login">
					</div>
				</form>
			</div>

		</div>
	</div>


</BODY>
</HTML>
