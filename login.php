<?php
session_start();

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "melicious_meals";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare SQL statement to retrieve user from the database
    $sql = "SELECT * FROM register WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;
            header("Location: home.php");
        } else {
            // Password is incorrect
            echo "Invalid password";
        }
    } else {
        // User does not exist
        echo "User does not exist";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
