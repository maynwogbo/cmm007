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

// Process recipe deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_recipe"])) {
    $recipeID = $_POST["recipe_id"];

    // Prepare SQL statement to delete data from the database
    $sql = "DELETE FROM recipesmethods WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipe_id);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Recipe deleted successfully";
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
    <title>Delete Recipe</title>
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

<h2>Delete Recipe</h2>

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

    // Display the delete confirmation form
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <div class="wrapper" style="text-align: center;">
        <p>Are you sure you want to delete the recipe "<?php echo $row['recipe_name']; ?>"?</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="recipe_name" value="<?php echo $row['id']; ?>">
            <input type="submit" name="delete_recipe" value="Delete Recipe">
            <a href="view_recipes.php">Cancel</a>
        </form>
        </div>
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
