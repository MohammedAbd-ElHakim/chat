# 💬 PHP REST Chat Application

A lightweight chat application built with **PHP (Native)** using **RESTful APIs** for all CRUD operations.

## 🛠️ How It Works (The Lifecycle)

1. **Environmental Check**: The system reads `.env` using `phpdotenv`.
2. **Auto-Installer**: `index.php` checks if the system is installed. If not, it triggers `install.php`.
3. **Contract-Based Migration**: The installer loops through classes implementing `DatabaseInstallerInterface`, creating tables and triggers via **Polymorphism**.
4. **API Interaction**: The Frontend (JS Fetch) communicates with PHP APIs, which return structured JSON responses.

---

## API Endpoint Table

The project is designed to be **plug & play**:
- No manual database setup
- No manual table creation
- Automatic installation on first run

---

## 🚀 Features

- REST API based architecture
- User authentication (Login / Register)
- Automatic database installation
- Auto creation of:
  - Tables
  - Indexes
  - Triggers
- Environment-based configuration
- Clean and scalable structure
- Ready for Postman testing (Local)

---

## 🛠 Tech Stack

- PHP (Native)
- MySQL
- REST APIs
- PDO
- Asynchronous JavaScript (fetch API) async/await
- Tailwind CSS

---

## Concepts 

- oop
- Database Indexing & Performance Optimization  
- Explain ANALYZE
- denormalization And N+1 Query Problem
- Normalization
- Triggers
- Autoloading
- Automated Migrations
- Authentication & Authorization: 
- Environment Configuration (.env)
- one-to-many massegesOfConversation

---
 
## Architecture
- MVC Concept
- API-First Architecture (كل عمليات النظام تتم من خلال RESTApi)
- Interface Segregation (solid)
- Polymorphism (Tables Classes)
- Strategy Pattern (classes of the tables of db  كل كلاس بنفز فنكشن install بطريقه خاصه خاصه به وكلهم بنفزو نفس الانترفيس الفيو نفس الفنكشن install)
- Factory Pattern (Auto Table Creation in install طريقه انشاء الobjects داخل ملف الinstall)
- Singleton (Database Connection) : You can access the single database connection from anywhere in your code using $db = Connection::connect();
- Modular architecture  ( system is subdivided into smaller, independent parts (modules) that can be created separately and then 
  assembled to form a complete system)

---

## 📂 Project Structure

```text
├── 📦 Bootstrap
│   └── 📄 install.php       # التثبيت التلقائي لقاعدة البيانات والجداول
├── 📁 chat
│   ├── 📁 apis/             # Endpoints (JSON responses)
│   └── 📁 checkdata/        # Classes for table structure & validation
├── 📁 core
│   ├── 📁 database/         # Database logic & migrations
│   ├── 📁 security_layers/  # Authentication & Session protection
│   └── 📁 cache/            # Reserved for future caching needs
├── 📁 vendor/               # Dependencies (phpdotenv, etc.)
├── 📁 views/                # Frontend (HTML, CSS, JS)
├── 📄 autoloader.php        # PSR-4 style class autoloader
├── 📄 index.php             # Entry point (Auto-install & Router)
└── 📄 .env                  # Configuration (Environment variables)
```
## 🚀 Quick Start (How to Run)

The project is designed with a **Zero-Configuration** approach. You don't need to import any SQL files manually.

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/MohammedAbd-ElHakim/chat
```
### 2️⃣ Environment Configuration

- Copy the example environment file and update it with your database credentials:
- Rename .env.example to .env.
- Open .env and set your database info:
- 
 ```bash
  DB_HOST=127.0.0.1
DB_DATABASE=chat       # Your preferred database name
DB_USER=root           # Your DB username
DB_PASSWORD=           # Your DB password
APP_URL=http://localhost/chat
```
### 3️⃣ Launching the Application
- Make sure your local server (XAMPP, Laragon, or WAMP) is running.
- Access the project via your browser: http://localhost/chat.
- The Magic Happens: The system will detect it's the first run, automatically create the database, tables, and triggers, then redirect you to the Login/Signup page.

### Screens
### Register
<img width="900" height="750" alt="register" src="https://github.com/user-attachments/assets/11483cf3-06e1-4bfb-b407-7e702a61eadf" />
### Login
<img width="900" height="750" alt="login" src="https://github.com/user-attachments/assets/0caa554c-fcbc-4291-9153-de0c50d87e94" />
### Main (Index)
<img width="900" height="750" alt="main" src="https://github.com/user-attachments/assets/6021059c-3509-4737-bce3-a6c7f9e17a19" />
### Add New Conversation
<img width="900" height="750" alt="add_new_conversation" src="https://github.com/user-attachments/assets/fd772e2e-52ae-4f86-8c03-3c84c17b43ec" />
### Start Chat
<img width="900" height="750" alt="Untitled4" src="https://github.com/user-attachments/assets/83e4cd8e-39f6-4060-8e0d-189f04fbbe56" />
