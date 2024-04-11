<?php
// Database connection
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

// Process recipe update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_recipe"])) {
    $recipeID = $_POST["chef_name"];
    $recipeName = $_POST["recipe_name"];
    $category = $_POST["category"];
    $ingredients = $_POST["ingredients"];
    $instructions = $_POST["instructions"];

    // SQL statement to update in the database
    $sql = "UPDATE recipesmethods SET chef_name=?, recipe_name=?, category=?, ingredients=?, instructions=?, WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $recipeName, $category, $location, $recipeID);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Recipe updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
</head>
<body>

<h2>Edit Recipe</h2>

<?php
// Check if a recipe ID is provided in the URL
if (isset($_GET['id'])) {
    $recipeID = $_GET['id'];

    // Retrieve the recipe information from the database
    $sql = "SELECT * FROM recipes WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipeID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the edit form
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="recipe_id" value="<?php echo $row['id']; ?>">

            <label for="chef_name">Chef Name</label>
            <input type="text" id="chef_name" name="chef_name" value="<?php echo $row['chef_name']; ?>" required>

            <label for="recipe_name">Recipe Name</label>
            <input type="text" id="recipe_name" name="recipe_name" value="<?php echo $row['recipe_name']; ?>" required>

            <label for="category">Category</label>
            <input type="text" id="category" name="category" value="<?php echo $row['category']; ?>" required>
            
            <label for="ingredients">Ingredients</label>
            <input type="textarea" id="ingredients" name="ingredients" value="<?php echo $row['ingredients']; ?>" required>

            <label for="instructions">Instructions</label>
            <input type="textarea" id="instructions" name="instructions" value="<?php echo $row['instructions']; ?>" required>

            <input type="submit" name="update_recipe" value="Update Recipe">
        </form>
<?php
    } else {
        echo "No recipe found with ID: " . $recipeID;
    }

    // Close statement
    $stmt->close();
} else {
    echo "No recipe ID provided.";
}
?>

</body>
</html>
