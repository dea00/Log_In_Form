<?php
include "db_conn.php";

if (isset($_POST['delete_button'])) {
  $id = $_POST['delete_button'];

  // Delete the entry from the database
  $deleteSql = "DELETE FROM users WHERE id = '$id'";
  $result = $conn->query($deleteSql);

  if ($result) {
    // Entry deleted successfully
    echo json_encode(['success' => true, 'message' => 'Entry deleted successfully']);
  } else {
    // Failed to delete the entry
    echo json_encode(['success' => false, 'message' => 'Failed to delete the entry']);
  }
}
?>