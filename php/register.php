<?php
include('db.php');

// Initialize error variable
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password

        // Check if the username already exists
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the query
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // If the username is already taken, display an error
            if ($result->num_rows > 0) {
                $errorMessage = "Username already exists. Please choose a different username.";
            } else {
                // Check if the email already exists
                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $errorMessage = "Email already exists. Please use a different email.";
                    } else {
                        // Proceed with the registration if no errors
                        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);

                        if ($stmt) {
                            $stmt->bind_param("sss", $username, $email, $password);

                            // Execute the statement
                            if ($stmt->execute()) {
                                // Redirect to the signin page after successful registration
                                header("Location: ../signin.html");
                                exit();
                            } else {
                                $errorMessage = "Error executing query: " . $stmt->error;
                            }

                            $stmt->close();
                        } else {
                            $errorMessage = "Error preparing statement: " . $conn->error;
                        }
                    }
                } else {
                    $errorMessage = "Error preparing statement: " . $conn->error;
                }
            }

            $stmt->close();
        } else {
            $errorMessage = "Error preparing statement: " . $conn->error;
        }
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}

// Close the database connection
$conn->close();

// If there's an error message, show it and redirect back to the registration page
if (!empty($errorMessage)) {
    echo "<script>alert('" . $errorMessage . "'); window.location.href = '../register.html';</script>";
}
?>
