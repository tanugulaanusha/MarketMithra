<?php
session_start();
include("config.php"); // Ensure this file has a working DB connection

// Ensure header is included only after session check to prevent output issues
ob_start();
include("headerF.php");
ob_end_flush();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== "farmer") {
    header("Location: home.php");
    exit();
}

// Get the logged-in farmer's ID
$user_id = $_SESSION['user_id'];

// Check if connection is working
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch farmer details
$sql = "SELECT name, id, email, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $farmer = $result->fetch_assoc();
} else {
    die("Farmer details not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Profile</title>
    <link rel="stylesheet" href="css/styles.css">
   <style> 
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
        </style>
</head>
<body>
    <h2>Farmer Profile</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($farmer['name']); ?></p>
    <p><strong>ID:</strong> <?php echo htmlspecialchars($farmer['id']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($farmer['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($farmer['phone']); ?></p>
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
