<?php
// Seeder for Warung_Aripin (run with php seed_db.php)
$dbDir = __DIR__ . '/data'; if(!is_dir($dbDir)) mkdir($dbDir,0755,true);
$dbFile = $dbDir . '/db.sqlite';
$db = new PDO('sqlite:'.$dbFile);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS items(id INTEGER PRIMARY KEY, name TEXT, description TEXT, price INTEGER);");
// ensure stock column exists (SQLite doesn't support IF NOT EXISTS for ALTER)
$cols = $db->query("PRAGMA table_info(items)")->fetchAll(PDO::FETCH_ASSOC);
$hasStock = false;
foreach($cols as $c) if($c['name'] === 'stock') $hasStock = true;
if(!$hasStock){
	$db->exec("ALTER TABLE items ADD COLUMN stock INTEGER DEFAULT 0;");
}
// ensure image column exists
$hasImage = false;
foreach($cols as $c) if($c['name'] === 'image') $hasImage = true;
if(!$hasImage){
    $db->exec("ALTER TABLE items ADD COLUMN image TEXT DEFAULT NULL;");
}
$db->exec("CREATE TABLE IF NOT EXISTS payment_methods(id INTEGER PRIMARY KEY, method TEXT);");
$db->exec("CREATE TABLE IF NOT EXISTS customers(id INTEGER PRIMARY KEY, name TEXT, address TEXT, phone TEXT);");
$db->exec("CREATE TABLE IF NOT EXISTS orders(id INTEGER PRIMARY KEY, customer_id INTEGER, total INTEGER, payment_method INTEGER, items TEXT, created_at TEXT);");

$items = [
	[1,'Beras 5kg','Beras kualitas baik',65000,10,'products/placeholder.png'],
	[2,'Gula 1kg','Gula pasir 1kg',12000,15,'products/placeholder.png'],
	[3,'Minyak 2L','Minyak goreng botol 2L',38000,8,'products/placeholder.png'],
	[4,'Indomie','Mie instan (1 pack)',3500,50,'products/placeholder.png'],
	[5,'Sapu','Sapu lidi',25000,5,'products/placeholder.png']
];
// use INSERT OR REPLACE including stock and image
$stmt = $db->prepare('INSERT OR REPLACE INTO items(id,name,description,price,stock,image) VALUES(?,?,?,?,?,?)');
foreach($items as $it) $stmt->execute($it);
$payments = [[1,'Tunai'],[2,'Transfer Bank'],[3,'QRIS']];
$stmt = $db->prepare('INSERT OR REPLACE INTO payment_methods(id,method) VALUES(?,?)');
foreach($payments as $p) $stmt->execute($p);

echo "Seeded DB at: $dbFile\n";
