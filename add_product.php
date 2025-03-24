<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include database connection
include 'headerF.php';
$message = ""; // To display success or error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $type = $_POST['type'];
    $product_name = $_POST['product_name'];
    $product_desc = $_POST['product_desc'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $manufactured_date = $_POST['manufactured_date'];
    $expiry_date = $_POST['expiry_date'];
    $farmer_id = $_POST['farmer_id'];

    // Validate farmer_id
    if (!is_numeric($farmer_id)) {
        $message = "❌ Error: Invalid Farmer ID.";
    } else {
        // Handle Image Upload
        $target_dir = "uploads/";
        $image_name = basename($_FILES["product_img"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES["product_img"]["tmp_name"]);
        if ($check === false) {
            $message = "❌ Error: File is not an image.";
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $message = "❌ Error: Only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif (!move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file)) {
            $message = "❌ Error: Failed to upload image.";
        } else {
            // Insert into database
            $sql = "INSERT INTO products 
                    (type, product_name, product_desc, product_img_name, qty, price, location, manufactured_date, expiry_date, farmer_id) 
                    VALUES 
                    ('$type', '$product_name', '$product_desc', '$image_name', '$qty', '$price', '$location', '$manufactured_date', '$expiry_date', '$farmer_id')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                        if (confirm('✅ Product added successfully! Do you want to add another product?')) {
                            window.location.href = 'add_product.php';
                        } else {
                            window.location.href = 'homeF.php';
                        }
                      </script>";
                exit;
            } else {
                $message = "❌ Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background: url('images/landing_bg.webp') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin-top: 80px; /* Adjust as needed for spacing between header and container */
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
.container {
    background: rgba(255, 255, 255, 0.9); /* Slight transparency */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin-top: 20px; /* Extra spacing from header */
}

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        label {
            width: 40%;
            font-weight: bold;
        }
        input, select, textarea {
            width: 55%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    
<!-- Google Translate Dropdown -->
<div class="translate-container">
        <div id="google_translate_element"></div>
    </div>
    <div class="container">
        <h2>Add Product</h2>

        <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>

        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="type">Type:</label>
                <select name="type" id="type" required>
                    <option value="Root">Root</option>
                    <option value="Vegetable">Vegetable</option>
                    <option value="Fruit">Fruit</option>
                </select>
            </div>

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" required>
            </div>

            <div class="form-group">
                <label for="product_desc">Description:</label>
                <textarea name="product_desc" id="product_desc" required></textarea>
            </div>

            <div class="form-group">
                <label for="qty">Quantity:</label>
                <input type="number" name="qty" id="qty" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" name="price" id="price" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" name="location" id="location" required>
            </div>

            <div class="form-group">
    <label for="manufactured_date">Manufactured Date:</label>
    <input type="date" name="manufactured_date" id="manufactured_date" required>
</div>

<script>
    // Set the current date as the minimum date for Manufactured Date
    document.getElementById("manufactured_date").min = new Date().toISOString().split("T")[0];
</script>


            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" name="expiry_date" id="expiry_date" required>
            </div>

            <div class="form-group">
                <label for="farmer_id">Farmer ID:</label>
                <input type="number" name="farmer_id" id="farmer_id" required>
            </div>

            <div class="form-group">
                <label for="product_img">Product Image:</label>
                <input type="file" name="product_img" id="product_img" required>
            </div>

            <button type="submit">Add Product</button>
        </form>
    </div>
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
