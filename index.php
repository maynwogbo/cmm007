<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>Melicious Food Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
        }
        nav a:hover {
            background-color: #555;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .recipe {
            border-bottom: 1px solid #ccc;
            padding: 20px 0;
        }
        h2 {
            margin-top: 0;
        }
        p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Melicious Diet</h1>
    </header>
    <nav>
        <a href="home.html">Home</a>
        <a href="searchRecipes.php">Recipes</a>
        <a href="about.html">About</a>
        <a href="contactUs.php">Contact</a>
        <a href="register.php">Register</a>
        <a href="login.html">Login</a>
    </nav>
    <div class="container">
        <h2>Our Latest Recipes</h2>
        <?php
        
        $recipes = array(
            array(
                "title" => "Spaghetti Carbonara",
                "summary" => "A classic Italian pasta dish made with eggs, cheese, pancetta, and black pepper.",
                "url" => "recipe.php?id=1"
            ),
            array(
                "title" => "Chicken Alfredo",
                "summary" => "Creamy pasta with grilled chicken, mushrooms, and garlic.",
                "url" => "recipe.php?id=2"
            ),
            array(
                "title" => "Vegetable Stir Fry",
                "summary" => "Colorful mix of fresh vegetables stir-fried in a savory sauce.",
                "url" => "recipe.php?id=3"
            )
        );
        
        foreach ($recipes as $recipe):
        ?>
        <div class="recipe">
            <h3><a href="<?php echo $recipe['url']; ?>"><?php echo $recipe['title']; ?></a></h3>
            <p><?php echo $recipe['summary']; ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
