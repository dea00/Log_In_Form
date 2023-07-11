<?php
  session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    .insert-form-container {
      display: none;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1946b9;">
  <div class="container-fluid">
    <h1 style="color: #ffffff; font-size: 24px; margin-top: 10px; font-family: 'Open Sans', sans-serif;">
      Welcome, <?php echo $_SESSION['fname']; ?>
    </h1>
    <?php if (isset($_GET['error'])): ?>
      <div id="error-box" class="error-box">
        <p class="error-text"><?php echo $_GET['error']; ?></p>
        <button id="dismiss-error" class="btn btn-danger">X</button>
      </div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
      <div id="success-box" class="success-box">
        <p class="success-text"><?php echo $_GET['success']; ?></p>
      </div>
    <?php endif; ?>
    <form id="insert-form-toggle" class="d-inline">
      <button type="button" class="btn btn-primary me-2" style="background-color: white; color: black;">Insert</button>
      <button id="logout-button" type="button" class="btn btn-primary" style="background-color: white; color: black;">Log Out</button>
    </form>
  </div>
</nav>

<script>
  // Hide the success box after 4 seconds
  setTimeout(function() {
    var successBox = document.getElementById('success-box');
    if (successBox) {
      successBox.style.display = 'none';
    }
  }, 4000);

    // Add event listener to dismiss button
    var dismissErrorButton = document.getElementById('dismiss-error');
  if (dismissErrorButton) {
    dismissErrorButton.addEventListener('click', function() {
      var errorBox = document.getElementById('error-box');
      if (errorBox) {
        errorBox.style.display = 'none';
      }
    });
  }
</script>


<style>
  .error-box {
    background-color: #f8d7da;
    border: 2px solid #dc3545;
    padding: 2px;
    border-radius: 5px;
    margin-bottom: -5px;
    display: flex;
    align-items: center;
  }

  .error-text {
    color: #dc3545;
    margin-bottom: 0;
    margin-left: 10px;
  }
</style>

<style>
.success-box {
    background-color: #D2EFD4;
    border: 2px solid #2C8032;
    padding: 2px;
    border-radius: 5px;
    margin-bottom: -5px;
    display: flex;
    align-items: center;
  }

  .success-text {
    color: #2C8032;
    margin-bottom: 0;
    margin-left: 10px;
  }
</style>

    <script>
    // Get the logout button element
    var logoutButton = document.getElementById('logout-button');

    // Add event listener for logout button click
    logoutButton.addEventListener('click', function() {
      // Redirect to index.php
      window.location.href = 'index.php';
    });
  </script>
<div class="container my-4">
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Password</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
        include "db_conn.php";
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        if (!$result) {
          die("Invalid query!");
        }
        while ($row = $result->fetch_assoc()) {
          echo "
          <tr>
            <th>$row[id]</th>
            <td>$row[user_name]</td>
            <td>$row[password]</td>
            <td>$row[fname]</td>
            <td>$row[lname]</td>
            <td>$row[email]</td>
            <td class='button-container'>
            <form method='POST' class='edit-form'>
              <input type='hidden' name='edit_button' value='$row[id]'>
              <button type='submit' class='btn btn-success'>Edit</button>
            </form>
            <form method='POST' class='delete-form'>
              <input type='hidden' name='delete_button' value='$row[id]'>
              <button type='submit' class='btn btn-danger' style='margin-top: 2px;'>Delete</button>
            </form>

            </td>
          </tr>
          ";
        }
      ?>
    </tbody>
  </table>
</div>


  <div id="insert-form" class="insert-form-container">
    <form method="POST" action="insert.php">
      <h1>Insert New User</h1>
      <label>User Name:</label>
      <input type="text" name="uname" class="form-control" required><br>
      <label>Email:</label>
      <input type="text" name="email" class="form-control" required><br>
      <label>Password:</label>
      <input type="text" name="password" class="form-control" required><br>
      <label>First Name:</label>
      <input type="text" name="fname" class="form-control" required><br>
      <label>Last Name:</label>
      <input type="text" name="lname" class="form-control" required><br>
      <button type="submit" id="insert-submit" class="btn btn-success">Submit</button>
      <button id="insert-form-cancel" type="button" class="btn btn-danger">Cancel</button>
    </form>
  </div>

  <div id="edit-form-container" class="insert-form-container">
    <form id="edit-form" method="POST" action="edit.php">
      <h1>Edit User</h1>
      <input type="hidden" name="id" id="edit-id" value="<?php echo $row['id']; ?>">
      <label>User Name:</label>
      <input type="text" name="uname" id="edit-uname" class="form-control" required><br>
      <label>Email:</label>
      <input type="text" name="email" id="edit-email" class="form-control" required><br>
      <label>Password:</label>
      <input type="text" name="password" id="edit-password" class="form-control" required><br>
      <label>First Name:</label>
      <input type="text" name="fname" id="edit-fname" class="form-control" required><br>
      <label>Last Name:</label>
      <input type="text" name="lname" id="edit-lname" class="form-control" required><br>
      <button type="submit" id="edit-submit" class="btn btn-primary">Submit</button>
      <button id="edit-form-cancel" type="button" class="btn btn-danger">Cancel</button>
    </form>
  </div>

  <!-- <script>
    // Get the form element
    var form = document.getElementById('insert-form');

    // Add event listener for form submit
    form.addEventListener('submit', function(event) {
      // Display an alert
      alert('Form submitted successfully!');
    });
  </script> -->

  <!-- <script>
    // Get the cancel button element
    var cancelButton = document.getElementById('insert-form-cancel');

    // Add event listener for cancel button click
    cancelButton.addEventListener('click', function() {
      // Display an alert
      alert('Cancel button clicked!');
    });
  </script> -->

  <script>
    // Handle insert form toggle
    const insertFormToggle = document.getElementById('insert-form-toggle');
      const insertForm = document.getElementById('insert-form');
      const insertFormCancel = document.getElementById('insert-form-cancel');

      insertFormToggle.addEventListener('click', () => {
        insertForm.style.display = 'block';
      });

      insertFormCancel.addEventListener('click', () => {
        insertForm.style.display = 'none';
      });

      // Handle form submission via AJAX for insert button
      const insertFormSubmit = document.getElementById('insert-submit');

      insertFormSubmit.addEventListener('click', () => {
        const form = document.getElementById('insert-form');
        const formData = new FormData(form);

        fetch('insert.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          // Handle the response from the server
          console.log(data); // You can customize this based on your requirements

          // Reload the home.php page after successful insertion
          if (data.success) {
            form.reset(); // Reset the form
            insertForm.style.display = 'none'; // Hide the form
            // Use AJAX to reload the home.php page
            fetch('home.php')
              .then(response => response.text())
              .then(html => {
                document.open();
                document.write(html);
                document.close();
              })
              .catch(error => {
                console.error('Error:', error);
              });
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
      });

      // Handle edit form toggle
      const editForms = document.getElementsByClassName('edit-form');
      const editFormContainer = document.getElementById('edit-form-container');
      const editFormCancel = document.getElementById('edit-form-cancel');

      for (const form of editForms) {
        form.addEventListener('submit', (event) => {
          event.preventDefault(); // Prevent the default form submission

          // Retrieve the row ID
          const id = form.querySelector('input[name="edit_button"]').value;

          // Hide the insert form and display the edit form container
          const insertForm = document.getElementById('insert-form');
          insertForm.style.display = 'none';
          editFormContainer.style.display = 'block';

          // Populate the edit form with existing data
          const userName = form.parentNode.parentNode.querySelector('td:nth-child(2)').textContent;
          const password = form.parentNode.parentNode.querySelector('td:nth-child(3)').textContent;
          const firstName = form.parentNode.parentNode.querySelector('td:nth-child(4)').textContent;
          const lastName = form.parentNode.parentNode.querySelector('td:nth-child(5)').textContent;
          const email = form.parentNode.parentNode.querySelector('td:nth-child(6)').textContent;

          document.getElementById('edit-id').value = id;
          document.getElementById('edit-uname').value = userName;
          document.getElementById('edit-password').value = password;
          document.getElementById('edit-fname').value = firstName;
          document.getElementById('edit-lname').value = lastName;
          document.getElementById('edit-email').value = email;
        });
      }

      // Handle edit form submission via AJAX
      const editFormSubmit = document.getElementById('edit-submit');

      editFormSubmit.addEventListener('click', () => {
        const editForm = document.getElementById('edit-form');
        const editFormData = new FormData(editForm);

        fetch('edit.php', {
          method: 'POST',
          body: editFormData
        })
          .then(response => response.json())
          .then(data => {
            // Handle the response from the server
            console.log(data); // You can customize this based on your requirements

            // Reload the home.php page after successful update
            if (data.success) {
              editForm.reset(); // Reset the form
              editFormContainer.style.display = 'none'; // Hide the edit form container
              // Use AJAX to reload the home.php page
              fetch('home.php')
                .then(response => response.text())
                .then(html => {
                  document.open();
                  document.write(html);
                  document.close();
                })
                .catch(error => {
                  console.error('Error:', error);
                });
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });

      // Handle edit form cancel button click
      editFormCancel.addEventListener('click', () => {
        editFormContainer.style.display = 'none';
      });


      // Handle form submission via AJAX for delete button
      const deleteForms = document.getElementsByClassName('delete-form');

      for (const form of deleteForms) {
        form.addEventListener('submit', (event) => {
          event.preventDefault(); // Prevent the default form submission

          const formData = new FormData(form);

          // Display the confirmation popup
          const confirmation = confirm('Are you sure you want to delete this entry?');

          if (confirmation) {
            fetch('delete.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              // Handle the response from the server
              console.log(data); // You can customize this based on your requirements

              // Reload the page after successful deletion
              if (data.success) {
                location.reload();
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });
          }
        });
      }
    </script>
    </body>
    </html>