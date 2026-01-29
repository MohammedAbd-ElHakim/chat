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
/Bootstrap
  ├── install.php (install database automatic)

 /chat
  ├── apis/
  ├── checkdata/ (classes of the tables)

 /core
  ├── database/ (tables of database which migration automatic by install.php)
  ├── security_layers/
  └── cache/ (مستقبلا عند الحاجه)
  autoloader.php
  /vendor/ (we use external package (vlucas/phpdotenv) to read env file )
 /views/ (front end)
 .env
 index.php (هنا يتم التسطيب التلقائي واعاده التوجيه الي الشات او تسجيل الدخول)



