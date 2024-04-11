<?php
// Database connection parameters
$host = "localhost"; // Change this to your host if not local
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "melicious_spice"; // Change this to your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process recipe update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeID = $_POST["recipe_id"];
    $recipeName = $_POST["recipe_name"];
    $category = $_POST["category"];
    $location = $_POST["location"];

    // Prepare SQL statement to update data in the database
    $sql = "UPDATE recipes SET recipe_name=?, category=?, location=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $recipeName, $category, $location, $recipeID);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Record updated successfully";
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
    <title>Update Recipe</title>
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
    </style>
</head>
<body>

<h2>Update Recipe</h2>

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

    // Display the update form
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="recipe_id" value="<?php echo $row['id']; ?>">

            <label for="recipe_name">Recipe Name</label>
            <input type="text" id="recipe_name" name="recipe_name" value="<?php echo $row['recipe_name']; ?>" required>

            <label for="category">Category</label>
            <input type="text" id="category" name="category" value="<?php echo $row['category']; ?>" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo $row['location']; ?>" required>

            <input type="submit" value="Update Recipe">
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
