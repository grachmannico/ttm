<html>
	<head>
		<title>
			Form Login
		</title>
	</head>
	<body>
		<?php echo validation_errors(); ?>
		<?php echo form_open('login/auth'); ?>
		<h5>
			Username
		</h5>
		<input type="name" name="username" size="50" type="text" value=""/>
		<h5>
			Password
		</h5>
		<input type="password" name="password" size="50" type="text" value=""/>
		<div>
			<input type="submit" value="Submit"/>
		</div>
		</form>
	</body>
</html>
