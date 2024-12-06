<?php
session_start();
require_once 'db_connection.php';
require_once 'utils/auth.php';
if (isset($_SESSION['user_id'])) {
  redirect('/home/index.php');
} else {
  redirect('/auth/login.php');
}
