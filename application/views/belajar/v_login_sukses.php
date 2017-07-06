<html>
	<head>
		<title>
			Form Login
		</title>
	</head>
	<body>
		<?php echo validation_errors(); ?>
		<?php echo form_open('login/logout'); ?>
		<h5>
			Login Sukses
		</h5>
		<div>
			<input type="submit" value="Logout"/>
		</div>		
		</form>
	</body>
</html>
