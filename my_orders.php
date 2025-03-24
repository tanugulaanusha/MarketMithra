<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketMitra - My Orders</title>
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
        /* Google Translate Dropdown */
 .translate-container {
            position: absolute;
            top: 20px;
            left: 30px;
        }

        .translate-container select {
            padding: 5px;
            font-size: 14px;
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
        .cancel-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .cancel-btn:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="order-container">
    <h2>My Orders</h2>

    <?php
    session_start();
    include 'config.php';
    include 'headerB.php'; // Customer navigation bar

    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'buyer') {
        die("<p style='text-align:center; color:red;'>Access Denied. Please log in as a customer.</p>");
    }

    $customer_id = $_SESSION['user_id'];

    if ($stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY order_date DESC")) {
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status_class = strtolower($row['order_status']);
                $order_time = strtotime($row['order_date']);
                $current_time = time();
                $time_diff = $current_time - $order_time;

                echo '<div class="order">';
                echo '<h3>Order ID: ' . htmlspecialchars($row['order_id']) . '</h3>';
                echo '<p><strong>Total Amount:</strong> ₹' . htmlspecialchars($row['total_amount']) . '</p>';
                echo '<p><strong>Payment Method:</strong> ' . htmlspecialchars($row['payment_method']) . '</p>';
                echo '<p><strong>Order Date:</strong> ' . htmlspecialchars($row['order_date']) . '</p>';
                echo '<p><strong>Order Status:</strong> <span class="status ' . $status_class . '">' . htmlspecialchars($row['order_status']) . '</span></p>';

                if ($row['order_status'] == 'Pending' && $time_diff <= 60) {
                    echo '<button class="cancel-btn" onclick="cancelOrder(' . $row['order_id'] . ')">Cancel Order</button>';
                } else {
                    echo '<button class="cancel-btn" disabled>Cancel Order</button>';
                }

                echo '</div>';
            }
        } else {
            echo "<p style='text-align:center; color:gray;'>No orders found.</p>";
        }
        $stmt->close();
    }
    ?>

</div>

<script>
function cancelOrder(orderId) {
    if (confirm("Are you sure you want to cancel this order?")) {
        $.ajax({
            url: "cancel_order.php",
            type: "POST",
            data: { order_id: orderId },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function() {
                alert("Error canceling order.");
            }
        });
    }
}
</script>
<!-- Google Translate Script -->
<script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'hi,te,ta,kn,ml,gu,pa,mr,bn,ur,as,or,sd,ne,si,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }

        function applySavedLanguage() {
            var savedLanguage = localStorage.getItem("selectedLanguage");
            if (savedLanguage) {
                var googleFrame = document.querySelector(".goog-te-combo");
                if (googleFrame) {
                    googleFrame.value = savedLanguage;
                    googleFrame.dispatchEvent(new Event("change"));
                }
            }
        }

        // Wait for Google Translate to load and apply language
        window.onload = function() {
            setTimeout(applySavedLanguage, 1000);
        };
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>
