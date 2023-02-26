<?php
session_start();
include('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM perdoruesit WHERE email_adresa='$email'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['fjalekalimi'])) {
      $_SESSION['email'] = $email;
      $_SESSION['name'] = $row['emri'];
      header('location:../index.php');
    } else {
      $_SESSION['message'] = 'Invalid email or password';
      header('location:login.php');
    }
  } else {
    $_SESSION['message'] = 'Invalid email or password';
    header('location:login.php');
  }
}