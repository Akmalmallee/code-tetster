<?php
$id = intval($_GET['id'] ?? 0);
$dbFile = __DIR__ . '/data/db.sqlite';
$order = null;
if ($id && file_exists($dbFile)) {
  $db = new PDO('sqlite:' . $dbFile);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $db->prepare('SELECT o.*, c.name,c.address,c.phone FROM orders o LEFT JOIN customers c ON c.id = o.customer_id WHERE o.id = :id');
  $stmt->execute([':id' => $id]);
  $order = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($order) $order['items'] = json_decode($order['items'], true) ?: [];
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Receipt #<?= $id ?></title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <div class="container">
    <?php if (!$order): ?><div class="card">Pesanan tidak ditemukan.</div><?php else: ?>
      <div class="card">
        <h2>Struk Pembayaran - Warung Aripin</h2>
        <p><strong>Order #<?= $order['id'] ?></strong></p>
        <p><?= htmlspecialchars($order['name']) ?> — <?= htmlspecialchars($order['phone']) ?></p>
        <hr />
        <table style="width:100%;border-collapse:collapse">
          <?php foreach ($order['items'] as $s): ?>
            <tr>
              <td><?= htmlspecialchars($s['name']) ?> x<?= intval($s['qty']) ?></td>
              <td align="right">Rp <?= number_format($s['subtotal'], 0, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td><strong>Total</strong></td>
            <td align="right"><strong>Rp <?= number_format($order['total'], 0, ',', '.') ?></strong></td>
          </tr>
        </table>
        <p>Terima kasih sudah berbelanja.</p>
      </div>
      <div style="margin-top:12px"><button onclick="window.print()" class="btn">Print</button> <a class="btn" href="shop.php">Kembali</a></div>
    <?php endif; ?>
  </div>
</body>

</html>