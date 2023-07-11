<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  $id = $_POST['id'];
  $uname = $_POST['uname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];

  // Update the record in the database
  $sql = "UPDATE users SET user_name='$uname', email='$email', password='$password', fname='$fname', lname='$lname' WHERE id='$id'";
  $result = $conn->query($sql);

  if ($result) {
    // Redirect back to home.php with success message
    header("Location: home.php?success=Record updated successfully");
    exit();
  } else {
    // Redirect back to home.php with error message
    header("Location: home.php?error=Failed to update record");
    exit();
  }
} else {
  // If the request method is not POST, redirect back to home.php
  header("Location: home.php");
  exit();
}
?>
