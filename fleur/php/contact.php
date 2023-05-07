<!DOCTYPE html>
<html>
<head>
	<title>Contact Us</title>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/contact.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<h1>Contact Us</h1>
	</header>
	<main>
		<form method="post" action="submit.php">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" required>
			
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
			
			<label for="message">Message:</label>
			<textarea id="message" name="message" required></textarea>
			
			<input type="submit" value="Send">
		</form>
	</main>
	<footer>
		<p>Copyright © 2023</p>
	</footer>
</body>
</html>