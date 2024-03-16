<?php
// Replace 'localhost', 'root', and '' with your actual MySQL database credentials
$conn = new mysqli('localhost', 'root', '', 'ram');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert data into the database
    $sql = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Form submitted successfully']);
    } else {
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
} else {
    echo json_encode(['message' => 'Invalid request method']);
}

$conn->close();
?>
