<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare the SQL query to check for the username
        $sql = "SELECT * FROM users WHERE username = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the username parameter
            $stmt->bind_param("s", $username); // "s" stands for string

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Check if the username exists
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verify the hashed password
                if (password_verify($password, $user['password'])) {
                    // Redirect to the index page after successful login
                    header("Location: ../Home.html");
                    exit();
                } else {
                    // Show error message for invalid credentials
                    echo "<script>alert('Invalid username or password.'); window.location.href = '../signin.html';</script>";
                }
            } else {
                echo "<script>alert('Invalid username or password.'); window.location.href = '../signin.html';</script>";
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "<script>alert('Please enter both username and password.'); window.location.href = '../signin.html';</script>";
    }
}

// Close the database connection
$conn->close();
?>
