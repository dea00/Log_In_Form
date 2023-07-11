<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php
		$showLoginForm = true;
		$showSignupForm = false;

		if (isset($_GET['signup'])) {
			$showLoginForm = false;
			$showSignupForm = true;
		}
	?>

<?php if ($showLoginForm): ?>
    <form action="login.php" method="post">
        <h2>LOGIN</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php endif; ?>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>
        <div class="or-text">
            <span>or</span>
        </div>
        <a href="?signup=true" style="text-align: center;">Sign-up</a>
    </form>
<?php endif; ?>


	<?php if ($showSignupForm): ?>
		<form action="sign_up.php" method="post">
			<h2>SIGN-UP</h2>
			<?php if (isset($_GET['error'])) { ?>
				<p class="error"><?php echo $_GET['error']; ?></p>
			<?php } ?>
			<label>Name</label>
			<input type="text" name="fname" placeholder="First Name"><br>

			<label>Last Name</label>
			<input type="text" name="lname" placeholder="Last Name"><br>

			<label>User Name</label>
			<input type="text" name="uname" placeholder="User Name"><br>

			<label>Email</label>
			<input type="text" name="email" placeholder="Email"><br>

			<label>Password</label>
			<input type="password" name="password" placeholder="Password"><br>

			<button type="submit">SIGN-UP!</button>
		</form>
	<?php endif; ?>
</body>
</html>