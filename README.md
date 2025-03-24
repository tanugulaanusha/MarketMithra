# MarketMitra

**MarketMitra** is a web-based platform that connects farmers directly with consumers and retailers, allowing them to list produce, negotiate prices, and manage transactions. The project aims to eliminate intermediaries and promote fair pricing for agricultural products.

## 🚀 Features
- **User Roles:**
  - **Farmer:** Add, delete, and edit products, manage profile.
  - **Customer:** View products, check farmer profiles, place orders.
- **Product Filters:** Alphabetical, price, manufacturing & expiry date.
- **Payment Method:** Cash on Delivery (COD) (Planned: Online Payment Integration).
- **Automated Tracking:** Order tracking without manual intervention.
- **Secure Authentication & Authorization.**

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** Apache (XAMPP/WAMP)

## 🔧 Installation & Setup
### Prerequisites
- Install [XAMPP](https://www.apachefriends.org/index.html) or [WAMP](https://www.wampserver.com/)
- Clone this repository:
  ```sh
  git clone https://github.com/tanugulaanusha/MarketMitra.git
  cd MarketMitra
  ```
- Move project files to the `htdocs` (XAMPP) or `www` (WAMP) folder.

### Database Setup
1. Start Apache and MySQL in XAMPP/WAMP.
2. Open `phpMyAdmin` (http://localhost/phpmyadmin/).
3. Create a database named `marketmitra`.
4. Import `marketmitra.sql` file from the project folder.

### Running the Project
- Open a browser and go to `http://localhost/MarketMitra`.
- Login as **Farmer** or **Customer** to explore features.

## 📌 Future Enhancements
- **Migrate Backend:** PHP & MySQL → React.js & MongoDB.
- **Online Payment Integration.**
- **Mobile App Development.**


