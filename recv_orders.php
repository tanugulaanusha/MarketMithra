<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketMitra - Orders Received</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .order-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .order {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 15px 0;
            background-color: #fafafa;
            border-radius: 5px;
        }
        .order h3 {
            margin: 0;
            padding-bottom: 10px;
            color: #0275d8;
        }
        .order p {
            margin: 5px 0;
            font-size: 14px;
        }
        .status {
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
        }
        .pending { background-color: orange; color: white; }
        .shipped { background-color: blue; color: white; }
        .delivered { background-color: green; color: white; }
        .cancelled { background-color: red; color: white; }
    </style>
</head>
<body>

<?php
session_start();
include 'config.php';
include 'headerF.php'; // Farmer navigation bar

// Check if user is logged in and is a farmer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'farmer') {
    die("<p style='text-align:center; color:red;'>Access Denied. Please log in as a farmer.</p>");
}

$farmer_id = $_SESSION['user_id'];

echo "<div class='order-container'>";
echo "<h2>Orders Received</h2>";

// Fetch orders related to the logged-in farmer
$query = "SELECT o.order_id, o.total_amount, o.payment_method, o.order_date, o.order_status, 
                 u.name AS customer_name, u.phone AS customer_phone
          FROM orders o 
          JOIN users u ON o.customer_id = u.id
          WHERE o.farmer_id = ?
          ORDER BY o.order_date DESC";

$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $farmer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any orders exist
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $status_class = strtolower($row['order_status']);

            echo '<div class="order">';
            echo '<h3>Order ID: ' . htmlspecialchars($row['order_id']) . '</h3>';
            echo '<p><strong>Customer:</strong> ' . htmlspecialchars($row['customer_name']) . ' (Ph: ' . htmlspecialchars($row['customer_phone']) . ')</p>';
           
            echo '<p><strong>Total Amount:</strong> ₹' . htmlspecialchars($row['total_amount']) . '</p>';
            echo '<p><strong>Payment Method:</strong> ' . htmlspecialchars($row['payment_method']) . '</p>';
            echo '<p><strong>Order Date:</strong> ' . htmlspecialchars($row['order_date']) . '</p>';
            echo '<p><strong>Order Status:</strong> <span class="status ' . $status_class . '">' . htmlspecialchars($row['order_status']) . '</span></p>';
            echo '</div>';
        }
    } else {
        echo "<p style='text-align:center; color:gray;'>No orders received yet.</p>";
    }
    $stmt->close();
} else {
    echo "<p style='text-align:center; color:red;'>Error fetching orders. Please try again later.</p>";
}

echo "</div>";
?>

</body>
</html>
