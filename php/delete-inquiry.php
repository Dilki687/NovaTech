<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM inquiries WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Inquiry deleted successfully.";
        header('Location: view-inquiries.php'); // Redirect to the inquiries page
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
