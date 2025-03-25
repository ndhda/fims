<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# **Finance Management System (FiMS)**  

FiMS is a web-based **financial management system** designed to help universities manage student fees, payment verification, financial reporting, and clearance form submissions.  

This system was developed during an **internship** as part of a software engineering project.  

---

## **📌 Features**  

✅ **Login Authentication** – Secure login for students and admins.  
✅ **Student Fee Management** – Track and manage student fee payments.  
✅ **Payment Verification** – Verify submitted payments through the system.  
✅ **Financial Reporting** – Generate reports for financial analysis.  
✅ **Clearance Form Submission** – Allow students to submit clearance requests.  

---

## **⚙️ Installation Guide**  

### **🔹 Prerequisites**  
Ensure you have the following installed:  
- **PHP 8.x**  
- **MySQL/MariaDB**  
- **Apache or Nginx**  
- **Composer** (PHP dependency manager)  
- **Node.js & npm** (for frontend dependencies)  

### **🔹 Setup Steps**  

1️⃣ **Clone the repository:**  
   ```bash
   git clone https://github.com/yourusername/FiMS.git
   cd FiMS
   ```  
   
2️⃣ **Install backend dependencies:**  
   ```bash
   composer install
   ```  

3️⃣ **Install frontend dependencies:**  
   ```bash
   npm install
   ```  

4️⃣ **Set up the environment file:**  
   ```bash
   cp .env.example .env
   ```  
   - Configure **database credentials** inside `.env`:  
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=fims_db
     DB_USERNAME=root
     DB_PASSWORD=yourpassword
     ```  

5️⃣ **Generate the application key:**  
   ```bash
   php artisan key:generate
   ```  

6️⃣ **Run database migrations and seed sample data:**  
   ```bash
   php artisan migrate --seed
   ```  

7️⃣ **Start the development server:**  
   ```bash
   php artisan serve
   ```  

8️⃣ **Access the system at:**  
   👉 `http://localhost:8000`  

---

## **🖥️ Usage**  

### **🔹 Admin Dashboard**  
- Manage student fee records.  
- Approve or reject payment verifications.  
- Generate financial reports.  

### **🔹 Student Portal**  
- View personal fee status.  
- Submit payment receipts.  
- Request clearance for graduation.  

---

## **🔧 Technologies Used**  

| Stack | Technology |
|--------|-------------|
| **Backend** | Laravel (PHP Framework) |
| **Frontend** | Blade, Bootstrap, JavaScript |
| **Database** | MySQL |
| **Authentication** | Laravel Sanctum (if API-based) |

---

## **🤝 Contributing**  

Contributions are welcome! If you'd like to improve this project:  
1. Fork the repository.  
2. Create a new branch.  
3. Make your changes and push them.  
4. Submit a pull request!  

---

## **📜 License**  

This project is licensed under the **MIT License** – feel free to use and modify it.  

---

## **📩 Contact**  

For any questions or collaboration, feel free to reach out:  
📧 **Email**: your@email.com  
🔗 **GitHub**: [ndhda](https://github.com/ndhda)  
🔗 **LinkedIn**: [Nur Nadira Huda](https://linkedin.com/in/nadirahuda26)  

---

🚀 **FiMS – Making financial management easier!** 🚀 
