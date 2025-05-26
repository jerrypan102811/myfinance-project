# Project Goal

## MyFinance - Simple Personal Finance Management System

A straightforward platform for tracking income, expenses, and monthly budgets, with features like transaction management, financial summaries, and expense analysis.

---

## High-Level Functionalities

### User Management
- User Registration, Login, and Password Reset
- User Profile Update

### Financial Record Management
- Add Income and Expenses
- Edit or Delete Transaction Records
- Categorize Records (e.g., Food, Entertainment, Tuition)

### Financial Statistics and Reports
- Monthly Income and Expense Summary
- Category-wise Expense Visualization (Pie Chart)
- Monthly Balance Tracking

### Search and Filter
- Filter Transactions by Date, Category, or Amount
- Keyword Search Functionality

---

## Two Example Scenarios (User-System Interactions)

### Scenario 1: Adding an Expense Record
- **User**: A college student, Xiao Ming  
- **Requirement**: Record a meal expense  
- **Flow**:
  1. Xiao Ming logs into the system.
  2. Clicks the "Add Expense" button.
  3. Fills in the amount, date, category (e.g., Food), and notes.
  4. The system saves this data into MariaDB and updates the monthly expense summary.
  5. A "Record Successfully Added" message is displayed.
- **Required PHP Logic and DB Operations**:
  - INSERT INTO transactions
  - Data validation
  - Monthly total update

---

### Scenario 2: Viewing Financial Reports
- **User**: An office worker, Xiao Hua  
- **Requirement**: View this month's income and expense distribution  
- **Flow**:
  1. Xiao Hua logs into the system.
  2. Clicks the "View Reports" button.
  3. System retrieves current month's transactions from MariaDB.
  4. Generates category-wise pie chart.
  5. Displays visual summary and data.
- **Required PHP Logic and DB Operations**:
  - SELECT FROM transactions
  - Aggregation and visualization (Chart.js)
