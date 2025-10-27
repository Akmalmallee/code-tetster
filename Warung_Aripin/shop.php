<?php
$dbFile = __DIR__ . '/data/db.sqlite';
$items = [];
$payments = [];
if (file_exists($dbFile)) {
  $db = new PDO('sqlite:' . $dbFile);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $items = $db->query('SELECT id,name,description,price,stock,image FROM items')->fetchAll(PDO::FETCH_ASSOC);
  $payments = $db->query('SELECT id,method FROM payment_methods')->fetchAll(PDO::FETCH_ASSOC);
} else {
  $items = [
    ['id' => 1, 'name' => 'Beras 5kg', 'description' => 'Beras kualitas baik', 'price' => 65000, 'stock' => 10],
    ['id' => 2, 'name' => 'Gula 1kg', 'description' => 'Gula pasir', 'price' => 12000, 'stock' => 15],
    ['id' => 3, 'name' => 'Minyak 2L', 'description' => 'Minyak goreng', 'price' => 38000, 'stock' => 8],
    ['id' => 4, 'name' => 'Indomie', 'description' => 'Mie instan (1 pack)', 'price' => 3500, 'stock' => 50],
  ];
  $payments = [['id' => 1, 'method' => 'Tunai'], ['id' => 2, 'method' => 'Transfer Bank'], ['id' => 3, 'method' => 'QRIS']];
}
?>
<!doctype html>
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
      <div class="cart-icon" onclick="window.scrollTo({top:document.body.scrollHeight,behavior:'smooth'})">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6 6h15l-1.5 9h-12z" stroke="#0f172a" stroke-width="1.2" stroke-linejoin="round" stroke-linecap="round" />
        </svg>
        <div id="cart-badge" class="cart-badge">0</div>
      </div>
    </div>

    <div class="shop-grid">
      <div class="card">
        <h3>Daftar Barang</h3>
        <div class="search-box">
          <input id="item-search" placeholder="Cari barang..." />
          <button class="btn" onclick="document.getElementById('item-search').value=''; filterItems(); return false;">Reset</button>
        </div>

        <div class="items scrollable" id="items-list">
          <?php foreach ($items as $it): ?>
            <div class="item" data-name="<?= htmlspecialchars(strtolower($it['name'])) ?>">
              <?php $img = !empty($it['image']) ? 'assets/img/' . $it['image'] : 'assets/img/item-placeholder.svg'; ?>
              <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($it['name']) ?>" />
              <div style="flex:1">
                <h4><?= htmlspecialchars($it['name']) ?> <span class="price">Rp <?= number_format($it['price'], 0, ',', '.') ?></span></h4>
                <p class="small"><?= htmlspecialchars($it['description']) ?></p>
                <p class="small">Stok: <strong><?= intval($it['stock'] ?? 0) ?></strong>
                  <?php if (intval($it['stock'] ?? 0) <= 3 && intval($it['stock'] ?? 0) > 0): ?>
                    <span class="low-stock">&nbsp; (Stok sedikit)</span>
                  <?php endif; ?>
                </p>
              </div>
              <div class="item-controls">
                <button class="btn-minus" onclick="removeFromCart('<?= $it['id'] ?>')">-</button>
                <div class="qty-badge" id="badge-<?= $it['id'] ?>">0</div>
                <button onclick="addToCart('<?= $it['id'] ?>')" class="btn">+</button>
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
          <div class="field"><label>Nama</label><input name="name" required class="input" /></div>
          <div class="field"><label>Alamat</label><textarea name="address" required class="input"></textarea></div>
          <div class="field"><label>No. Telepon</label><input name="phone" required class="input" /></div>
          <div class="field"><label>Metode Pembayaran</label>
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
    window.WA_ITEMS = <?= json_encode($items) ?>;
  </script>
  <script src="assets/js/main.js"></script>
</body>

</html>