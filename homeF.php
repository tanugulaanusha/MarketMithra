<?php include 'headerF.php'; ?>

<style>
    .hero { 
        position: relative; 
        width: 100vw; 
        height: 100vh; 
        overflow: hidden; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
    }
    .hero img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }
    .hero-text { 
        position: absolute; 
        color: white; 
        font-size: 24px; 
        font-weight: bold; 
        text-align: center; 
    }
    .buttons { 
        margin-top: 20px; 
    }
    .btn { 
        padding: 10px 20px; 
        background: green; 
        color: white; 
        border: none; 
        cursor: pointer; 
        margin: 5px; 
        text-decoration: none; 
        border-radius: 5px;
    }
    .btn:hover {
        background: darkgreen;
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
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background-color: white;
        padding: 20px;
        margin: 15% auto;
        width: 30%;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .modal-content h2 {
        margin-bottom: 15px;
    }
    .modal-content ul {
        list-style-type: none;
        padding: 0;
    }
    .modal-content ul li {
        margin: 10px 0;
    }
    .modal-content ul li a {
        text-decoration: none;
        font-size: 18px;
        color: black;
        display: block;
        padding: 10px;
        border-radius: 5px;
        transition: background 0.3s ease;
    }
    .modal-content ul li a:hover {
        background: #f1f1f1;
    }
    .close {
        float: right;
        font-size: 22px;
        cursor: pointer;
    }

    /* Chatbot Icon */
    .chatbot-icon {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background: url('images/chatbot_icon.png') no-repeat center;
        background-size: cover;
        cursor: pointer;
        border-radius: 50%;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
    }
</style>
<!-- Google Translate Dropdown -->
<div class="translate-container">
        <div id="google_translate_element"></div>
    </div>
<div class="hero">
    <img src="images/landing_bg.webp" alt="Fresh Products">
    <div class="hero-text">
        <p>Fresh & Natural<br>Local Products<br>Support Local Farmers and Get Fresh, High-Quality Products</p>
        <div class="buttons">
            <a href="aboutF.php" class="btn">Learn More</a>
            <a href="javascript:void(0);" class="btn" onclick="openModal()">Manage Products</a>
        </div>
    </div>
</div>

<!-- Modal for Manage Products -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Manage Products</h2>
        <ul>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="delete_product.php">Delete Product</a></li>
            <li><a href="edit_product.php">Edit Product</a></li>
        </ul>
    </div>
</div>

<!-- Chatbot Icon -->
<div class="chatbot-icon" onclick="openChatbotModal()"></div>

<!-- Chatbot Modal -->
<div id="chatbotModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeChatbotModal()">&times;</span>
        <h2>BhoomiAI - Your MarketMitra Assistant</h2>
        <p>Click the button below to chat with BhoomiAI.</p>
        <a href="https://poe.com/BhoomiAI" target="_blank" class="btn">Open Chatbot</a>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("productModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("productModal").style.display = "none";
    }

    function openChatbotModal() {
        document.getElementById("chatbotModal").style.display = "block";
    }

    function closeChatbotModal() {
        document.getElementById("chatbotModal").style.display = "none";
    }

    // Close modals if user clicks outside the modal box
    window.onclick = function(event) {
        var productModal = document.getElementById("productModal");
        var chatbotModal = document.getElementById("chatbotModal");
        if (event.target === productModal) {
            productModal.style.display = "none";
        }
        if (event.target === chatbotModal) {
            chatbotModal.style.display = "none";
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
