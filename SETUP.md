# TopUp Store - Website Jual Topup Game & Akun

Website topup store modern untuk menjual topup game (diamond, robux, UC) dan akun game dengan sistem pembayaran lengkap.

## 🚀 Fitur Lengkap

### Halaman User
- ✅ Home dengan daftar kategori game
- ✅ Halaman kategori dengan list produk
- ✅ Detail produk
- ✅ Shopping cart
- ✅ Checkout dengan form data customer
- ✅ Pilihan metode pembayaran (Bank Transfer, E-Wallet, QRIS)
- ✅ Upload bukti pembayaran
- ✅ Riwayat order (login required)
- ✅ Detail order dengan info akun game jika beli akun

### Halaman Admin
- ✅ Dashboard dengan statistik
- ✅ Login admin
- ✅ Kelola kategori game (CRUD)
- ✅ Kelola produk (CRUD) - item & akun
- ✅ Kelola akun game yang dijual (CRUD)
- ✅ Kelola pesanan (view, update status, delete)
- ✅ Kelola pembayaran (view, approve, reject)

## 📦 Teknologi

- Laravel 11
- PHP 8.2+
- MySQL/PostgreSQL
- Tailwind CSS (via CDN)
- Font Awesome

## 🛠️ Instalasi

1. **Clone atau copy project ini**
```bash
cd topup-store
```

2. **Install dependencies**
```bash
composer install
```

3. **Setup environment**
```bash
copy .env.example .env
php artisan key:generate
```

4. **Konfigurasi database di .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=topup_store
DB_USERNAME=root
DB_PASSWORD=
```

5. **Buat database** (MySQL)
```sql
CREATE DATABASE topup_store;
```

6. **Jalankan migrations dan seeder**
```bash
php artisan migrate --seed
```

7. **Buat symbolic link untuk storage**
```bash
php artisan storage:link
```

8. **Jalankan aplikasi**
```bash
php artisan serve
```

Website akan berjalan di: `http://localhost:8000`

## 👤 Default Login

### Admin
- Email: `admin@topupstore.com`
- Password: `password`
- URL Admin: `http://localhost:8000/admin/login`

### User Demo
- Email: `user@example.com`
- Password: `password`

## 📁 Struktur Database

### Tables
- **users** - Data user dan admin
- **categories** - Kategori game (ML, FF, Roblox, dll)
- **products** - Produk (diamond, robux, akun game)
- **orders** - Data pesanan
- **order_items** - Item dalam pesanan
- **payments** - Data pembayaran
- **accounts** - Akun game yang dijual

## 🎮 Fitur Unggulan

1. **Multi-Type Product**
   - Item (Diamond, Robux, UC)
   - Account (Akun game siap pakai)

2. **Complete Order Flow**
   - Add to cart
   - Checkout with customer info
   - Multiple payment methods
   - Upload payment proof
   - Order tracking

3. **QRIS Dinamis** ⭐ NEW!
   - Generate QR Code otomatis
   - Auto refresh setiap 60 detik
   - Countdown timer real-time
   - Nomor rekening: 4940220195
   - Lihat detail: `QRIS-FEATURE.md`

4. **Admin Panel**
   - Dashboard dengan statistik real-time
   - Manajemen kategori & produk
   - Manajemen akun game
   - Order management dengan filter
   - Payment approval system

4. **Automatic Features**
   - Auto generate order number
   - Auto stock management
   - Auto assign akun saat checkout (untuk tipe account)
   - Payment status tracking

## 🎨 Customization

### Menambah Kategori Game
1. Login ke admin panel
2. Buka menu "Kategori"
3. Klik "Tambah Kategori"
4. Isi nama, deskripsi, upload gambar

### Menambah Produk
1. Buka menu "Produk"
2. Klik "Tambah Produk"
3. Pilih kategori, isi detail produk
4. Pilih tipe (Item atau Account)
5. Set harga dan stok

### Menambah Akun Game
1. Buka menu "Akun"
2. Klik "Tambah Akun"
3. Pilih produk dengan tipe "Account"
4. Isi username, password, detail
5. Stok produk akan otomatis bertambah

## 📝 Catatan Penting

1. **File Upload**
   - Pastikan folder `storage/app/public` writable
   - Sudah menjalankan `php artisan storage:link`

2. **Payment Integration**
   - Payment gateway bisa diintegrasikan di controller `PaymentController`
   - Saat ini menggunakan manual transfer dengan upload bukti

3. **Email Notification**
   - Bisa ditambahkan email notifikasi saat order dibuat
   - Configure SMTP di `.env`

## 🔒 Security

- Admin middleware untuk protect admin routes
- Password hashing
- CSRF protection
- Input validation
- File upload validation

## 📱 Responsive Design

Website sudah responsive dan mobile-friendly menggunakan Tailwind CSS.

## 🐛 Troubleshooting

**Error: Storage link not found**
```bash
php artisan storage:link
```

**Error: Class not found**
```bash
composer dump-autoload
```

**Error: Migration failed**
```bash
php artisan migrate:fresh --seed
```

## 📄 License

Open source - bebas digunakan dan dimodifikasi sesuai kebutuhan.

## 👨‍💻 Support

Untuk pertanyaan atau bantuan, silakan buat issue atau hubungi developer.

---

**Happy Coding! 🚀**
