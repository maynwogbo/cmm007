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
    // Retrieve form data
    $chef_name = $_POST['chef_name'];
    $recipe_name = $_POST['recipe_name'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    
    // Prepare SQL statement to insert data into the recipes table
    $sql = "INSERT INTO recipesmethods (chef_name, recipe_name, category, ingredients, instructions)
            VALUES ('$chef_name', '$recipe_name', '$category', '$ingredients', '$instructions')";
    
    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Recipe added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Melicious Add Recipe</title>
</head>
<body>
    <h2>Add Your Recipe Here</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="chef_name">Chef Name:</label><br>
        <input type="text" id="chef_name" name="chef_name"><br><br>
        
        <label for="recipe_name">Recipe Name:</label><br>
        <input type="text" id="recipe_name" name="recipe_name"><br><br>

        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category"><br><br>
        
        <label for="ingredients">Ingredients:</label><br>
        <textarea id="ingredients" name="ingredients"></textarea><br><br>
        
        <label for="instructions">Instructions:</label><br>
        <textarea id="instructions" name="instructions"></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
