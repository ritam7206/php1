<?php
include 'db.php';

if (isset($_POST['pname']) && isset($_POST['category']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['description'])) {
    $pname = $_POST['pname'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO products (pname, category, price, quantity, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $pname, $category, $price, $quantity, $description);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "All fields are required.";
}
?>