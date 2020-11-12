<?php
require_once('model/admin.php');
if (! empty($_POST["login-btn"])) {
    $admin = new admin();
    $loginResult = $admin->loginAdmin();}
?>
<HTML>
<HEAD>
<TITLE>Login</TITLE>
<link href="css/login.css" type="text/css" rel="stylesheet" />
<link href="css/user-registration.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
	<div class="whole-container">
		<div class="sign-up-container">
			<div class="signup-align">
				<form name="login" action="" method="post"
					onsubmit="return loginValidation()">
          <div class="login-signup">
            <a href="index.php">Login</a>
          </div>
					<div class="signup-heading">Admin Login</div>
				<?php if(!empty($loginResult)){?>
				<div class="error-msg"><?php echo $loginResult;?></div>
				<?php }?>
				<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Admin id<span class="required error" id="adminname-info"></span>
							</div>
							<input class="input-box-330" type="text" name="adminname"
								id="adminname">
						</div>
					</div>
					<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Password<span class="required error" id="admin-password-info"></span>
							</div>
							<input class="input-box-330" type="password"
								name="admin-password" id="admin-password">
						</div>
					</div>
					<div class="row">
						<input class="btn" type="submit" name="login-btn"
							id="login-btn" value="Admin Login">
					</div>
				</form>
			</div>

		</div>
	</div>
</BODY>
</HTML>
