<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Zoo Application</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Register</h2>
	</div>

	<form method="post" action="register.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo $email; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" minlength="8" required name="password_1">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" minlength="8" required name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_user" value="Visitor">Register Visitor</button>
            <button type="submit" class="btn" name="register_user" value="Staff">Register Staff</button>
		</div>
		<p>
			Already a member? <a href="index.php">Sign in</a>
		</p>
	</form>
</body>
</html>