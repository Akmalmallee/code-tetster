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
  if ($order) {
    $order['items'] = json_decode($order['items'], true) ?: [];
    // get payment method name
    $pm = $db->prepare('SELECT method FROM payment_methods WHERE id = :id');
    $pm->execute([':id' => $order['payment_method']]);
    $r = $pm->fetch(PDO::FETCH_ASSOC);
    if ($r) $order['payment_method_name'] = $r['method'];
    else $order['payment_method_name'] = $order['payment_method'];
  }
}
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Order #<?= $id ?></title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <div class="container">
    <?php if (!$order): ?>
      <div class="card">Pesanan tidak ditemukan.</div>
    <?php else: ?>
      <div class="card">
        <h3>Pesanan #<?= $order['id'] ?></h3>
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'canceled'): ?>
          <div class="confirm">Pesanan dibatalkan dan stok dikembalikan.</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'error'): ?>
          <div style="border-left:4px solid #f43f5e;padding:8px">Terjadi kesalahan saat membatalkan.</div>
        <?php endif; ?>
        <p><strong>Status:</strong> <?= htmlspecialchars($order['status'] ?? 'ok') ?></p>
        <p><strong>Nama:</strong> <?= htmlspecialchars($order['name']) ?></p>
        <p><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <h4>Items</h4>
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th>Barang</th>
              <th align="right">Harga</th>
              <th align="center">Qty</th>
              <th align="right">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($order['items'] as $s): ?>
              <tr>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td align="right">Rp <?= number_format($s['price'], 0, ',', '.') ?></td>
                <td align="center"><?= intval($s['qty']) ?></td>
                <td align="right">Rp <?= number_format($s['subtotal'], 0, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p style="margin-top:8px"><strong>Total:</strong> Rp <?= number_format($order['total'], 0, ',', '.') ?></p>
        <p><strong>Payment:</strong> <?= htmlspecialchars($order['payment_method_name']) ?></p>
        <p><strong>Tanggal:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
        <?php if (($order['status'] ?? 'ok') !== 'canceled'): ?>
          <form method="post" action="cancel_order.php" onsubmit="return confirm('Batalkan pesanan ini dan kembalikan stok?');">
            <input type="hidden" name="id" value="<?= $order['id'] ?>" />
            <button type="submit" class="btn" style="margin-top:8px;background:#ef4444">Batalkan Pesanan</button>
          </form>
        <?php else: ?>
          <div class="small" style="color:#ef4444;margin-top:8px">Pesanan ini sudah dibatalkan pada <?= htmlspecialchars($order['canceled_at'] ?? '') ?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <div style="margin-top:12px"><a href="admin_orders.php" class="btn">Kembali</a></div>
  </div>
</body>

</html>