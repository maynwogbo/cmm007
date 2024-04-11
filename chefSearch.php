<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "melicious_spice";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve chef name from form
    $search_chef = $_POST['search_chef'];
    
    // Prepare SQL statement to search for recipes by chef
    $sql = "SELECT * FROM recipes WHERE chef_name LIKE '%$search_chef%'";
    
    // Execute SQL statement
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Output data of each row
        echo "<h2>Recipes by Chef: $search_chef</h2>";
        while($row = $result->fetch_assoc()) {
            echo "<h3>Recipe Name: " . $row["recipe_name"] . "</h3>";
            echo "<p>Ingredients: " . $row["ingredients"] . "</p>";
            echo "<p>Instructions: " . $row["instructions"] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "No recipes found for chef: $search_chef";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Recipes by Chef</title>
</head>
<body>
    <h2>Search for Chef</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="search_chef">Enter Chef Name:</label><br>
        <input type="text" id="search_chef" name="search_chef"><br><br>
        
        <input type="submit" value="Search">
    </form>
</body>
</html>
