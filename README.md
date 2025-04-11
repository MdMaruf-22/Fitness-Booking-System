
# 🏋️ Fitness Booking System

A modern Laravel-based Fitness Booking Platform where users can book fitness classes, make payments, receive notifications, manage attendance, and more. The system supports multiple roles: **Admin**, **Receptionist**, **Instructor**, and **Member**.

---

## 🚀 Features

### ✅ General Features
- User Registration & Login (Laravel Breeze)
- Role-based Access Control:
  - Admin
  - Receptionist
  - Instructor
  - Member
- Modern UI with Tailwind CSS & Alpine.js
- Responsive Dark Mode
- Dashboard Layout for Each Role

---

### 📅 Fitness Class Management
- Class creation, editing, deletion (by Receptionist)
- Details include class time, instructor, capacity, etc.
- Members can view and book available classes
- Capacity limit enforced
- Instructor can view only their assigned classes
- Class listing with filters and sorting

---

### 💳 Payment System
- **Two Payment Options**:
  - Card Payment
  - Mobile Banking (bKash, Rocket, Nagad)
- Custom-designed payment UI 
- Bookings are saved only after **payment confirmation**
- Receipt generated upon successful payment

---

### 🧾 Email Billing + Invoice Attachments ✅
- After booking + payment, invoice is auto-generated as PDF and sent via email
- Uses Laravel’s Mailables + PDF package (DOMPDF)
- Invoice includes class, amount, method, and booking info

---

### 🔔 Notifications System
- Booking Confirmed
- Booking Cancelled
- Class Updated
- Email to user account and Real-time dropdown notifications
- Alpine.js + Tailwind UI components

---

### 📅 Google Calendar Integration ✅
- After booking, class details are added to Google Calendar
- Uses OAuth2 + Google Calendar API
- Adds class with proper time, instructor, and reminders

---

### 📈 Admin Dashboard
- Total Registered Users
- Users by Role
- Total Fitness Classes
- Total Bookings
- Total Revenue
- Recent Bookings & Registrations
- **Chart.js Visualizations**:
  - Monthly Revenue
  - Booking Trends
  - User Role Distribution
- Export Reports:
  - CSV or PDF

---

### 👨‍🏫 Instructor Dashboard
- Assigned Class List
- Attendee List per Class
- Attendance Marking Feature
- Calendar View of Classes
- Attendance Stats and Trends

---

### 👥 Member Dashboard
- Browse Available Classes
- Book and Pay for Classes
- View Upcoming Bookings
- Cancel Bookings (if allowed)
- Calendar View of Enrolled Classes

---

## 🧑‍💻 Technologies Used

- Laravel 10
- Laravel Breeze (Auth Scaffolding)
- Tailwind CSS 3
- Alpine.js
- MySQL
- Chart.js (for Reports & Dashboards)
- DOMPDF (Invoices)
- Google Calendar API
- Vite (Asset Bundling)
- Custom SSLCommerz-style Payment UI

---

## ⚙️ Installation

1. **Clone the Repository**

```bash
git clone https://github.com/yourusername/fitness-booking-system.git
cd fitness-booking-system
```

2. **Install Dependencies**

```bash
composer install
npm install && npm run dev
```

3. **Environment Configuration**

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env`:

```env
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Fitness Booking"

GOOGLE_APPLICATION_CREDENTIALS=path_to_your_json_file
GOOGLE_CALENDAR_ID=google_calendar_id
```

4. **Run Migrations and Seeders**

```bash
php artisan migrate --seed
```

5. **Serve the Application**

```bash
php artisan serve
```

---

## 🛠 Role Assignment at Registration

During registration, users can select their role:

```blade
<select name="role" required>
  <option value="member">Member</option>
  <option value="instructor">Instructor</option>
  <option value="receptionist">Receptionist</option>
</select>
```

- The selected role is stored in the `users` table.
- Role-based middleware controls route access.
- Some roles (like Instructor, Receptionist) require **admin approval** to be activated.

---

## 📁 Folder Structure Overview

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── views/
│   ├── js/
│   └── css/
├── routes/
│   ├── web.php
│   └── api.php
├── .env
└── README.md
```

---

## 📌 Roadmap / TODO
- [ ] Real Payment Gateway (SSLCommerz / Stripe)
- [ ] Promo Code / Discount Coupons
- [ ] Class Popularity Analytics
- [ ] Attendance Rate Reports
- [ ] Instructor Availability Scheduling
- [ ] Mobile App Integration (Flutter)
- [ ] Push Notifications

---

## 🤝 Contributing

Pull requests are welcome!  
Fork the repository, create your feature branch, commit your changes, push, and open a PR.

---

## 📝 License

© [Mohammed Maruf Islam]
