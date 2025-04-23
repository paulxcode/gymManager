# 🏋️ GymManager – Web App for Gym Management

**GymManager** is a PHP & MySQL-based web application for managing a fitness center. It offers full CRUD functionalities for subscriptions, users, courses, and reservations. The platform includes both client-facing and admin interfaces, with responsive design and smooth user experience enhancements using **Bootstrap** and **fade-in animations**.

---

## ✨ Features

- 🔐 **Authentication system** (login, registration, session handling)
- 👤 **User management** (admin can view/edit/delete users)
- 📝 **Profile customization** (update personal info)
- 🧾 **Subscription system** (add/edit/delete subscriptions; users can buy)
- 📅 **Course management** (admin CRUD for courses, view schedules)
- 📆 **Reservation system** (users can book or cancel courses)
- 📊 **Admin dashboard** with reports and full control
- 💡 Responsive UI with **Bootstrap** + UI/UX enhancements

---

## 📂 Project Structure

├── assets/ # Images and UI assets ├── CSS/ # Stylesheets (style.css) ├── includes/ # Reusable PHP components (db/auth/navbar/footer) ├── templates/ # Main app pages (admin/client views, forms) │ ├── abonamente.php │ ├── adauga_abonament.php │ ├── adauga_curs.php │ ├── rezervari.php │ └── ... ├── index.php # Landing page ├── login.php # User login ├── register.php # User registration ├── profil.php # User profile ├── raport_abonamente.php # Admin reports


---

## 🧪 What Was Tested

- ✅ Authentication & session protection
- ✅ CRUD operations for users, courses, subscriptions
- ✅ Course reservation logic & validation
- ✅ Admin role access control
- ✅ Interface responsiveness and usability
- ✅ Security against unauthorized access

---

## ⚠️ Challenges Faced

- Mapping many-to-many relationships (users ↔ subscriptions)
- Validating course capacity in real-time during reservation
- Securing admin routes from unauthenticated access
- Ensuring mobile responsiveness for all components

---

## 📸 Screenshots

| Home Page | Admin Panel | Subscription View |
|-----------|-------------|-------------------|
| ![Home](screenshots/home.png) | ![Admin](screenshots/admin.png) | ![Subscriptions](screenshots/subscriptions.png) |

---

## 🚀 Technologies Used

- `PHP 8+`
- `MySQL`
- `HTML5, CSS3`
- `Bootstrap 5`
- `Vanilla JS`
- `Git / GitHub`

---

## 📌 Future Improvements

- 🔔 Notification system for bookings
- 💳 Online payments integration
- ⭐ User feedback & course rating
- 📅 Calendar view for courses

---

## 🧑‍💻 Author

Developed with passion by [Your Name].

