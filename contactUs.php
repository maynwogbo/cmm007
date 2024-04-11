<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    // Email recipient
    $to = "m.nwogbo@rgu.ac.uk";
    
    // Email subject
    $subject = "Message from Contact Form";
    
    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";
    
    // Email headers
    $headers = "From: $name <$email>";
    
    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        echo "<p>Thank you for contacting us. We will get back to you as soon as possible!</p>";
    } else {
        echo "<p>Oops! Something went wrong. Please try again later.</p>";
    }
}
?>

<h2>Contact Melicious Diet</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="name">Your Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="email">Your Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="5" required></textarea><br><br>
    
    <input type="submit" value="Submit">
</form>

</body>
</html>
