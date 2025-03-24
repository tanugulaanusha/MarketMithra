<?php
session_start();
$shop_name = "MarketMithra";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $shop_name; ?></title>

    <style>
        /* Navbar */
        .navbar { 
            display: flex; justify-content: space-between; align-items: center; 
            padding: 15px 20px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            position: fixed; width: 100%; top: 0; left: 0; z-index: 1000;
        }

        /* Logo */
        .logo img { 
            width: 70px;  
            height: auto; 
            object-fit: contain; 
        }

        /* Navbar Icons */
        .nav-icons { 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            margin-right: 50px; 
        } 

        .nav-icons a img { 
            width: 40px; 
            height: 40px; 
            cursor: pointer; 
        } 

        /* Search Box */
        .search-form {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            padding: 5px;
            border-radius: 20px;
        }

        .search-box {
            border: none;
            outline: none;
            padding: 8px;
            width: 150px;
            border-radius: 20px;
            background: transparent;
        }

        .search-btn {
            border: none;
            background: none;
            cursor: pointer;
        }

        .search-btn img {
            width: 24px;
            height: 24px;
        }

        /* Dropdown Menu */
        .menu-dropdown {
            display: none;
            position: absolute;
            top: 60px; 
            right: 20px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 150px;
            z-index: 1000;
        }

        .menu-dropdown ul {
            list-style: none;
            padding: 10px;
            margin: 0;
        }

        .menu-dropdown ul li {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .menu-dropdown ul li:last-child {
            border-bottom: none;
        }

        .menu-dropdown ul li a {
            text-decoration: none;
            color: #333;
            display: block;
        }

        .menu-dropdown ul li a:hover {
            background: #f5f5f5;
        }

        /* Language Popup */
        .language-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            z-index: 1100;
            text-align: center;
        }

        .language-popup select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .language-popup button {
            padding: 8px 15px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Google Translate Container (Hidden) -->
<div id="google_translate_element" style="display: none;"></div>

<div class="navbar">
    <!-- Logo -->
    <div class="logo">
        <a href="home.php">
            <img src="images/icons/logo.png" alt="Logo">
        </a>
    </div>

    <!-- Icons (Cart, User, Menu) -->
    <div class="nav-icons">
        
        
        <a href="login.php"><img src="images/icons/user.png" alt="User"></a>
        <a href="javascript:void(0);" id="menu-toggle">
            <img src="images/icons/menu.png" alt="Menu">
        </a>
    </div>
</div>

<!-- Dropdown Menu -->
<div class="menu-dropdown" id="menu">
    <ul>
        <li><a href="home.php">Home</a></li>
        
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="javascript:void(0);" id="change-language">Change Language</a></li>
        <?php if (isset($_SESSION['user'])) { ?>
            <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
        <?php } ?>
    </ul>
</div>

<!-- Language Popup -->
<div class="language-popup" id="language-popup">
    <select id="language-select">
        <option value="en">English</option>
        <option value="hi">Hindi</option>
        <option value="te">Telugu</option>
        <option value="ta">Tamil</option>
        <option value="kn">Kannada</option>
        <option value="mr">Marathi</option>
        <option value="bn">Bengali</option>
    </select>
    <button id="translate-btn">Translate</button>
</div>

<script>
    // Initialize Google Translate
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({ 
            pageLanguage: 'en',
            includedLanguages: 'en,hi,te,ta,kn,mr,bn',
            autoDisplay: false
        }, 'google_translate_element');
    }

    // Load Google Translate Script
    (function() {
        var googleTranslateScript = document.createElement("script");
        googleTranslateScript.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
        googleTranslateScript.async = true;
        document.body.appendChild(googleTranslateScript);
    })();

    // Menu Toggle
    document.getElementById("menu-toggle").addEventListener("click", function(event) {
        event.preventDefault();
        var menu = document.getElementById("menu");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });

    // Show Language Popup
    document.getElementById("change-language").addEventListener("click", function() {
        document.getElementById("language-popup").style.display = "block";
    });

    document.getElementById("translate-btn").addEventListener("click", function() {
    var language = document.getElementById("language-select").value;
    localStorage.setItem("selectedLanguage", language); // Store selected language

    var googleFrame = document.querySelector(".goog-te-combo");
    if (googleFrame) {
        googleFrame.value = language;
        googleFrame.dispatchEvent(new Event("change"));
    }

    document.getElementById("language-popup").style.display = "none";
});

 
</script>

</body>
</html>
