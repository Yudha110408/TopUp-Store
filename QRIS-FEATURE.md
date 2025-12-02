# Fitur QRIS Dinamis

## Deskripsi
Fitur QRIS dinamis yang akan menggenerate kode QR baru setiap 60 detik untuk keamanan pembayaran.

## Cara Kerja

### 1. Generate QRIS Code
- Kode QRIS dibuat menggunakan kombinasi:
  - Nomor Rekening: **4940220195**
  - Jumlah pembayaran (dari order)
  - Nomor order
  - Timestamp (Unix time)

### 2. Auto Refresh
- Kode QRIS akan otomatis refresh setiap **60 detik**
- Countdown timer ditampilkan untuk user
- Countdown akan berubah merah saat < 10 detik

### 3. Data QRIS Format
```
[Nomor Rekening]|[Amount]|[Order Number]|[Timestamp]
```

Contoh:
```
4940220195|150000|ORD-20241202-ABC123|1701523200
```

## Implementasi

### Frontend (JavaScript)
- **File**: `resources/views/payment.blade.php`
- **API QR Generator**: https://api.qrserver.com/v1/create-qr-code/
- **Auto-refresh**: Setiap 60 detik
- **Countdown**: Update setiap 1 detik

### Fitur Tambahan
1. **Visual Indicator**
   - Border purple pada QR code
   - Shadow effect
   - Countdown dengan warna dinamis

2. **User Experience**
   - Countdown timer real-time
   - Tampilan nomor rekening
   - QR Code dengan resolusi tinggi (256x256)

## Keamanan

1. **Timestamp Based**: Setiap QR code unique berdasarkan waktu
2. **Order Specific**: Terikat dengan nomor order tertentu
3. **Auto Expire**: QR code berubah setiap 60 detik

## Penggunaan

1. Customer pilih metode pembayaran QRIS saat checkout
2. Di halaman pembayaran, scan QR code yang ditampilkan
3. QR code akan otomatis refresh setiap 60 detik
4. Setelah transfer, upload bukti pembayaran
5. Admin verifikasi pembayaran di panel admin

## Customization

### Ubah Interval Refresh
Edit di `payment.blade.php`:
```javascript
countdown = 60; // Ubah sesuai kebutuhan (dalam detik)
```

### Ubah Nomor Rekening
Edit di `payment.blade.php`:
```javascript
const accountNumber = '4940220195'; // Ubah dengan nomor rekening Anda
```

### Ubah Ukuran QR Code
Edit parameter `size` di URL API:
```javascript
const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=256x256&...`;
// Ubah 256x256 ke ukuran lain, misal: 300x300, 512x512
```

### Ubah Warna QR Code
Edit parameter `color` dan `bgcolor`:
```javascript
...&bgcolor=FFFFFF&color=6B21A8&...
// bgcolor = Background color (Putih)
// color = QR color (Purple)
```

## Testing

1. Buat order dengan metode pembayaran QRIS
2. Buka halaman pembayaran
3. Perhatikan countdown timer
4. QR code akan berubah setelah 60 detik
5. Scan QR code dengan aplikasi pembayaran

## Catatan

- **Internet Required**: QR code generator menggunakan API online
- **Fallback**: Jika API gagal, tampilkan error atau fallback image
- **Mobile Friendly**: QR code responsive untuk semua device

## Integrasi Payment Gateway

Untuk integrasi dengan payment gateway real (Midtrans, QRIS Indonesia, dll):

1. Daftar di payment gateway
2. Dapatkan API credentials
3. Ubah logic generate QRIS di `OrderController.php`
4. Replace API QR generator dengan API dari payment gateway
5. Implement callback/webhook untuk auto-confirm payment

## Support

Untuk pertanyaan atau bantuan, hubungi developer.

---
**TopUp Store - QRIS Dynamic Feature** 🎮💳
