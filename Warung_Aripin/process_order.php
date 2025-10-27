<?php
$dbDir = __DIR__ . '/data';
if (!is_dir($dbDir)) mkdir($dbDir, 0755, true);
$dbFile = $dbDir . '/db.sqlite';
$db = new PDO('sqlite:' . $dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS customers(id INTEGER PRIMARY KEY, name TEXT, address TEXT, phone TEXT);");
$db->exec("CREATE TABLE IF NOT EXISTS orders(id INTEGER PRIMARY KEY, customer_id INTEGER, total INTEGER, payment_method INTEGER, items TEXT, created_at TEXT);");
$db->exec("CREATE TABLE IF NOT EXISTS payment_methods(id INTEGER PRIMARY KEY, method TEXT);");
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: shop.php');
  exit;
}
$name = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$payment = intval($_POST['payment_method'] ?? 0);
$total = intval($_POST['order_total'] ?? 0);
$items = $_POST['order_items'] ?? '{}';

// basic server-side validation
$errors = [];
if ($name === '') $errors[] = 'Nama harus diisi.';
if ($address === '') $errors[] = 'Alamat harus diisi.';
if ($phone === '') $errors[] = 'No. telepon harus diisi.';
// items should be a JSON mapping id->qty
$decodedItems = json_decode($items, true);
if (!is_array($decodedItems) || count($decodedItems) === 0) $errors[] = 'Keranjang kosong. Tambahkan barang terlebih dahulu.';

if (!empty($errors)) {
  // show simple error page
?>
  <!doctype html>
  <html lang="id">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kesalahan - Warung Aripin</title>
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>

  <body>
    <div class="container">
      <div class="card" style="border-left:4px solid #f43f5e;">
        <h3>Ada kesalahan pada form</h3>
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
        <a href="shop.php" class="btn">Kembali ke toko</a>
      </div>
    </div>
  </body>

  </html>
  <?php
  exit;
}

// save customer
$stmt = $db->prepare('INSERT INTO customers(name,address,phone) VALUES(:n,:a,:p)');
$stmt->execute([':n' => $name, ':a' => $address, ':p' => $phone]);
$customer_id = $db->lastInsertId();

// Resolve items from DB to create snapshot (name,price,qty,subtotal)
$snapshot = [];
$serverTotal = 0;
// fetch available items from DB or fallback
$available = [];
try {
  $rows = $db->query('SELECT id,name,price FROM items')->fetchAll(PDO::FETCH_ASSOC);
  foreach ($rows as $r) $available[$r['id']] = $r;
} catch (Exception $e) {
  // fallback sample map
  $available = [1 => ['id' => 1, 'name' => 'Beras 5kg', 'price' => 65000], 2 => ['id' => 2, 'name' => 'Gula 1kg', 'price' => 12000], 3 => ['id' => 3, 'name' => 'Minyak 2L', 'price' => 38000], 4 => ['id' => 4, 'name' => 'Indomie', 'price' => 3500]];
}

foreach ($decodedItems as $idStr => $qty) {
  $id = intval($idStr);
  $qty = intval($qty);
  if ($qty <= 0) continue;
  if (!isset($available[$id])) continue; // ignore unknown item
  $it = $available[$id];
  $subtotal = $it['price'] * $qty;
  $serverTotal += $subtotal;
  $snapshot[] = ['id' => $id, 'name' => $it['name'], 'price' => $it['price'], 'qty' => $qty, 'subtotal' => $subtotal];
}

// use serverTotal as canonical total (prevent tampering)
$total = $serverTotal;

// Attempt to decrement stock and save order atomically
$db->beginTransaction();
$ok = true;
try {
  foreach ($snapshot as $s) {
    // get current stock
    $q = $db->prepare('SELECT stock FROM items WHERE id = :id');
    $q->execute([':id' => $s['id']]);
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $currentStock = $row ? intval($row['stock']) : 0;
    if ($currentStock < $s['qty']) {
      $ok = false;
      break;
    }
    // decrement
    $u = $db->prepare('UPDATE items SET stock = stock - :qty WHERE id = :id');
    $u->execute([':qty' => $s['qty'], ':id' => $s['id']]);
  }
  if (!$ok) {
    $db->rollBack();
    // show out-of-stock error
  ?>
    <!doctype html>
    <html lang="id">

    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width,initial-scale=1" />
      <title>Stok Tidak Cukup</title>
      <link rel="stylesheet" href="assets/css/style.css" />
    </head>

    <body>
      <div class="container">
        <div class="card" style="border-left:4px solid #f43f5e;">
          <h3>Stok tidak mencukupi</h3>
          <p>Beberapa item dalam keranjang melebihi stok yang tersedia. Silakan cek kembali keranjang Anda.</p>
          <a href="shop.php" class="btn">Kembali ke toko</a>
        </div>
      </div>
    </body>

    </html>
  <?php
    exit;
  }

  // save order with snapshot
  $snapshotJson = json_encode($snapshot, JSON_UNESCAPED_UNICODE);
  $stmt = $db->prepare('INSERT INTO orders(customer_id,total,payment_method,items,created_at) VALUES(:c,:t,:pm,:it,:cd)');
  $stmt->execute([':c' => $customer_id, ':t' => $total, ':pm' => $payment, ':it' => $snapshotJson, ':cd' => date('c')]);
  $order_id = $db->lastInsertId();

  $db->commit();
} catch (Exception $e) {
  $db->rollBack();
  // show generic error
  ?>
  <!doctype html>
  <html lang="id">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Error</title>
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>

  <body>
    <div class="container">
      <div class="card" style="border-left:4px solid #f43f5e;">
        <h3>Terjadi kesalahan</h3>
        <p><?= htmlspecialchars($e->getMessage()) ?></p><a href="shop.php" class="btn">Kembali</a>
      </div>
    </div>
  </body>

  </html>
<?php
  exit;
}

// get payment name
$pmName = $payment;
try {
  $s = $db->prepare('SELECT method FROM payment_methods WHERE id = :id');
  $s->execute([':id' => $payment]);
  $r = $s->fetch(PDO::FETCH_ASSOC);
  if ($r) $pmName = $r['method'];
} catch (Exception $e) {
}
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Terima Kasih - Warung Aripin</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <div class="container">
    <div class="card confirm">
      <h2>Terima Kasih, <?= htmlspecialchars($name) ?></h2>
      <p>Nomor pesanan: <strong>#<?= $order_id ?></strong></p>
      <h4>Rincian Pesanan</h4>
      <div>
        <?php if (!empty($snapshot)): ?>
          <table style="width:100%;border-collapse:collapse">
            <thead>
              <tr>
                <th align="left">Barang</th>
                <th align="right">Harga</th>
                <th align="center">Qty</th>
                <th align="right">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($snapshot as $s): ?>
                <tr>
                  <td><?= htmlspecialchars($s['name']) ?></td>
                  <td align="right">Rp <?= number_format($s['price'], 0, ',', '.') ?></td>
                  <td align="center"><?= intval($s['qty']) ?></td>
                  <td align="right">Rp <?= number_format($s['subtotal'], 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="small">Tidak ada item tersimpan.</div>
        <?php endif; ?>
      </div>
      <p style="margin-top:12px">Total: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
      <p>Metode pembayaran: <strong><?= htmlspecialchars($pmName) ?></strong></p>
      <p>Kami akan menghubungi di: <?= htmlspecialchars($phone) ?></p>
      <a href="shop.php" class="btn" style="margin-top:12px;display:inline-block">Kembali ke Toko</a>
    </div>
  </div>
</body>

</html>