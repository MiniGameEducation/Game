<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Rätsel</title>
    <link rel="stylesheet" href="form-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
        <form action="../database/register_process.php" method="post" enctype="multipart/form-data">
    <h1>Create Account</h1>
    <span>or use your email for registration</span>
    <input type="text" placeholder="Name" name="reg_username" required>
    <input type="email" placeholder="Email" name="reg_email" required>
    <input type="password" placeholder="Password" name="reg_password" required>
    <input type="password" placeholder="Verify Password" name="reg_verify_password" required>
    <label for="file-upload" class="file-input-button">Choose File For Profile Photo</label>
    <input type="file" name="foto" id="file-upload">
    <span id="file-name">No file chosen</span>
    <input type="submit" value="Sign Up" name="submit">
</form>

        </div>
        <div class="form-container sign-in">
            <form action="../database/login_process.php" method="post">
                <h1>Sign In</h1>
                <span>or use your email for login</span>
                <input type="text" placeholder="Name" name="username" required>
                <input type="password" placeholder="Password" name="password" required>
                <a href="">Forgot Your Password?</a>
                <input type="submit" value="Sign In" name="submit">
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back</h1>
                    <p>
                        Enter your personal details to use all of site features
                    </p>
                    <input type="submit" class="hidden" value="Sign In" id="login" name="signin">
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>
                        Register with your personal details to use all of site features
                    </p>
                    <input type="submit" class="hidden" value="Sign Up" id="register" name="signup">
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            const container = document.getElementById('container');
            const registerBtn = document.getElementById('register');
            const loginBtn = document.getElementById('login');
            const fileUpload = document.getElementById('file-upload');
            const fileName = document.getElementById('file-name');

            registerBtn.addEventListener('click', () => {
                container.classList.add('active');
            });

            loginBtn.addEventListener('click', () => {
                container.classList.remove('active');
            });

            fileUpload.addEventListener('change', () => {
                fileName.textContent = fileUpload.files[0].name;
            });
        </script>
    </div>
</body>

</html>
