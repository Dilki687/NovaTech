<?php
include('db.php'); // Include database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Styling the buttons */
        .inquiry a {
            padding: 10px 20px;
            background-color: #f89b28;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .inquiry a:hover {
            background-color: rgb(60, 61, 61);
        }

        .inquiry {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .inquiry h3 {
            color: #113805;
            margin-bottom: 10px;
        }

        .inquiry p {
            margin: 5px 0;
            color: black;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inquiries | NovaTech</title>
    <link rel="stylesheet" href="../styles/Contact.css"> <!-- Link to your CSS file -->
</head>

<body>
    <header>
        <div class="logo">NOVATECH COMPUTER SOLUTIONS</div>
        <nav>
            <a href="../Home.html">Home</a>
            <a href="../AboutUs.html">About Us</a>
            <a href="../ContactUs.html">Contact</a>
        </nav>
        <div class="contact-cart">
            <span>📞 0777 292 272</span>
            <div class="cart">0 LKR | Build Your PC</div>
        </div>
    </header>

    <main>
        <h1>All Inquiries</h1>
        <div class="inquiries-container">
            <?php
            $sql = "SELECT * FROM inquiries ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='inquiry'>";
                    echo "<h3>Subject: " . htmlspecialchars($row['subject']) . "</h3>";
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                    echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
                    echo "<p><strong>Message:</strong> " . nl2br(htmlspecialchars($row['message'])) . "</p>";
                    echo "<p><strong>Submitted On:</strong> " . $row['created_at'] . "</p>";
                    echo "<br>";
                    echo "<a href='delete-inquiry.php?id=" . $row['id'] . "'>Delete</a> | ";
                    echo "<a href='update-inquiry.php?id=" . $row['id'] . "'>Update</a>";
                    echo "</div><br><hr>";
                }
            } else {
                echo "<p>No inquiries found.</p>";
            }
            $conn->close();
            ?>
        </div>
    </main>

    <footer class="footer">


        <div class="footer-middle">
            <div class="footer-links">
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Return Policy</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <p>Contact us at: <a href="mailto:info@novatech.com">info@novatech.com</a></p>
                <p>Follow us:</p>
                <div class="social-icons">
                    <a href="#" class="social-icon">🔗 Facebook</a>
                    <a href="#" class="social-icon">🔗 Instagram</a>
                    <a href="#" class="social-icon">🔗 LinkedIn</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Novatech Computer Solutions | All rights reserved</p>
        </div>
    </footer>
</body>

</html>