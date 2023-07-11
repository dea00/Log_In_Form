<?php
session_start();
include "db_conn.php";

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['password'])) {
    // Validate and sanitize the form data
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $fname = validate($_POST['fname']);
    $lname = validate($_POST['lname']);
    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // Perform additional validation if required
    if (empty($fname)) {
		header("Location: http://localhost/login/index.php?signup=true&error=First%20Name%20is%20required");
	    exit();
	}else if(empty($lname)){
        header("Location: http://localhost/login/index.php?signup=true&error=Last%20Name%20is%20required");
	    exit();
	}else if(empty($uname)){
        header("Location: http://localhost/login/index.php?signup=true&error=User%20Name%20is%20required");
	    exit();
	}else if(empty($email)){
        header("Location: http://localhost/login/index.php?signup=true&error=Email%20is%20required");
	    exit();
	}else if(empty($password)){
        header("Location: http://localhost/login/index.php?signup=true&error=Password%20is%20required");
	    exit();
	}else{

        $check_query = "SELECT * FROM users WHERE user_name='$uname' AND email='$email' LIMIT 1";
        $check_result = mysqli_query($conn, $check_query);
        $user = mysqli_fetch_assoc($check_result);

        if ($user){
            // USER ALREADY EXISTS
            header("Location: index.php?signup=true&error=User%20already%20exists.%20Please%20log%20in%20<a href='login.php'>log in</a>...");
            exit();
        }else{
            // Insert the user into the database
            $sql = "INSERT INTO users (fname, lname, user_name, email, password) VALUES ('$fname', '$lname', '$uname', '$email', '$password')";

            if (mysqli_query($conn, $sql)) {
                // Sign-up successful
                header("Location: index.php?success=Sign-up%20successful!%20You%20can%20now%20log%20in");
                exit();
            } else {
                // Sign-up failed, handle the error appropriately
                header("Location: index.php?signup=true&error=Sign-up failed");
                echo "Error: " . mysqli_error($conn);
                exit();
            }
        }
    }
} else {
    // Redirect back to the index page if the form data is not set
    header("Location: index.php");
    exit();
}
?>
