<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register_process.php" method="post">
        <label for="reg_username">Username:</label>
        <input type="text" id="reg_username" name="reg_username" required><br><br>
        <label for="reg_email">Email:</label>
        <input type="email" id="reg_email" name="reg_email" required><br><br>
        <label for="reg_password">Password:</label>
        <input type="password" id="reg_password" name="reg_password" required><br><br>
        <label for="reg_verify_password">Verify Password:</label>
        <input type="password" id="reg_verify_password" name="reg_verify_password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
