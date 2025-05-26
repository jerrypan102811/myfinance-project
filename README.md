# myfinance-project

## 1. Demo Scenario Overview

### Specific Features to Present

This section outlines the core system functionalities that will be demonstrated during the final project presentation:

- **User registration and login:** Secure account creation and access control.
- **Add income and expense records:** Users can manually input transactions to track their daily finances.
- **View monthly financial summaries:** The system summarizes a user’s financial activity by month.
- **Visualize expenses by category using charts:** Expense data is converted into visual charts (e.g., pie charts) to help users quickly understand their spending habits.
- **Filter transactions by date and category:** Users can locate specific transactions using flexible filtering options.

### User Actions in Demo

This section simulates the expected user interaction flow during the demo, showing how the system is used in real-life scenarios:

1. A user logs in to their MyFinance account using their credentials.
2. The user adds a new expense record, specifying the amount, category (e.g., food), and date.
3. They navigate to the financial reports page, where a pie chart displays their spending distribution for the month.
4. They use a filter to search for specific transactions, such as all dining expenses in the past two weeks.

### Functional Parts for Demo

To ensure a clear and working user experience (even if simplified), we plan to implement the following core flows:

- **User Login (partial):** A simplified login form with hardcoded credentials for demonstration purposes.
- **Add Transaction (fully functional):** A form allows users to input income or expense, stored in the database using PHP and MariaDB.
- **View Transaction Table (functional):** All transactions for the current user are displayed in a simple table.
- **View Report (pseudo implementation):** A pie chart will represent expenses by category using static mock data.

---

## 2. Planned URL Endpoints

| URL Path           | HTTP Method | HTTP Variables                          | Session Variables | DB Tables                     |
|--------------------|-------------|------------------------------------------|-------------------|-------------------------------|
| `/login.php`       | POST        | username, password                       | user_id           | SELECT user from `users`     |
| `/register.php`    | POST        | username, password, email                | -                 | INSERT into `users`          |
| `/dashboard.php`   | GET         | -                                        | user_id           | SELECT from `transactions`   |
| `/add_transaction.php` | POST   | amount, category, date, description      | user_id           | INSERT into `transactions`   |
| `/view_report.php` | GET         | month, year                              | user_id           | SELECT + GROUP BY from `transactions` |
| `/logout.php`      | GET         | -                                        | -                 | Destroy session              |

### Brief Descriptions

- `login.php`: Handles login form submission and validates credentials.
- `register.php`: Handles new user registration.
- `dashboard.php`: Displays all transactions for the logged-in user.
- `add_transaction.php`: Processes the form to add a new transaction.
- `view_report.php`: Shows a visual summary of expenses by category (static data if needed).
- `logout.php`: Logs the user out and ends the session.

---

## 3. Database Design

### a. Entity-Relationship Diagram (ERD)

*(Diagram not included in this text version. Suggest adding ERD image as `doc/ERD.png` in the repo.)*

---

### b. Relational Model (Table Definitions)

#### **users**

| Column Name | Data Type     | Constraints                        |
|-------------|---------------|------------------------------------|
| id          | INT           | PRIMARY KEY, AUTO_INCREMENT        |
| username    | VARCHAR(50)   | UNIQUE, NOT NULL                   |
| email       | VARCHAR(100)  | UNIQUE, NOT NULL                   |
| password    | VARCHAR(255)  | NOT NULL                           |
| created_at  | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP          |

---

#### **categories**

| Column Name | Data Type     | Constraints                                     |
|-------------|---------------|-------------------------------------------------|
| id          | INT           | PRIMARY KEY, AUTO_INCREMENT                     |
| user_id     | INT           | FOREIGN KEY REFERENCES users(id), NULLABLE      |
| name        | VARCHAR(50)   | NOT NULL                                        |
| type        | ENUM          | ('income','expense'), NOT NULL                  |

---

#### **transactions**

| Column Name      | Data Type     | Constraints                                  |
|------------------|---------------|----------------------------------------------|
| id               | INT           | PRIMARY KEY, AUTO_INCREMENT                  |
| user_id          | INT           | FOREIGN KEY REFERENCES users(id), NOT NULL   |
| category_id      | INT           | FOREIGN KEY REFERENCES categories(id), NOT NULL |
| amount           | DECIMAL(10,2) | NOT NULL                                     |
| transaction_date | DATE          | NOT NULL                                     |
| description      | TEXT          | -                                            |
| created_at       | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP                    |

---

### c. Normalization

- **1NF:** All attributes are atomic; each column holds only one value.
- **2NF:** All non-key columns are fully dependent on the primary key.
- **3NF:** No transitive dependencies; every non-key attribute depends only on the primary key.

### Design Decisions

- Separate `categories` table avoids duplication and supports extensibility.
- `user_id` links across tables to support multi-user environments.
- ENUM type in `categories` ensures income/expense consistency.
- Foreign keys enforce referential integrity.

