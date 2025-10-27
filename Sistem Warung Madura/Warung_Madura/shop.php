<?php
// Simple shop page for Warung Aripin
$dbFile = __DIR__ . '/data/db.sqlite';
$items = [];
$payments = [];
if (file_exists($dbFile)) {
  $db = new PDO('sqlite:' . $dbFile);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $db->query('SELECT id,name,description,price FROM items');
  $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt = $db->query('SELECT id,method FROM payment_methods');
  $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // fallback sample items
  $items = [
    ['id' => 1, 'name' => 'Beras 5kg', 'description' => 'Beras kualitas baik', 'price' => 65000],
    ['id' => 2, 'name' => 'Gula 1kg', 'description' => 'Gula pasir', 'price' => 12000],
    ['id' => 3, 'name' => 'Minyak 2L', 'description' => 'Minyak goreng', 'price' => 38000],
    ['id' => 4, 'name' => 'Indomie', 'description' => 'Mie instan (1 pack)', 'price' => 3500],
    ['id' => 5, 'name' => 'Sapu', 'description' => 'Sapu lidi', 'price' => 25000],
    ['id' => 6, 'name' => 'Kopi', 'description' => 'Kopi bubuk 200g', 'price' => 30000],
    ['id' => 7, 'name' => 'Teh Celup', 'description' => 'Teh celup 25 kantong', 'price' => 15000],
    ['id' => 8, 'name' => 'Sabun Mandi', 'description' => 'Sabun mandi batang', 'price' => 8000],
    ['id' => 9, 'name' => 'Shampoo', 'description' => 'Shampoo 200ml', 'price' => 25000],
    ['id' => 10, 'name' => 'Pasta Gigi', 'description' => 'Pasta gigi 100g', 'price' => 12000],
    ['id' => 11, 'name' => 'Sikat Gigi', 'description' => 'Sikat gigi', 'price' => 7000],
    ['id' => 12, 'name' => 'Tepung Terigu', 'description' => 'Tepung terigu 1kg', 'price' => 14000],
    ['id' => 13, 'name' => 'Kecap Manis', 'description' => 'Kecap manis botol 500ml', 'price' => 18000],
    ['id' => 14, 'name' => 'Saus Tomat', 'description' => 'Saus tomat botol 300ml', 'price' => 12000],
    ['id' => 15, 'name' => 'Rokok', 'description' => 'Mie instan (1 pack)', 'price' => 3500],
    ['id' => 16, 'name' => 'Minuman Ringan', 'description' => 'Minuman ringan kaleng', 'price' => 7000],
    ['id' => 17, 'name' => 'Air Mineral', 'description' => 'Air mineral botol 600ml', 'price' => 5000],
    ['id' => 18, 'name' => 'Cokelat', 'description' => 'Cokelat batang 100g', 'price' => 15000],
    ['id' => 19, 'name' => 'Permen', 'description' => 'Permen karet 10 pcs', 'price' => 3000],
    ['id' => 20, 'name' => 'Kue Kering', 'description' => 'Kue kering 250g', 'price' => 20000],
  ];
  $payments = [
    ['id' => 1, 'method' => 'Tunai'],
    ['id' => 2, 'method' => 'Transfer Bank'],
    ['id' => 3, 'method' => 'QRIS']
  ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Warung Aripin - Shop</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <div class="container">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
      <img src="assets/img/logo.svg" class="logo" alt="logo" />
      <div>
        <h1>Warung Aripin</h1>
        <div class="small">Kelontong & kebutuhan sehari-hari</div>
      </div>
    </div>

    <div class="shop-grid">
      <div class="card">
        <h3>Daftar Barang</h3>
        <div class="items">
          <?php foreach ($items as $it): ?>
            <div class="item">
              <img src="assets/img/item-placeholder.svg" alt="<?= htmlspecialchars($it['name']) ?>" />
              <div style="flex:1">
                <h4><?= htmlspecialchars($it['name']) ?> <span class="price">Rp <?= number_format($it['price'], 0, ',', '.') ?></span></h4>
                <p class="small"><?= htmlspecialchars($it['description']) ?></p>
              </div>
              <div>
                <button onclick="addToCart('<?= $it['id'] ?>')" class="btn">Tambah</button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <aside class="card cart">
        <h3>Keranjang</h3>
        <div id="cart-contents" class="small"></div>
        <div style="margin-top:8px;font-weight:700">Total: <span id="cart-total">Rp 0</span></div>

        <form method="post" action="process_order.php" style="margin-top:12px">
          <div class="field">
            <label>Nama</label>
            <input name="name" required class="input" />
          </div>
          <div class="field">
            <label>Alamat</label>
            <textarea name="address" required class="input"></textarea>
          </div>
          <div class="field">
            <label>No. Telepon</label>
            <input name="phone" required class="input" />
          </div>
          <div class="field">
            <label>Metode Pembayaran</label>
            <select name="payment_method" class="input">
              <?php foreach ($payments as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['method']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <input type="hidden" name="order_total" id="order_total" />
          <input type="hidden" name="order_items" id="order_items" />

          <div class="checkout">
            <button type="submit">Pesan Sekarang</button>
            <a href="index.html" class="btn">Kembali</a>
          </div>
        </form>

        <div class="footer">Pastikan data sudah benar sebelum memesan.</div>
      </aside>
    </div>

    <div class="footer">© <?= date('Y') ?> Warung Aripin</div>
  </div>

  <script>
    window.WM_ITEMS = <?= json_encode($items) ?>;
  </script>
  <script src="assets/js/main.js"></script>
</body>

</html>