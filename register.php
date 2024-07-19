<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petntoronto";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $petType = $_POST["petType"];
    $breed = $_POST["breed"];
    $age = $_POST["age"];

    // Insert user into users table
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $user_id = $stmt->insert_id;
    $stmt->close();

    // Insert pet request into pets table
    $stmt = $conn->prepare("INSERT INTO pets (user_id, pet_type, breed, age) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $petType, $breed, $age);
    $stmt->execute();
    $stmt->close();

    echo "Registration successful!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <div class="top-section">
            <div class="website-name">Pet'n Toronto</div>
        </div>
        <div class="nav">
            <a href="index.php">Home</a>
            <a href="inquiry.php">Requests</a>
        </div>
        <h1>Register and Request a Pet</h1>
        <form action="register.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="petType">Select a Pet Type:</label>
            <select id="petType" name="petType" required>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
                <option value="turtle">Turtle</option>
                <option value="rabbit">Rabbit</option>
            </select>

            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed" placeholder="Enter breed (optional)">

            <label for="age">Age (years/months):</label>
            <input type="number" id="age" name="age" min="0" step="0.5" placeholder="Enter age (optional)">

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
