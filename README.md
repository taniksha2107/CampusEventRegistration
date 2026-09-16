# Campus Event Registration System

A database-driven web application developed using PHP and MySQL for managing college event registrations.

## 📌 Problem Statement: ** Campus Event Registration System**

Add event registrations with participant details, event name, and department; list registrations and search by event.

## 🎯 Objectives

- Allow students to register for college events.
- Store participant and event details in a MySQL database.
- Display registered participants.
- Search registrations by event.
- Prevent duplicate registration for the same student and event.
- Provide a simple and user-friendly web interface.

## 🛠️ Technology Stack

- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Database:** MySQL / MariaDB
- **Local Server:** XAMPP
- **Hosting:** InfinityFree
- **Version Control:** GitHub

## 🌐 Hosted Application

**Hosting Platform:** InfinityFree

**Live Website:**

https://campuseventregistration.infinityfree.io

The Campus Event Registration System is deployed and hosted on InfinityFree. The hosted application was tested through the live website, including event listing, registration, search/filter, and delete operations.

## ✨ Main Features

- Home page with project information
- Event listing
- Student event registration form
- Event selection
- Registration records display
- Search/filter registrations by event
- Delete registration
- Duplicate registration prevention
- Server-side validation
- Prepared SQL statements
- Secure database connection

## 🗄️ Database Design:

The system contains three main tables:

### 1.Users:
Stores participant information.

| Field | Type | Description |
|---|---|---|
| id | INT | Primary Key |
| name | VARCHAR(100) | Participant name |
| email | VARCHAR(100) | Unique email |
| role | ENUM | Student/Admin |
| created_at | TIMESTAMP | Record creation time |

### 2.Events:
Stores college event information.

| Field | Type | Description |
|---|---|---|
| id | INT | Primary Key |
| event_name | VARCHAR(150) | Event name |
| event_date | DATE | Event date |
| event_time | TIME | Event time |
| venue | VARCHAR(150) | Event venue |
| description | TEXT | Event description |

### 3.Registrations:
Stores event registration details.

| Field | Type | Description |
|---|---|---|
| id | INT | Primary Key |
| user_id | INT | Foreign Key to users |
| event_id | INT | Foreign Key to events |
| department | VARCHAR(100) | Student department |
| registration_date | TIMESTAMP | Registration time |

The `registrations` table connects students with events using `user_id` and `event_id`.

A unique constraint on `(user_id, event_id)` prevents the same student from registering for the same event more than once.

## 🔄 Application Workflow:
User
  ↓
Home Page
  ↓
Events / Registration Form
  ↓
Enter Participant Details
  ↓
Select Event
  ↓
PHP Server-side Validation
  ↓
Prepared SQL Query
  ↓
MySQL Database
  ↓
Registration Confirmation
  ↓
View / Search Registrations
