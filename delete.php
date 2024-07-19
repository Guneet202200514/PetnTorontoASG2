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

if (isset($_GET["id"]) && isset($_GET["pet_id"])) {
    $id = $_GET["id"];
    $pet_id = $_GET["pet_id"];

    // Delete pet request
    $stmt = $conn->prepare("DELETE FROM pets WHERE id = ?");
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $stmt->close();

    // Delete user if no more pet requests
    $stmt = $conn->prepare("SELECT COUNT(*) FROM pets WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header("Location: users.php");
exit();
?>
