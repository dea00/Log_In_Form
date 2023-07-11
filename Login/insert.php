<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $uname = $_POST["uname"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];

  // Check if the user already exists
  $sql = "SELECT * FROM users WHERE user_name = '$uname' AND email = '$email'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    // Duplicate entry found
    header("Location: home.php?insert=true&error=Duplicate%20entry%20found.%20Please%20provide%20unique%20user%20name%20and%20email.");
    exit();
  } else {
    // Insert the user into the database
    $sql = "INSERT INTO users (fname, lname, user_name, email, password) VALUES ('$fname', '$lname', '$uname', '$email', '$password')";
    
    if (mysqli_query($conn, $sql)) {
      // Sign-up successful
      header("Location: home.php");
      header("Location: home.php?insert=true&success=Entry%20added%20successfully.");
      exit();
    } else {
      // Sign-up failed, handle the error appropriately
      header("Location: home.php?insert=true&error=Insertion%20failed");
      echo "Error: " . mysqli_error($conn);
      exit();
    }
  }
}
?>