# Testing QRIS Feature

## Cara Test Fitur QRIS

### 1. Setup & Run
```bash
php artisan serve
```

### 2. Buat Order dengan QRIS

1. Buka: `http://localhost:8000`
2. Login sebagai user (optional) atau langsung belanja
3. Pilih kategori game (contoh: Mobile Legends)
4. Pilih produk (contoh: 100 Diamond - Rp 25,000)
5. Klik "Tambah ke Keranjang" atau "Beli Sekarang"
6. Di halaman checkout, isi form:
   - Nama: Test User
   - Email: test@example.com
   - WhatsApp: 081234567890
   - ID Game: 123456789
   - **Metode Pembayaran: QRIS** ← Pilih ini
7. Klik "Lanjutkan Pembayaran"

### 3. Lihat QRIS Dinamis

Di halaman pembayaran, Anda akan melihat:

✅ **QR Code** dengan ukuran 256x256 pixels
✅ **Countdown Timer** menghitung mundur dari 60 detik
✅ **Nomor Rekening** ditampilkan: 4940220195
✅ **Border Purple** pada QR code untuk visual menarik

### 4. Observe Auto-Refresh

- Tunggu countdown hingga 0
- QR Code akan **otomatis berubah**
- Countdown reset ke 60 detik
- Proses terus berulang selama halaman aktif

### 5. Visual Indicators

**Countdown Normal (60-11 detik):**
- Warna: Purple (#6B21A8)
- Status: Normal

**Countdown Warning (<10 detik):**
- Warna: Merah
- Status: Akan segera refresh

### 6. Data QRIS yang Digenerate

Format data dalam QR Code:
```
4940220195|25000|ORD-20241202-ABC123|1701523200
```

Keterangan:
- `4940220195` = Nomor Rekening
- `25000` = Total Amount
- `ORD-20241202-ABC123` = Order Number
- `1701523200` = Unix Timestamp

### 7. Test di Different Devices

**Desktop:**
- Open browser, test di Chrome/Firefox/Edge
- Lihat responsive layout

**Mobile:**
- Buka di smartphone
- QR Code akan responsive (ukuran menyesuaikan)
- Bisa langsung scan dari device lain

**Tablet:**
- Layout tetap optimal
- Touch-friendly

### 8. Browser Console Testing

Buka Developer Tools (F12) dan cek:

```javascript
// Lihat interval countdown
console.log("Countdown:", countdown);

// Check QR code URL
console.log("QRIS URL:", document.getElementById('qris-code').src);
```

### 9. Network Testing

**Check API Call:**
- Buka Network tab di DevTools
- Setiap 60 detik akan ada request ke:
  `https://api.qrserver.com/v1/create-qr-code/...`

**Parameters yang dikirim:**
- `size=256x256`
- `data=[encoded data]`
- `bgcolor=FFFFFF`
- `color=6B21A8`
- `margin=10`

### 10. Upload Bukti Pembayaran

Setelah "bayar" (simulasi):
1. Scroll ke bawah form
2. Klik "Choose File"
3. Upload screenshot/image
4. Klik "Kirim Bukti Pembayaran"
5. Redirect ke detail order

### 11. Verifikasi di Admin

1. Login admin: `http://localhost:8000/admin/login`
   - Email: admin@topupstore.com
   - Password: password

2. Buka menu "Pembayaran"
3. Lihat pembayaran dengan QRIS
4. Klik "Detail"
5. Lihat bukti pembayaran
6. Klik "Approve" untuk menyetujui

### 12. Edge Cases Testing

**Test 1: Multiple Tabs**
- Buka 2 tab dengan halaman pembayaran yang sama
- Kedua QR code akan refresh independent

**Test 2: Page Reload**
- Refresh halaman saat countdown
- QR code akan regenerate dengan timestamp baru
- Countdown reset ke 60

**Test 3: Network Error**
- Disable internet sementara
- QR code akan gagal load (broken image)
- Enable internet kembali
- Wait sampai countdown = 0 untuk auto-refresh

**Test 4: Long Running**
- Biarkan halaman berjalan 5+ menit
- QR code akan terus refresh setiap 60 detik
- Memory usage tetap stabil

### 13. Performance Check

Buka Performance Monitor:
- CPU usage: Minimal (hanya timer 1 detik)
- Memory: Stabil (tidak ada memory leak)
- Network: Request setiap 60 detik (sangat ringan)

### 14. Customization Test

Edit `payment.blade.php` untuk test:

**Ubah Countdown Duration:**
```javascript
countdown = 30; // 30 detik instead of 60
```

**Ubah QR Size:**
```javascript
size=512x512 // Bigger QR code
```

**Ubah Colors:**
```javascript
color=FF0000 // Red QR code
bgcolor=000000 // Black background
```

### 15. Integration Ready

Untuk integrasi payment gateway real:

1. Daftar di provider (Midtrans, QRIS Indonesia)
2. Dapatkan API Key
3. Replace URL generator:
```javascript
// Old
const qrCodeUrl = `https://api.qrserver.com/v1/...`;

// New
const qrCodeUrl = await fetch('/api/generate-qris', {
    method: 'POST',
    body: JSON.stringify({
        amount: {{ $order->total_amount }},
        orderNumber: '{{ $order->order_number }}'
    })
});
```

### Expected Results

✅ QR Code tampil dengan jelas
✅ Countdown berjalan smooth
✅ Auto-refresh setiap 60 detik
✅ Nomor rekening ditampilkan
✅ Upload bukti berhasil
✅ Responsive di semua device
✅ No console errors
✅ Memory stable

### Troubleshooting

**QR Code tidak muncul:**
- Check internet connection
- Check browser console untuk errors
- Verify API URL accessible

**Countdown tidak jalan:**
- Check JavaScript enabled
- Check browser console
- Verify script loaded

**QR Code tidak refresh:**
- Check interval masih running
- Check countdown logic
- Verify regenerateQRIS() dipanggil

## Success Indicators

- ✅ QR Code visible dan scannable
- ✅ Timer countdown working
- ✅ Auto-refresh after 60 seconds
- ✅ Visual feedback (color change)
- ✅ Data akurat dalam QR
- ✅ Upload bukti sukses
- ✅ Admin bisa verifikasi

## Demo Video Steps

1. Start recording
2. Buka homepage
3. Pilih produk
4. Checkout dengan QRIS
5. Show QR code
6. Wait countdown (speed up video)
7. Show auto-refresh
8. Upload bukti
9. Login admin
10. Approve payment
11. Show completed order

---

**Happy Testing! 🧪💳**
