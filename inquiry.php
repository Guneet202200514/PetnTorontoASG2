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

// Fetch users and their pet requests
$sql = "SELECT users.id, users.name, users.email, pets.id AS pet_id, pets.pet_type, pets.breed, pets.age 
        FROM users INNER JOIN pets ON users.id = pets.user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users and Pet Requests</title>
    <link rel="stylesheet" href="css/read.css">
</head>
<body>
    <div class="container">
        <div class="top-section">
            <div class="website-name">Pet'n Toronto</div>
        </div>
        <div class="nav">
            <a href="index.php">Home</a>
        </div>
        <h1>Registered Users and Their Pet Requests</h1>
        <div class="users-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Pet Type</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["pet_type"] . "</td>";
                            echo "<td>" . $row["breed"] . "</td>";
                            echo "<td>" . $row["age"] . "</td>";
                            echo "<td><a href='update.php?id=" . $row["id"] . "&pet_id=" . $row["pet_id"] . "'>Update</a> | 
                                      <a href='delete.php?id=" . $row["id"] . "&pet_id=" . $row["pet_id"] . "' onclick=\"return confirm('Are you sure you want to delete this entry?');\">Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No users found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
