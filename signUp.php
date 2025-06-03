<?php // signUp.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .signup-container {
      background: #ffffff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .signup-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .signup-container input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .signup-container button {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    .signup-container button:hover {
      background-color: #45a049;
    }

    .footer {
      margin-top: 1rem;
      text-align: center;
      font-size: 14px;
    }

    .footer a {
      color: #007BFF;
      text-decoration: none;
    }

    .error {
      color: red;
      font-size: 14px;
      display: none;
      margin-top: -8px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="signup-container">
    <h2>Welcome to StudySpare<br>Sign Up</h2>
    <form id="signupForm">
      <input type="text" name="fullname" placeholder="Full Name" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="text" name="studentid" placeholder="Student ID" required>
      <input type="text" name="course" placeholder="Course" required>
      <input type="text" name="section" placeholder="Section" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" id="password" name="password" placeholder="Password" required>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
      <div id="passwordError" class="error">Passwords do not match</div>
      <button type="submit">Create Account</button>
    </form>
    <div class="footer">
      Already have an account? <a href="login.html">Login</a>
    </div>
  </div>

  <script>
    const form = document.getElementById('signupForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const errorText = document.getElementById('passwordError');

    form.addEventListener('submit', function (e) {
      if (password.value !== confirmPassword.value) {
        e.preventDefault();
        errorText.style.display = 'block';
      } else {
        errorText.style.display = 'none';
        // Redirect to login page after successful signup
        e.preventDefault();
        window.location.href = 'login.html';
      }
    });
  </script>

</body>
</html>
