# 🩸 Blood Donation Management System

A simple web-based Blood Donation Management System built using **PHP**, **MySQL (WAMP Server)**, **HTML**, **CSS**, and **JavaScript**.

## 🔍 Features

- 🧍‍♂️ **User Module**:  
  - Add new donor details.
  - View confirmation messages upon successful submission.

- 🛠️ **Admin Module**:  
  - Secure admin login.
  - View, update, or delete donor records.
  - Manage the overall donor database.

## 🛠 Tech Stack

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP (WAMP Server)  
- **Database**: MySQL

## 🚀 How to Run Locally

1. Install **WAMP** server.
2. Place the above contents within a folder inside the `www` directory.
3. Start **WAMP** and open **phpMyAdmin** via `http://localhost/phpmyadmin/`.
4. Create a new database named `donor_db`.
5. Inside `donor_db`, create the following tables:

### 📋 Database Structure: `donor_db`

#### 🛡️ `admins`
| Column Name | Data Type | Description         |
|-------------|------------|---------------------|
| id          | INT (PK)   | Auto-incremented ID |
| username    | VARCHAR    | Admin login username |
| password    | VARCHAR    | Admin password |
| name        | VARCHAR    | Admin full name     |
| email       | VARCHAR    | Admin email         |

#### 🩸 `blooddonations`
| Column Name     | Data Type | Description                     |
|------------------|-----------|---------------------------------|
| donationid       | INT (PK)  | Auto-incremented donation ID    |
| donor_id         | INT (FK)  | Linked to `donors.id`           |
| donation_date    | DATE      | Date of blood donation          |
| blood_type       | VARCHAR   | Donated blood type              |

#### 🏪 `blood_inventory`
| Column Name | Data Type | Description         |
|-------------|-----------|---------------------|
| id          | INT (PK)  | Inventory entry ID  |
| blood_type  | VARCHAR   | Blood group (e.g., A+) |
| count       | INT       | Units available      |

#### 🙋‍♂️ `donors`
| Column Name | Data Type | Description         |
|-------------|-----------|---------------------|
| id          | INT (PK)  | Auto-incremented ID |
| name        | VARCHAR   | Donor's name        |
| dob         | DATE      | Date of birth       |
| gender      | VARCHAR   | Gender              |
| blood_type  | VARCHAR   | Blood group         |
| address     | TEXT      | Residential address |
| mobile      | VARCHAR   | Phone number        |
| email       | VARCHAR   | Email address       |

6. Run the project by visiting:  
   `http://localhost/your-folder-name/`


