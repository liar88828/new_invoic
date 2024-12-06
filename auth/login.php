<?php
session_start();
require_once '../db_connection.php';
require_once '../utils/auth.php';

if (is_logged_in()) {
  redirect('../index.php');
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = sanitize_input($_POST['username']);
  $password = $_POST['password'];

  if (empty($username) || empty($password)) {
    $error = "Please enter both username and password.";
  } else {
    try {
      $database = new Database();
      $conn = $database->connect();

      $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
      $stmt->execute(['username' => $username]);

      if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          redirect('../index.php');
        } else {
          $error = "Invalid username or password.";
        }
      } else {
        $error = "Invalid username or password.";
      }
    } catch (PDOException $e) {
      $error = "Login failed: " . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Login</h2>
          <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>

                <a href="register.php" class="btn btn-info">Register</a>

                <a href="../home/index.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>