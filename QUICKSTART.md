# Quick Start Guide - TopUp Store

## Langkah Cepat Setup

### 1. Install Dependencies
```bash
composer install
```

### 2. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database
Edit file `.env`:
```
DB_DATABASE=topup_store
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Database
Buat database MySQL bernama `topup_store`

### 5. Migrate & Seed
```bash
php artisan migrate --seed
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Jalankan Server
```bash
php artisan serve
```

Buka browser: http://localhost:8000

## Login Info

**Admin Panel:** http://localhost:8000/admin/login
- Email: admin@topupstore.com
- Password: password

**User Demo:**
- Email: user@example.com
- Password: password

## Struktur Folder Penting

```
app/
├── Http/Controllers/
│   ├── HomeController.php (Home & Kategori)
│   ├── OrderController.php (Checkout & Order)
│   └── Admin/ (Admin Controllers)
├── Models/ (Category, Product, Order, Payment, Account)
│
resources/views/
├── layouts/
│   ├── app.blade.php (User Layout)
│   └── admin.blade.php (Admin Layout)
├── home.blade.php
├── category.blade.php
├── product.blade.php
├── checkout.blade.php
├── payment.blade.php
├── order-history.blade.php
├── order-detail.blade.php
└── admin/ (Admin Views)
│
database/
├── migrations/ (8 migrations)
└── seeders/
    └── DatabaseSeeder.php (Data demo)
│
routes/
└── web.php (Semua routes)
```

## Fitur Utama

### User Side
1. Browse kategori game
2. Lihat & pilih produk
3. Add to cart
4. Checkout dengan data customer
5. Pilih metode pembayaran (Bank Transfer / E-Wallet / QRIS)
6. **QRIS Dinamis**: QR Code auto-refresh setiap 60 detik
7. Upload bukti transfer
8. Cek status order

### Admin Panel
1. Dashboard statistik
2. Kelola kategori
3. Kelola produk (item & akun)
4. Kelola akun game
5. Kelola pesanan
6. Approve/reject pembayaran

## Testing

### Test Order Flow
1. Buka website
2. Pilih kategori (contoh: Mobile Legends)
3. Pilih produk (contoh: 100 Diamond)
4. Klik "Beli Sekarang"
5. Isi form checkout
6. Lanjut ke pembayaran
7. Upload bukti transfer

### Test Admin
1. Login admin panel
2. Lihat dashboard
3. Buka menu Pembayaran
4. Approve pembayaran yang pending
5. Update status order ke "completed"

## Troubleshooting

**Problem: Storage link error**
```bash
php artisan storage:link
```

**Problem: Class not found**
```bash
composer dump-autoload
```

**Problem: Migration error**
```bash
php artisan migrate:fresh --seed
```

**Problem: Permission denied**
```bash
chmod -R 775 storage bootstrap/cache
```

## Next Steps

1. ✅ Customize tampilan di views
2. ✅ Ubah logo & branding
3. ✅ Tambah kategori & produk
4. ✅ Setup email notifications
5. ✅ Integrasi payment gateway (Midtrans, dll)
6. ✅ Deploy ke hosting

## Support

Lihat file `SETUP.md` untuk dokumentasi lengkap.

---
**Selamat menggunakan TopUp Store! 🎮**
