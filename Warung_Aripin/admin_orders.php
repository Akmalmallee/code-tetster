<?php
$dbFile = __DIR__ . '/data/db.sqlite';
$orders = [];
if (file_exists($dbFile)) {
  $db = new PDO('sqlite:' . $dbFile);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $orders = $db->query('SELECT o.id,o.total,o.created_at,o.status,c.name FROM orders o LEFT JOIN customers c ON c.id = o.customer_id ORDER BY o.created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Orders - Admin</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <div class="container">
    <h2>Daftar Pesanan</h2>
    <?php if (empty($orders)): ?>
      <div class="card small">Belum ada pesanan.</div>
    <?php else: ?>
      <div class="card">
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Total</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $o): ?>
              <tr>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['name']) ?></td>
                <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($o['created_at']) ?></td>
                <td><?= htmlspecialchars($o['status'] ?? 'ok') ?></td>
                <td><a class="btn" href="order_view.php?id=<?= $o['id'] ?>">Lihat</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
    <div style="margin-top:12px"><a href="shop.php" class="btn">Kembali ke Toko</a></div>
  </div>
</body>

</html>