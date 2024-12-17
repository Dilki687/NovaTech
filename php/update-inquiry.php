<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $sql = "UPDATE inquiries SET name='$name', email='$email', phone='$phone', subject='$subject', message='$message' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Inquiry updated successfully.";
            header('Location: view-inquiries.php');
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Fetch existing inquiry data
        $sql = "SELECT * FROM inquiries WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Inquiry</title>
    <link rel="stylesheet" href="../styles/update-form.css">
</head>
<body>
    <div class="update-container">
        <h2>Update Inquiry</h2>
        <form method="POST" class="update-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required />

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required />

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required />

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($row['subject']); ?>" required />

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required><?php echo htmlspecialchars($row['message']); ?></textarea>

            <button type="submit" class="btn-submit">Update</button>
        </form>
    </div>
</body>
</html>
