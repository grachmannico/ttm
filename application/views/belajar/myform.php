<html>
	<head>
		<title>
			My Form
		</title>
	</head>
	<body>
		<?php echo validation_errors(); ?>
		<?php echo form_open('form'); ?>
		<h5>
			Username
		</h5>
		<input name="username" size="50" type="text" value=""/>
		<h5>
			Password
		</h5>
		<input name="password" size="50" type="text" value=""/>
		<h5>
			Password Confirm
		</h5>
		<input name="passconf" size="50" type="text" value=""/>
		<h5>
			Email Address
		</h5>
		<input name="email" size="50" type="text" value=""/>
		<div>
			<input type="submit" value="Submit"/>
		</div>
		</form>
	</body>
</html>
