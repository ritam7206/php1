<?php
require 'db.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=products.csv');

$output = fopen('php://output', 'w');

fputcsv($output, ['Product ID', 'Product Name', 'Category', 'Price', 'Quantity', 'Description']);

$result = $conn->query("SELECT pid, pname, category, price, quantity, description FROM products ORDER BY pid DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['pid'], $row['pname'], $row['category'], $row['price'], $row['quantity'], $row['description']]);
    }
}

fclose($output);
$conn->close();
exit();
