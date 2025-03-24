<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $shop_name; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js" defer></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; overflow-x: hidden; }
        .hero { position: relative; width: 100vw; height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .hero img { width: 100%; height: 100%; object-fit: cover; }
        .hero-text { position: absolute; left: -100%; top: 50%; transform: translateY(-50%); color: white; font-size: 24px; font-weight: bold; max-width: 600px; white-space: nowrap; }
        .buttons { margin-top: 20px; }
        .btn { padding: 10px 20px; background: green; color: white; border: none; cursor: pointer; margin: 5px; text-decoration: none; }
    </style>
</head>
<body>

<!-- Hero Section -->
<div class="hero">
    <img src="images/landing_bg.webp" alt="Fresh Products">
    <div class="hero-text" id="hero-text">
        <span id="animated-text"></span>
        <div class="buttons">
            <a href="about.php" class="btn">Learn More</a>
            
        </div>
    </div>
</div>

<script>
    function toggleMenu() {
        var menu = document.getElementById("menu");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function(event) {
        var menu = document.getElementById("menu");
        var menuIcon = document.querySelector(".nav-icons a img[alt='Menu']");
        if (menu && menu.style.display === "block") {
            if (!menu.contains(event.target) && !menuIcon.contains(event.target)) {
                menu.style.display = "none";
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        let text = "Fresh & Natural Local Products. Support Local Farmers and Get Fresh, High-Quality Products";
        let words = text.split(" ");
        let animatedText = document.getElementById("animated-text");
        let heroText = document.getElementById("hero-text");
        let i = 0;
        
        function animateText() {
            if (i < words.length) {
                let span = document.createElement("span");
                span.className = "word";
                span.style.animationDelay = `${i * 0.1}s`;  
                span.innerText = words[i] + " ";
                animatedText.appendChild(span);
                i++;
                setTimeout(animateText, 50);  
            } else {
                heroText.style.left = "30px"; 
            }
        }

        setTimeout(animateText, 300);
    });
</script>

</body>
</html>
