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
8. [API Endpoints](#api-endpoints)
9. [Commit Highlights](#commit-highlights)
10. [Testing](#testing)
11. [Contributing](#contributing)
12. [License](#license)

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
  - Use CSRF tokens and validate incoming requests.

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
2. **API Layer**: CakePHP controllers handle frontend requests and validate data.
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
   npm install
   ```

3. **Configure Environment**:
   - Copy `.env.example` to `.env`.
   - Update database credentials and PayTabs API keys:
     ```env
     PAYTABS_PROFILE_ID=132344
     PAYTABS_SERVER_KEY=your_server_key
     ```

4. **Run Migrations**:
   ```bash
   bin/cake migrations migrate
   ```

5. **Start Development Server**:
   ```bash
   bin/cake server
   ```

6. **Compile Frontend Assets**:
   ```bash
   npm run dev
   ```

---

## Database Structure

### Tables

#### Products
| Column       | Type    | Description                |
|--------------|---------|----------------------------|
| `id`         | INT     | Primary key.               |
| `name`       | STRING  | Product name.              |
| `category`   | STRING  | Product category.          |
| `price`      | DECIMAL | Price of the product.      |
| `quantity`   | INT     | Stock quantity.            |

#### Orders
| Column             | Type    | Description                          |
|---------------------|---------|--------------------------------------|
| `id`               | INT     | Primary key.                         |
| `cart_id`          | STRING  | Unique identifier for the cart.      |
| `status`           | STRING  | Status of the order (e.g., pending). |
| `total`            | DECIMAL | Total amount of the order.           |
| `delivery_method`  | STRING  | Shipping or Pickup option.           |

#### Payments
| Column     | Type    | Description                       |
|------------|---------|-----------------------------------|
| `id`       | INT     | Primary key.                     |
| `order_id` | INT     | Associated order ID.             |
| `status`   | STRING  | Payment status (e.g., success).  |

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

## API Endpoints

### Payment Endpoints
| Method | Endpoint             | Description                        |
|--------|-----------------------|------------------------------------|
| POST   | `/payments/initiate`  | Creates a new payment session.     |
| POST   | `/payments/validate`  | Validates the payment response.    |

### Order Endpoints
| Method | Endpoint             | Description                        |
|--------|-----------------------|------------------------------------|
| GET    | `/orders`            | Retrieves a list of orders.        |
| GET    | `/orders/view/{id}`  | Retrieves details of a specific order. |

---

## Commit Highlights

- **[Initialize Payment Integration](https://github.com/mahmouddev/paytabs-eshop/commit/xyz123)**:
  - Set up PayTabs integration.
  - Implemented validation and payment payload generation.

- **[Order Management](https://github.com/mahmouddev/paytabs-eshop/commit/xyz456)**:
  - Added APIs for creating, listing, and viewing orders.
  - Introduced pagination for order listings.

- **[Frontend Checkout](https://github.com/mahmouddev/paytabs-eshop/commit/xyz789)**:
  - Added dynamic form validation and shipping options.
  - Integrated cart component with Vue.js.

---

## Testing

1. **Unit Tests**:
   - Validates models and controllers.
   - Ensures data consistency with transactions.

2. **Integration Tests**:
   - Mock PayTabs API responses.
   - Test end-to-end checkout flow.

3. **Manual Testing**:
   - Verify payment iframe loads correctly.
   - Ensure cart data persists across sessions.

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
