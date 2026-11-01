# 🏨 Hotel Management System

> Sistem manajemen hotel terintegrasi berbasis web dengan arsitektur MVC, dilengkapi *Role-Based Access Control* (RBAC), dashboard analitik, dan generator PDF.

[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.7.4-EF4223?logo=codeigniter&logoColor=white)](https://codeigniter.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📖 Tentang Proyek

**Hotel Management System** adalah aplikasi web *full-stack* yang dirancang untuk mengelola operasional hotel skala kecil hingga menengah. Proyek ini dibangun sebagai portofolio pribadi dengan fokus pada **arsitektur kode yang bersih**, **keamanan akses (RBAC)**, dan **UI/UX modern**.

Sistem ini mencakup 10+ modul fungsional mulai dari manajemen kamar, reservasi, housekeeping, inventori, hingga pelaporan analitik.

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Otorisasi
- Register, login, logout, dan *magic link* (login via email) menggunakan **CodeIgniter Shield**.
- **Role-Based Access Control (RBAC)** dengan 5 role: `admin`, `manager`, `front_office`, `housekeeping`, `purchasing`.
- Sidebar dan *route protection* otomatis menyesuaikan role user.
- Halaman 403 kustom untuk akses yang ditolak.

### 🛏️ Manajemen Kamar
- CRUD Tipe Kamar (Standard, Deluxe, Suite) dengan harga dasar dan kapasitas.
- CRUD Kamar dengan 6 status: `vacant_clean`, `vacant_dirty`, `occupied`, `on_change`, `out_of_order`, `out_of_service`.
- **Room Status Map** visual (denah) interaktif dengan filter status, pencarian, *tooltip*, dan *auto-refresh*.

### 👥 Manajemen Tamu & Reservasi
- CRUD data tamu dengan validasi.
- Reservasi dengan **workflow 5 status**: pending → confirmed → checked_in → checked_out / cancelled.
- **Anti double-booking** berbasis cek bentrok tanggal.
- Perhitungan harga otomatis (malam × harga kamar).
- **Sinkronisasi otomatis** status kamar saat check-in/check-out.
- **Generator Invoice PDF** dinamis dengan header hotel yang bisa dikonfigurasi.

### 🧹 Housekeeping
- Manajemen tugas kebersihan dengan **4 tahap workflow**: pending → in_progress → done → verified.
- Assign tugas ke staff HK.
- **Upload foto** kondisi kamar dengan validasi MIME & ukuran maksimal.

### 📦 Inventori & Purchasing
- CRUD Barang dengan *tracking* stok, minimum stok, dan *expiry date*.
- **Badge status stok** otomatis (Aman / Menipis / Habis).
- Manajemen Supplier.
- **Store Requisition (SR)** multi-item dengan workflow: pending → approved → delivered / rejected.
- **Stock Movement** otomatis mencatat barang keluar/masuk.

### 📊 Laporan & Analitik
- Dashboard dengan 4 metrik utama (kamar, okupansi, pendapatan, item).
- **Grafik interaktif Chart.js**: Pendapatan Harian, Okupansi Harian, Status Kamar, dan SR per Departemen.
- Top 5 Kamar Paling Sering Dipesan & Top 5 Barang Paling Diminta.
- **Export PDF** dengan *chart* yang di-render sebagai gambar (fitur *advanced*).

### ⚙️ Pengaturan
- Identitas hotel (nama, alamat, telepon, email, logo).
- Konfigurasi pajak & service charge (dipakai di invoice).
- Manajemen user (tambah/edit/hapus/reset password).

---

## 🖼️ Screenshot

### 1. Login Page
![Login](docs/screenshots/01-login.png)
*Split-screen design dengan ilustrasi dan form login*

### 2. Dashboard
![Dashboard](docs/screenshots/02-dashboard.png)
*Dashboard dengan welcome banner, statistik real-time, dan progress bar status kamar*

### 3. Room Status Map
![Room Map](docs/screenshots/03-room-map.png)
*Denah kamar interaktif dengan warna per status dan auto-refresh*

### 4. Manajemen Reservasi
![Reservations](docs/screenshots/04-reservations.png)
*Tabel reservasi dengan pagination, filter, dan badge status workflow*

### 5. Laporan & Analitik
![Reports](docs/screenshots/05-reports.png)
*Dashboard analitik dengan 4 chart interaktif*

### 6. Export PDF Laporan
![PDF Report](docs/screenshots/06-pdf-report.png)
*Laporan PDF dengan chart yang di-render sebagai gambar*

### 7. Invoice PDF
![Invoice](docs/screenshots/07-invoice.png)
*Invoice profesional dengan detail tamu, kamar, dan perhitungan pajak*

### 8. Role-Based Access Control (RBAC)
![RBAC](docs/screenshots/08-rbac.png)
*Sidebar otomatis menyesuaikan role user (contoh: role housekeeping)*

---

## 🛠️ Tech Stack

### Backend
| Teknologi | Versi | Kegunaan |
|---|---|---|
| **PHP** | 8.3.33 | Bahasa utama |
| **CodeIgniter 4** | 4.7.4 | Framework MVC |
| **MySQL** | 8.0.30 | Database |
| **CodeIgniter Shield** | 1.4.1 | Autentikasi & RBAC |
| **Dompdf** | 3.1.6 | Generate PDF |
| **Faker** | Latest | Seeder data test |

### Frontend
| Teknologi | Kegunaan |
|---|---|
| **MDUI v2** | Komponen UI (Material Design 3) |
| **Chart.js** | Grafik interaktif |
| **Flatpickr** | Date picker |
| **Animate.css** | Animasi CSS |
| **Material Symbols** | Ikon |

---

## 🚀 Instalasi

### Prasyarat
- PHP 8.2 atau lebih tinggi (disarankan 8.3)
- MySQL 8.0 atau MariaDB
- Composer
- Web server (Apache/Nginx/Laragon)

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/kimaffan/hotel-management-system.git
cd hotel-management-system
```

**2. Install dependencies**
```bash
composer install
```

**3. Konfigurasi environment**
- Duplikat file `env` menjadi `.env`
- Sesuaikan konfigurasi database:
```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = hotel_management
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

**4. Buat database**
- Buat database baru bernama `hotel_management` di phpMyAdmin.
- Jalankan migrasi dan setup Shield:
```bash
php spark migrate
php spark shield:setup
```

**5. Generate encryption key**
```bash
php spark key:generate
```

**6. Buat user admin pertama**
```bash
php spark shield:user create
# Username: admin
# Email: admin@hotel.test
# Password: (password pilihanmu)

php spark shield:user activate admin
php spark shield:user addgroup admin admin
```

**7. (Opsional) Generate data test**
```bash
php spark db:seed MainSeeder
```

**8. Jalankan aplikasi**
```bash
php spark serve
```
Atau akses via Laragon: `http://hotel-management-system.test`

---

## 🔑 Akun Default (Setelah Seeder)

| Role | Email | Password |
|---|---|---|
| Admin | `admin@hotel.test` | *(sesuai setup)* |
| Manager | `manager1@hotel.test` | `password123` |
| Front Office | `fo1@hotel.test` | `password123` |
| Housekeeping | `hk1@hotel.test` | `password123` |
| Purchasing | `purchasing1@hotel.test` | `password123` |

⚠️ **Ganti password di production!**

---

## 🔐 Role-Based Access Matrix

| Modul | admin | manager | front_office | housekeeping | purchasing |
|---|:---:|:---:|:---:|:---:|:---:|
| Dashboard | ✅ | ✅ | ✅ | ✅ | ✅ |
| Kamar (view) | ✅ | ✅ | ✅ | ✅ | ❌ |
| Kamar (edit) | ✅ | ✅ | ❌ | ❌ | ❌ |
| Tipe Kamar | ✅ | ✅ | ❌ | ❌ | ❌ |
| Denah Kamar | ✅ | ✅ | ✅ | ✅ | ❌ |
| Tamu | ✅ | ✅ | ✅ | ❌ | ❌ |
| Reservasi | ✅ | ✅ | ✅ | ❌ | ❌ |
| Housekeeping | ✅ | ✅ | ❌ | ✅ | ❌ |
| Barang | ✅ | ✅ | ❌ | ❌ | ✅ |
| Supplier | ✅ | ✅ | ❌ | ❌ | ✅ |
| Purchasing | ✅ | ✅ | ❌ | ❌ | ✅ |
| Laporan | ✅ | ✅ | ❌ | ❌ | ❌ |
| Pengaturan | ✅ | ❌ | ❌ | ❌ | ❌ |

---

## 🎓 Konsep yang Dipelajari

Proyek ini mendemonstrasikan berbagai konsep penting:

- ✅ **MVC Pattern** dengan pemisahan tanggung jawab yang jelas
- ✅ **Authentication & Authorization** dengan Shield
- ✅ **Role-Based Access Control** di level route & UI
- ✅ **Database Relations** (One-to-Many, Many-to-Many)
- ✅ **Server-side Pagination** dengan filter dinamis
- ✅ **AJAX** untuk interaksi real-time
- ✅ **File Upload** dengan validasi keamanan
- ✅ **PDF Generation** dengan Dompdf
- ✅ **Chart Rendering** di web & PDF
- ✅ **Database Transactions** untuk integritas data

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 👤 Author

**Khadhor Affan**

- 🌐 Portfolio: [kimaffan.github.io/portofolio](https://kimaffan.github.io/portofolio/)
- 💼 LinkedIn: [linkedin.com/in/khadhor-affan](#)
- 📧 Email: [email kamu]

---

⭐ **Jika proyek ini bermanfaat, jangan lupa berikan bintang!** ⭐
