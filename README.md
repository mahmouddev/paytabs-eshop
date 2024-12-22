# PayTabs eShop

An advanced e-commerce solution integrated with **PayTabs** for seamless and secure payment processing. This project enables users to browse products, manage their carts, and process payments efficiently using PayTabs' Hosted Payment Page API.

---

## Table of Contents

1. [Project Overview](#project-overview)
2. [Key Features](#key-features)
3. [Technical Stack](#technical-stack)
4. [System Architecture](#system-architecture)
5. [Installation and Setup](#installation-and-setup)
6. [Database Structure](#database-structure)
7. [Detailed Implementation](#detailed-implementation)
    - [Frontend Implementation](#frontend-implementation)
    - [Backend Implementation](#backend-implementation)
8. [Backend routes](#backend-routes)
9. [Contributing](#contributing)
10. [License](#license)

---

## Project Overview

**PayTabs eShop** is a modern, scalable e-commerce application designed for quick implementation of online shopping functionality. It is built with **CakePHP 5.1** and **Vue.js 3**, leveraging the latest web development techniques and integrating **PayTabs** for secure payments.

The project focuses on modularity and clean architecture, enabling developers to extend its functionality easily.

---

## Key Features

- **Guest Checkout**: Allow users to make purchases without creating an account.
- **Dynamic Cart Management**: Add, update, and remove items from the cart using Vue.js.
- **Payment Gateway Integration**: Fully integrated with PayTabs Hosted Payment Page.
- **Order Management**: View past orders, including order details, statuses, and payments.
- **Responsive Design**: Built with **Bootstrap 5** and **FontAwesome** for a user-friendly UI.
- **Database Transactions**: Ensure consistency during critical operations like payments and order updates.
- **Validation and Security**:
  - Validate customer and payment data at both frontend and backend.

---

## Technical Stack

- **Backend Framework**: CakePHP 5.1
- **Frontend Framework**: Vue.js 3
- **Database**: MySQL
- **Payment Gateway**: PayTabs Hosted Payment Page API
- **Styling**: Bootstrap 5, FontAwesome
- **AJAX Requests**: Axios
- **Session Management**: PHP Sessions in CakePHP

---

## System Architecture

### Layers:
1. **Frontend**: Built with Vue.js for reactive components like cart management and checkout forms.
2. **I/O Layer**: CakePHP controllers handle frontend requests and validate data.
3. **Business Logic**: Implemented in CakePHP models with database transactions.
4. **Database Layer**: MySQL with migrations for schema management.

---

## Installation and Setup

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/mahmouddev/paytabs-eshop.git
   cd paytabs-eshop
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment**:
   - move to config directory
   ```bash
   cd config
   ```
   - Copy `.env.example` to `.env`.

   - Update PayTabs API credentials:
     ```env
     PAYTABS_PROFILE_ID=xxxxxx
     PAYTABS_KEY=your_server_key
     PAYTABS_URL=api_url
    ```

    - Update database credentials:
     ```app.locale.php
     'host' => 'localhost'
     'username' => 'db_username',
     'password' => 'db_password',
     'database' => 'db_name',
     ```

4. **Run Migrations**:
   ```bash
   bin/cake migrations migrate
   ```

5. **Run Data Seeders**:
   ```bash
   bin/cake migrations seed
   ```

6. **Start Development Server**:
   ```bash
   bin/cake server
   ```
---

## Database Structure

### Tables

#### Products
| Column       | Type    | Description                                 |
|--------------|---------|---------------------------------------------|
| `id`         | INT     | Primary key.                                |
| `name`       | STRING  | Product name.                               |
| `price`      | DECIMAL | Price of the product.                       |
| `image`      | STRING  | Image url of the product.                   |
| `quantity`   | INT     | Stock quantity.                             |

#### Orders
| Column             | Type    | Description                           |
|--------------------|---------|---------------------------------------|
| `id`               | INT     | Primary key.                          |
| `user_id`          | INT     | Associated optinal user ID.           |
| `cart_id`          | STRING  | Unique identifier for the cart.       |
| `guest_email`      | STRING  | Gust email.                           |
| `guest_name`       | STRING  | Gust name.                            |
| `guest_phone`      | STRING  | Gust phone.                           |
| `status`           | STRING  | Status of the order (e.g., pending).  |
| `total`            | DECIMAL | Total amount of the order.            |
| `delivery_method`  | STRING  | Shipping or Pickup option.            |
| `shipping_address` | STRING  | Shipping address.                     |

#### Payments
| Column             | Type    | Description                           |
|--------------------|---------|---------------------------------------|
| `id`               | INT     | Primary key.                          |
| `order_id`         | INT     | Associated order ID.                  |
| `status`           | STRING  | Payment status (e.g., success).       |
| `amount`           | NUMBER  | Payment amount.                       |
| `transaction_id`   | STRING  | Paytabs transaction ref.              |

---

## Detailed Implementation

### Frontend Implementation

#### Cart Management
- **Local Storage**: The cart data is stored in the browser using LocalStorage.
- **Reactive Updates**: Vue.js components dynamically update the cart and total values.

#### Checkout Form
- **Validation**: Fields are validated dynamically using Vue.js.
- **Shipping vs Pickup**: Conditional rendering based on the selected delivery method.

---

### Backend Implementation

#### Validation
- **Custom Validator**:
  - Validates nested customer data.
  - Ensures required fields are present.

#### Payment API Integration
1. **Initiate Payment**:
   - Send a request to PayTabs with the order and customer details.
   - Use the `framed` option for iframe integration.

2. **Validate Payment Response**:
   - Ensure the response is valid and from PayTabs.
   - Update the database transactionally.

---

## Backend routes examples

### Payment Endpoints
| Method | Endpoint                                 | Description                        |
|--------|------------------------------------------|------------------------------------|
| POST   | `/payments/initializeHostedPaymentPage`  | Creates a new payment session.     |
| POST   | `/payments/return`                       | Validates the payment response.    |

### Order Endpoints
| Method | Endpoint                                 | Description                        |
|--------|------------------------------------------|------------------------------------|
| GET    | `/orders`                                | Retrieves a list of orders.        |
| GET    | `/orders/view/{id}`                      | Retrieves details of a specific order. |

---

## Contributing

We welcome contributions. Please follow these steps:

1. **Fork the repository**.
2. **Create a new branch**:
   ```bash
   git checkout -b feature-name
   ```
3. **Commit changes**:
   ```bash
   git commit -m "Add new feature"
   ```
4. **Push to the branch**:
   ```bash
   git push origin feature-name
   ```
5. **Open a pull request**.

---

## License

This project is licensed under the [MIT License](LICENSE).
