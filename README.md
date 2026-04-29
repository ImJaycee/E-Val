# E-Val System

A web-based evaluation system built with Laravel that allows students to evaluate instructors and enables administrators to manage and review evaluation results.

## Features
🚀 Built with Laravel framework  
⚡️ Fast development with Vite  
📦 Asset bundling and optimization  
🔄 CRUD operations for evaluations and users  
🔐 Authentication and role-based access (Admin / Student / Instructor)  
📊 Evaluation and reporting system  
🎨 TailwindCSS for styling  

## Tech Stack
Laravel (PHP), MySQL, Vite, TailwindCSS, Axios  

## ⚙️ Getting Started

1. **Clone & Install**
   ```bash
   git clone [https://github.com/ImJaycee/E-Val.git](https://github.com/ImJaycee/E-Val.git)
   cd E-Val && composer install && npm install
   
2. **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
Note: Update your .env file with your local database credentials.

3. **Database & Launch**
    ```bash
    php artisan migrate
    ```
# Run these in separate terminals:
 ```bash
    php artisan serve
    npm run dev
 ```
