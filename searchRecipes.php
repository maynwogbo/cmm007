<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "melicious_spice";
// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//initial filter values
$locationFilter = "";
$categoryFilter = "";

// Process search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $locationFilter = $_POST["location"];
    $categoryFilter = $_POST["category"];
}

// Construct SQL query
$sql = "SELECT * FROM recipes";

if (!empty($locationFilter) || !empty($categoryFilter)) {
    $sql .= " WHERE";
    
    if (!empty($locationFilter)) {
        $sql .= " location LIKE '%$locationFilter%'";
    }
    
    if (!empty($locationFilter) && !empty($categoryFilter)) {
        $sql .= " AND";
    }
    
    if (!empty($categoryFilter)) {
        $sql .= " category LIKE '%$categoryFilter%'";
    }
}

// Execute SQL query
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output the recipes
    while ($row = $result->fetch_assoc()) {
        echo "Recipe Name: " . $row["recipe_name"] . "<br>";
        echo "Category: " . $row["category"] . "<br>";
        echo "Location: " . $row["location"] . "<br>";
        echo "<br>";
    }
} else {
    echo "No recipes found.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>Search Recipes</title>
    <style>
    body {
        font: 14px sans-serif;
    }

    .wrapper {
        width: 360px;
        height: 360px;
        padding: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* .wrapper{ width: 360px; padding: 20px; } */
    </style>
</head>
<body>
<div class="wrapper" style="text-align: center;">

<h2>Search Recipes</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="location">Location:</label>
    <input type="text" id="location" name="location" value="<?php echo $locationFilter; ?>">
    <br><br>
    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?php echo $categoryFilter; ?>">
    <br><br>
    <input type="submit" name="search" value="Search">
</form>
</div>

</body>
</html>
