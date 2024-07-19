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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $pet_id = $_POST["pet_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $petType = $_POST["petType"];
    $breed = $_POST["breed"];
    $age = $_POST["age"];

    // Update user info
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();
    $stmt->close();

    // Update pet info
    $stmt = $conn->prepare("UPDATE pets SET pet_type = ?, breed = ?, age = ? WHERE id = ?");
    $stmt->bind_param("sssi", $petType, $breed, $age, $pet_id);
    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit();
} else {
    $id = $_GET["id"];
    $pet_id = $_GET["pet_id"];

    // Fetch user info
    $stmt = $conn->prepare("SELECT users.name, users.email, pets.pet_type, pets.breed, pets.age 
                            FROM users INNER JOIN pets ON users.id = pets.user_id WHERE users.id = ? AND pets.id = ?");
    $stmt->bind_param("ii", $id, $pet_id);
    $stmt->execute();
    $stmt->bind_result($name, $email, $petType, $breed, $age);
    $stmt->fetch();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <h1>Update User and Pet Request</h1>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="pet_id" value="<?php echo $pet_id; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

            <label for="petType">Select a Pet Type:</label>
            <select id="petType" name="petType" required>
                <option value="dog" <?php if ($petType == 'dog') echo 'selected'; ?>>Dog</option>
                <option value="cat" <?php if ($petType == 'cat') echo 'selected'; ?>>Cat</option>
                <option value="turtle" <?php if ($petType == 'turtle') echo 'selected'; ?>>Turtle</option>
                <option value="rabbit" <?php if ($petType == 'rabbit') echo 'selected'; ?>>Rabbit</option>
            </select>

            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed" value="<?php echo $breed; ?>" placeholder="Enter breed (optional)">

            <label for="age">Age (years/months):</label>
            <input type="number" id="age" name="age" min="0" step="0.5" value="<?php echo $age; ?>" placeholder="Enter age (optional)">

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
