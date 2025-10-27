Warung Aripin - Simple Kelontong Web

Folder: Warung_Aripin

Files:

- index.html (landing)
- shop.php (toko + form)
- process_order.php (simpan order ke SQLite)
- seed_db.php (seeder PHP)
- assets/css/style.css
- assets/js/main.js
- assets/img/logo.svg
- assets/img/item-placeholder.svg

Quick start (Windows PowerShell):

1. Seed DB (from project folder):
   php .\seed_db.php

2. Start PHP dev server:
   php -S localhost:8000

3. Open browser: http://localhost:8000/index.html or http://localhost:8000/shop.php

If you use Laragon/XAMPP, place `Warung_Aripin` in your www/htdocs and open via local host.

Notes:

- Orders saved to `data/db.sqlite`.
- If `php` or `python` CLI not in PATH, use Laragon/XAMPP or install PHP.
- This demo is minimal and not production-hardened.

Admin & receipts:

- Untuk melihat daftar pesanan: buka `admin_orders.php` (mis. http://localhost:8000/admin_orders.php)
- Untuk melihat detail pesanan: klik tombol "Lihat" dari daftar atau buka `order_view.php?id=ORDER_ID`.
- Untuk print atau melihat struk: buka `receipt.php?id=ORDER_ID`.
- Untuk mengirim struk via email (jika PHP mail() tersedia): kunjungi `send_receipt.php?id=ORDER_ID&to=you@example.com`.

Stock behavior:

- Items now have a `stock` column. The seeder sets initial stock values.
- The shop shows remaining stock and disables the "Tambah" button when the cart reaches stock.
- On checkout the server checks stock atomically and decrements stock. If any item has insufficient stock the order is aborted and an error is shown.

To reseed/reset stock: delete `data/db.sqlite` and run:
php .\seed_db.php

Cancel order (admin):

- Buka `order_view.php?id=ORDER_ID` dari `admin_orders.php`.
- Klik tombol "Batalkan Pesanan" untuk mengembalikan stok secara otomatis. Sistem akan menandai order sebagai `canceled` dan menyimpan waktu pembatalan.

Upload gambar produk:

- Buka `admin_upload.php` di browser (mis. http://localhost:8000/admin_upload.php).
- Pilih produk dari daftar, pilih file gambar (png/jpg), lalu klik Upload.
- Gambar disimpan ke `assets/img/products/` dan kolom `items.image` di DB diupdate.
