<p align="center">
  <a href="https://yammam-cafe-main-olbq74.laravel.cloud" target="_blank">
  </a>
</p>

<h1 align="center">☕ Yammam Café</h1>

<p align="center">
  A café ordering and suggestion management system built for Yammam café in Jada 30.  
  <br/>
  <a href="https://yammam-cafe-main-olbq74.laravel.cloud" target="_blank"><strong>🌐 Visit Website</strong></a>
</p>

---

## ✨ Features
- Digital menu for all café products (fixed & weekly specials)  
- Easy ordering system for café customers
- Suggestions & feedback submission by users  
- Admin dashboard to manage products, view orders, and track suggestions  
- Weekly sales & activity statistics  

---

## 🛠️ Tech Stack
- **Laravel 11** – Backend framework  
- **MySQL** – Database  
- **Blade + Tailwind CSS** – Responsive frontend (desktop & mobile)  
- **Laravel Cloud** – Deployment  

---

## 🚀 Installation
```bash
git clone https://github.com/Wtedev/yammam-cafe.git
cd yammam-cafe
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
