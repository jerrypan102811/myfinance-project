# Project Specification & Database Design

---

## 1. Demo Scenario Overview

### Specific Features to Present
- User registration and login
- Add income and expense records
- View monthly financial summaries
- Visualize expenses by category using charts
- Filter transactions by date and category

### User Actions in Demo
- User logs in
- Adds an expense
- Views a pie chart report
- Searches specific transactions

### Functional Parts for Demo
- Login (partial with fixed credentials)
- Add transaction (fully functional with database)
- Transaction table (read from DB)
- Report (pseudo implementation with static data)

---

## 2. Planned URL Endpoints

| URL Path             | Method | HTTP Variables                      | Session Variables | DB Operations                          |
|----------------------|--------|-------------------------------------|-------------------|----------------------------------------|
| /login.php           | POST   | username, password                  | user_id           | SELECT user from users                 |
| /register.php        | POST   | username, password, email           | -                 | INSERT into users                      |
| /dashboard.php       | GET    | -                                   | user_id           | SELECT from transactions               |
| /add_transaction.php | POST   | amount, category, date, description | user_id           | INSERT into transactions               |
| /view_report.php     | GET    | month, year                         | user_id           | SELECT + GROUP BY from transactions    |
| /logout.php          | GET    | -                                   | -                 | Destroy session                        |

---

## 3. Database Design

### a. Entity-Relationship Diagram (ERD)
- Users (1) --- (N) Transactions  
- Users (1) --- (N) Categories  
- Categories (1) --- (N) Transactions

### b. Relational Tables

#### users
- id (INT, PK, AUTO_INCREMENT)
- username (VARCHAR(50), UNIQUE, NOT NULL)
- email (VARCHAR(100), UNIQUE, NOT NULL)
- password (VARCHAR(255), NOT NULL)
- created_at (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)

#### categories
- id (INT, PK, AUTO_INCREMENT)
- user_id (INT, FK REFERENCES users(id), NULLABLE)
- name (VARCHAR(50), NOT NULL)
- type (ENUM('income','expense'), NOT NULL)

#### transactions
- id (INT, PK, AUTO_INCREMENT)
- user_id (INT, FK NOT NULL)
- category_id (INT, FK NOT NULL)
- amount (DECIMAL(10,2), NOT NULL)
- transaction_date (DATE, NOT NULL)
- description (TEXT)
- created_at (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)

---

### c. Normalization Summary

- **1NF**: All columns are atomic and single-valued.  
- **2NF**: All non-key columns fully depend on the full primary key.  
- **3NF**: No transitive dependencies.  

**Design Notes**:  
- Categories table avoids duplication of category names  
- Foreign keys enforce referential integrity  
- ENUM ensures consistent classification
