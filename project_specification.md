# Project Specification

## 1. Demo Scenario Overview

### Key Features
- User registration and login
- Add income and expense records
- View monthly financial summaries
- Visualize expenses by category using charts
- Filter transactions by date and category

### User Actions
- User logs in
- Adds an expense
- Views report chart
- Searches transactions

### Functional Parts
- Authentication
- Transaction storage and retrieval
- Report generation with pseudo chart data

## 2. Planned URL Endpoints

| URL Path               | Method | HTTP Variables                | Session Var | DB Operation                     |
|------------------------|--------|-------------------------------|-------------|----------------------------------|
| /login.php             | POST   | username, password            | user_id     | SELECT from users                |
| /register.php          | POST   | username, email, password     | -           | INSERT into users                |
| /dashboard.php         | GET    | -                             | user_id     | SELECT from transactions         |
| /add_transaction.php   | POST   | amount, category, date, desc  | user_id     | INSERT into transactions         |
| /view_report.php       | GET    | month, year                   | user_id     | SELECT + GROUP BY from transactions |
| /logout.php            | GET    | -                             | -           | Destroy session                  |

## 3. Database Design

### ERD
- User (1) --- (N) Transaction

### Relational Tables

**Users**
- user_id (PK)
- username
- password
- email
- created_at

**Transactions**
- transaction_id (PK)
- user_id (FK)
- amount
- category
- description
- date
- created_at

### Normalization
- 3NF satisfied: no repeating groups, full dependency, no transitive dependency
