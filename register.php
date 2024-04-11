<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "melicious_spice";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lasttname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    
    // Check if password and repeat password match
    if ($password !== $repeat_password) {
        echo "Error: Passwords do not match!<br>";
    } else {
       
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // SQL statement to insert data into the users table
        $sql = "INSERT INTO users (firstname, lastname, email, password)
                VALUES ('$firstname', '$lastname', '$email',  '$hashed_password')";
        
        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "Sign up successful!<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up Form</title>
</head>
<body>
    <h2>Sign Up Here</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="firstname">Firstname:</label><br>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="lastname">Lasttname:</label><br>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <label for="email">firstname:</label><br>
        <input type="text" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="repeat_password">Repeat Password:</label><br>
        <input type="password" id="repeat_password" name="repeat_password" required><br><br>
        
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
