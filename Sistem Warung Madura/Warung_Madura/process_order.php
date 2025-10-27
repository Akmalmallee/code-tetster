<?php
// process_order.php - receive POST, store in SQLite (data/db.sqlite)
$dbDir = __DIR__ . '/data';
if (!is_dir($dbDir)) mkdir($dbDir, 0755, true);
$dbFile = $dbDir . '/db.sqlite';
$db = new PDO('sqlite:' . $dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// initialize tables if not exists
$db->exec("CREATE TABLE IF NOT EXISTS customers(id INTEGER PRIMARY KEY, name TEXT, address TEXT, phone TEXT);");
$db->exec("CREATE TABLE IF NOT EXISTS orders(id INTEGER PRIMARY KEY, customer_id INTEGER, total INTEGER, payment_method INTEGER, items TEXT, created_at TEXT);");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $address = $_POST['address'] ?? '';
  $phone = $_POST['phone'] ?? '';
  $payment = intval($_POST['payment_method'] ?? 0);
  $total = intval($_POST['order_total'] ?? 0);
  $items = $_POST['order_items'] ?? '{}';

  $stmt = $db->prepare('INSERT INTO customers(name,address,phone) VALUES(:n,:a,:p)');
  $stmt->execute([':n' => $name, ':a' => $address, ':p' => $phone]);
  $customer_id = $db->lastInsertId();

  $stmt = $db->prepare('INSERT INTO orders(customer_id,total,payment_method,items,created_at) VALUES(:c,:t,:pm,:it,:cd)');
  $stmt->execute([':c' => $customer_id, ':t' => $total, ':pm' => $payment, ':it' => $items, ':cd' => date('c')]);
  $order_id = $db->lastInsertId();
  // try get payment method name
  $pmName = $payment;
  try {
    $s = $db->prepare('SELECT method FROM payment_methods WHERE id = :id');
    $s->execute([':id' => $payment]);
    $r = $s->fetch(PDO::FETCH_ASSOC);
    if ($r) $pmName = $r['method'];
  } catch (Exception $e) { /* ignore */
  }

  // show confirmation
?>
  <!doctype html>
  <html>

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
        <p>Pesanan Anda telah diterima. Nomor pesanan: <strong>#<?= $order_id ?></strong></p>
        <p>Total: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
        <p>Metode pembayaran: <strong><?= htmlspecialchars($pmName) ?></strong></p>
        <p>Kami akan menghubungi di: <?= htmlspecialchars($phone) ?></p>
        <a href="shop.php" class="btn" style="margin-top:12px;display:inline-block">Kembali ke Toko</a>
      </div>
    </div>
  </body>

  </html>
<?php
  exit;
}
header('Location: shop.php');
exit;
?>