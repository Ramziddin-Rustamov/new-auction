DONE By Ramziddin Rustamov , ALikhan Khasanxonov , Khusan Khukumov , Erali Choriev.

Auction Bidding System
This is an auction bidding system built with Laravel. Users can create products, place bids, and track their bidding history.

Features

User authentication (registration, login, email verification)

Product listing and bidding system

Bid history tracking

Home page displaying user products and bids

Requirements

Make sure you have the following installed on your system:

PHP 8.x

Composer

MySQL

Laravel 11
Node.js & npm

Redis (for caching, if applicable)

Installation

1. Clone the Repository

git clone https://github.com/Ramziddin-Rustamov/new-auction
cd new-action

2. Install Dependencies

composer install
npm install && npm run dev

3. Set Up Environment Variables

Copy the .env.example file and rename it to .env:

cp .env.example .env

Edit the .env file and update the following variables:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

4. Generate Application Key
php artisan key:generate

5. Run Migrations and Seed Database
php artisan migrate --seed

6. Start the Development Server
php artisan serve
By default, the application will be accessible at http://127.0.0.1:8000.

7. Running Tests
To ensure everything is working correctly, run:
php artisan test

API Endpoints

Some of the main API routes include:

API Routes

Authentication

POST /api/login - User login

POST /api/register - User registration

POST /api/logout - Logout user (requires authentication)

POST /api/refresh - Refresh authentication token

User Products

GET /api/user/products - Get authenticated user's products (requires authentication)

Bidding History

GET /api/bidding-history - List all bidding history (requires authentication)

POST /api/bidding-history - Create a new bid (requires authentication)

Products

GET /api/product - List all products
POST /api/product - Create a product (requires authentication)
GET /api/product/{id} - Get a specific product
PUT /api/product/{id} - Update a product (requires authentication)
DELETE /api/product/{id} - Delete a product (requires authentication)

Current Bids
GET /api/current-bid - List all current bids (requires authentication)
POST /api/current-bid - Place a new bid (requires authentication)

Running Tests
To run tests, execute:
Method
Route
Description
GET

Home page

GET
/product/{id}
View product details
POST
/product/add-bid-margin
Place a bid
GET
/home
User dashboard
Contributing
If you would like to contribute, feel free to fork the repository and submit a pull request.
License
This project is open-source and available under the MIT License.
