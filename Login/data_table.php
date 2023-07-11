<?php
// Connect to the MySQL database
$conn = mysqli_connect("localhost", "username", "password", "login");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user data from the database
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is for editing or deleting a user
    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $edit_fname = $_POST['edit_fname'];
        $edit_lname = $_POST['edit_lname'];
        $edit_uname = $_POST['edit_uname'];
        $edit_email = $_POST['edit_email'];
        
        // Process the edit form submission and update the user in the database
        $update_query = "UPDATE users SET fname='$edit_fname', lname='$edit_lname', uname='$edit_uname', email='$edit_email' WHERE id='$edit_id'";
        if (mysqli_query($conn, $update_query)) {
            // Update successful
            header("Location: data_table.php");
            exit();
        } else {
            // Update failed, handle the error appropriately
            echo "Error: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        
        // Process the delete form submission and remove the user from the database
        $delete_query = "DELETE FROM users WHERE id='$delete_id'";
        if (mysqli_query($conn, $delete_query)) {
            // Deletion successful
            header("Location: data_table.php");
            exit();
        } else {
            // Deletion failed, handle the error appropriately
            echo "Error: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['new_fname']) && isset($_POST['new_lname']) && isset($_POST['new_uname']) && isset($_POST['new_email'])) {
        $new_fname = $_POST['new_fname'];
        $new_lname = $_POST['new_lname'];
        $new_uname = $_POST['new_uname'];
        $new_email = $_POST['new_email'];
        
        // Process the insert form submission and add a new user to the database
        $insert_query = "INSERT INTO users (fname, lname, uname, email) VALUES ('$new_fname', '$new_lname', '$new_uname', '$new_email')";
        if (mysqli_query($conn, $insert_query)) {
            // Insertion successful
            header("Location: datatable.php");
            exit();
        } else {
            // Insertion failed, handle the error appropriately
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>User Data</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['uname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="edit_fname" value="<?php echo $row['fname']; ?>">
                            <input type="text" name="edit_lname" value="<?php echo $row['lname']; ?>">
                            <input type="text" name="edit_uname" value="<?php echo $row['uname']; ?>">
                            <input type="text" name="edit_email" value="<?php echo $row['email']; ?>">
                            <button type="submit">Save</button>
                        </form>
                        <form method="post" action="">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Insert Form -->
    <h2>Add User</h2>
    <form method="post" action="">
        <input type="text" name="new_fname" placeholder="First Name">
        <input type="text" name="new_lname" placeholder="Last Name">
        <input type="text" name="new_uname" placeholder="User Name">
        <input type="text" name="new_email" placeholder="Email">
        <button type="submit">Add User</button>
    </form>
</body>
</html>