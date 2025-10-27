<?php
// seed_db.php - Seed SQLite DB using PHP (useful if Python isn't installed)
$dbDir = __DIR__ . '/data';
if (!is_dir($dbDir)) mkdir($dbDir, 0755, true);
$dbFile = $dbDir . '/db.sqlite';
$db = new PDO('sqlite:' . $dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS items(id INTEGER PRIMARY KEY, name TEXT, description TEXT, price INTEGER);");
$db->exec("CREATE TABLE IF NOT EXISTS payment_methods(id INTEGER PRIMARY KEY, method TEXT);");
$db->exec("CREATE TABLE IF NOT EXISTS customers(id INTEGER PRIMARY KEY, name TEXT, address TEXT, phone TEXT);");
$db->exec("CREATE TABLE IF NOT EXISTS orders(id INTEGER PRIMARY KEY, customer_id INTEGER, total INTEGER, payment_method INTEGER, items TEXT, created_at TEXT);");

$items = [
  [1, 'Beras 5kg', 'Beras kualitas baik', 65000],
  [2, 'Gula 1kg', 'Gula pasir 1kg', 12000],
  [3, 'Minyak 2L', 'Minyak goreng botol 2L', 38000],
  [4, 'Indomie', 'Mie instan (1 pack)', 3500],
  [5, 'Sapu', 'Sapu lidi', 25000],
  [6, 'Kopi', 'Kopi bubuk 200g', 30000],
  [7, 'Teh Celup', 20000],
  [8, 'Sabun Mandi', 'Sabun mandi batang', 8000],
  [9, 'Shampoo', 'Shampoo 200ml', 25000],
  [10, 'Pasta Gigi', 'Pasta gigi 100g', 12000],
  [11, 'Sikat Gigi', 'Sikat gigi', 7000],
  [12, 'Tepung Terigu', 'Tepung terigu 1kg', 14000],
  [13, 'Kecap Manis', 'Kecap manis botol 500ml', 18000],
  [14, 'Saus Tomat', 'Saus tomat botol 300ml', 12000],
  [15, 'Rokok', 'Rokok filter (1 pack)', 35000],
  [16, 'Minuman Ringan', 'Minuman ringan kaleng', 7000],
  [17, 'Air Mineral', 'Air mineral botol 600ml', 5000],
  [18, 'Cokelat', 'Cokelat batang 100g', 15000],
  [19, 'Permen', 'Permen karet 10 pcs', 3000],
  [20, 'Kue Kering', 'Kue kering 250g', 20000],

];
$stmt = $db->prepare('INSERT OR REPLACE INTO items(id,name,description,price) VALUES(?,?,?,?)');
foreach ($items as $it) {
  $stmt->execute($it);
}

$payments = [[1, 'Tunai'], [2, 'Transfer Bank'], [3, 'QRIS']];
$stmt = $db->prepare('INSERT OR REPLACE INTO payment_methods(id,method) VALUES(?,?)');
foreach ($payments as $p) {
  $stmt->execute($p);
}

echo "Seeded: $dbFile\n";
