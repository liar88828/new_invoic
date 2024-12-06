<?php
session_start();
require_once '../db_connection.php';
require_once '../utils/auth.php';

if(is_logged_in()) {
  redirect('../index.php');
}

$error = '';
$success = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = sanitize_input($_POST['username']);
  $email = sanitize_input($_POST['email']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $error = "All fields are required.";
  } elseif($password !== $confirm_password) {
    $error = "Passwords do not match.";
  } else {
    try {
      $database = new Database();
      $conn = $database->connect();

      // Check if username or email already exists
      $check_stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
      $check_stmt->execute(['username' => $username, 'email' => $email]);

      if($check_stmt->rowCount() > 0) {
        $error = "Username or email already exists.";
      } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
          'username' => $username,
          'email' => $email,
          'password' => $hashed_password
        ]);

        $success = "Registration successful! You can now login.";
        redirect('/auth/login.php');
      }
    } catch(PDOException $e) {
      $error = "Registration failed: " . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="text-center">Register</h2>
      <?php if(!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      <?php if(!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>
      <form method="POST" action="">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="../auth/login.php" class="btn btn-secondary">Back</a>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>